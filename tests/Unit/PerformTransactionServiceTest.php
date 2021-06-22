<?php

namespace Unit;

use App\Domains\Store\Store;
use App\Domains\Transaction\Services\PerformTransaction;
use App\Domains\Transaction\Transaction;
use App\Domains\Transaction\TransactionRepository;
use App\Domains\User\User;
use App\Domains\User\UserRepository;
use App\Exceptions\AuthorizationException;
use App\Exceptions\UserException;
use App\ExternalServices\Notify\ExternalNotifier;
use App\ExternalServices\TransactionAuthorizer\ExternalAuthorizer;
use App\Support\CurlClient;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Mockery;
use TestCase;

class PerformTransactionServiceTest extends TestCase
{
    use DatabaseMigrations;

    private PerformTransaction $service;

    public function setUp(): void
    {
        /** @var ExternalAuthorizer $fakeAuthorizer */
        $fakeAuthorizer = Mockery::mock(ExternalAuthorizer::class)
            ->shouldReceive('isAuthorized')
            ->once()
            ->andReturn(true)
            ->getMock();

        /** @var ExternalNotifier $fakeNotifier */
        $fakeNotifier = Mockery::mock(ExternalNotifier::class)
            ->shouldReceive('notifyUser')
            ->once()
            ->andReturn(true)
            ->getMock();

        $this->service = new PerformTransaction(
            new UserRepository(),
            new TransactionRepository(),
            $fakeAuthorizer,
            $fakeNotifier
        );
        parent::setUp();
    }

    public function tearDown(): void
    {
        unset($this->service);
    }

    public function testPerformTransactionFromUserToStore()
    {
        /** @var User $payee */
        $payee = User::factory()->create([
            'isStore' => true,
            'balance' => 100,
        ]);
        Store::factory(['user_id' => $payee->id])->create();
        /** @var User $payer */
        $payer = User::factory()->create([
            'balance' => 100,
        ]);

        $requestData = [
            'value' => 10,
            'payer' => $payer->id,
            'payee' => $payee->id,
        ];

        $newPayerBalance = $payer->balance - $requestData['value'];
        $newPayeeBalance = $payee->balance + $requestData['value'];
        /** @var Transaction $transaction */
        $transaction = $this->service->handle($requestData);
        $this->assertEquals($transaction->payer_id, $payer->id);
        $this->assertEquals($transaction->payee_id, $payee->id);
        $this->assertEquals($transaction->amount, $requestData['value']);
        $this->assertNotNull($transaction->id);
        $this->assertNotNull($transaction->created_at);
        $this->assertNotNull($transaction->updated_at);
        $payer->refresh();
        $payee->refresh();
        $this->assertEquals($payer->balance, $newPayerBalance);
        $this->assertEquals($payee->balance, $newPayeeBalance);
    }

    public function testPerformTransactionFromUserToUser()
    {
        /** @var User $payee */
        $payee = User::factory()->create([
            'balance' => 100,
        ]);
        /** @var User $payer */
        $payer = User::factory()->create([
            'balance' => 100,
        ]);

        $requestData = [
            'value' => 10,
            'payer' => $payer->id,
            'payee' => $payee->id,
        ];

        $newPayerBalance = $payer->balance - $requestData['value'];
        $newPayeeBalance = $payee->balance + $requestData['value'];
        /** @var Transaction $transaction */
        $transaction = $this->service->handle($requestData);
        $this->assertEquals($transaction->payer_id, $payer->id);
        $this->assertEquals($transaction->payee_id, $payee->id);
        $this->assertEquals($transaction->amount, $requestData['value']);
        $this->assertNotNull($transaction->id);
        $this->assertNotNull($transaction->created_at);
        $this->assertNotNull($transaction->updated_at);
        $payer->refresh();
        $payee->refresh();
        $this->assertEquals($payer->balance, $newPayerBalance);
        $this->assertEquals($payee->balance, $newPayeeBalance);
    }

    public function testTryPerformTransactionFromStoreUser()
    {
        /** @var User $payer */
        $payer = User::factory()->create([
            'isStore' => true,
            'balance' => 100,
        ]);
        Store::factory(['user_id' => $payer->id])->create();

        /** @var User $payee */
        $payee = User::factory()->create([
            'balance' => 100,
        ]);

        $requestData = [
            'value' => 10,
            'payer' => $payer->id,
            'payee' => $payee->id,
        ];

        $this->expectException(AuthorizationException::class);
        $this->service->handle($requestData);
    }

    public function testTryPerformPayerTransactionWithoutBalance()
    {
        /** @var User $payer */
        $payer = User::factory()->create([
            'isStore' => false,
            'balance' => 10,
        ]);

        /** @var User $payee */
        $payee = User::factory()->create([
            'balance' => 10,
        ]);

        $requestData = [
            'value' => 20,
            'payer' => $payer->id,
            'payee' => $payee->id,
        ];

        $this->expectException(UserException::class);
        $this->service->handle($requestData);
    }

    public function testTryPerformTransactionWithoutExternalAuthorization()
    {
        /** @var CurlClient $fakeClient */
        $fakeAuthClient = Mockery::mock(CurlClient::class)
            ->shouldReceive('performRequest')
            ->once()
            ->andReturn([
                'message' => 'Não Autorizado',
            ])
            ->getMock();
        $authorizer = new ExternalAuthorizer($fakeAuthClient);

        $service = new PerformTransaction(
            new UserRepository(),
            new TransactionRepository(),
            $authorizer,
            new ExternalNotifier(new CurlClient())
        );

        /** @var User $payee */
        $payee = User::factory()->create([
            'isStore' => true,
            'balance' => 100,
        ]);
        Store::factory(['user_id' => $payee->id])->create();
        /** @var User $payer */
        $payer = User::factory()->create([
            'balance' => 100,
        ]);

        $requestData = [
            'value' => 10,
            'payer' => $payer->id,
            'payee' => $payee->id,
        ];
        $this->expectException(AuthorizationException::class);
        $service->handle($requestData);
    }

    public function testPerformTransactionWithoutNotification()
    {
        /** @var ExternalAuthorizer $fakeAuthorizer */
        $fakeAuthorizer = Mockery::mock(ExternalAuthorizer::class)
            ->shouldReceive('isAuthorized')
            ->once()
            ->andReturn(true)
            ->getMock();

        /** @var ExternalNotifier $fakeNotifier */
        $fakeNotifier = Mockery::mock(ExternalNotifier::class)
            ->shouldReceive('notifyUser')
            ->once()
            ->andReturn(false)
            ->getMock();

        $service = new PerformTransaction(
            new UserRepository(),
            new TransactionRepository(),
            $fakeAuthorizer,
            $fakeNotifier
        );

        /** @var User $payee */
        $payee = User::factory()->create([
            'isStore' => true,
            'balance' => 100,
        ]);
        Store::factory(['user_id' => $payee->id])->create();
        /** @var User $payer */
        $payer = User::factory()->create([
            'balance' => 100,
        ]);

        $requestData = [
            'value' => 10,
            'payer' => $payer->id,
            'payee' => $payee->id,
        ];
        /** @var Transaction $transaction */
        $transaction = $service->handle($requestData);
        $this->assertFalse($transaction->notified);
    }
}
