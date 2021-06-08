<?php

namespace Feature;

use App\Domains\Store\Store;
use App\Domains\Transaction\Transaction;
use App\Domains\User\User;
use App\Exceptions\UserException;
use App\Exceptions\ValidationException;
use Laravel\Lumen\Testing\DatabaseMigrations;
use TestCase;

class TransactionTest extends TestCase
{
    use DatabaseMigrations;

    public function testTryPerformTransactionValidationError()
    {
        $requestData = [
            'value' => 10,
            'payee' => 1,
        ];

        $this->json('POST', '/transaction/create', $requestData)
            ->seeJson([
                'error' => true,
                'category' => ValidationException::CATEGORY,
            ])
            ->assertResponseStatus(ValidationException::STATUS);
    }

    public function testTryPerformTransactionWithUserError()
    {
        /** @var User $payee */
        $payee = User::factory()->create([
            'isStore' => true,
            'balance' => 0,
        ]);
        Store::factory(['user_id' => $payee->id])->create();
        /** @var User $payer */
        $payer = User::factory()->create([
            'balance' => 0,
        ]);

        $requestData = [
            'value' => 10,
            'payer' => $payer->id,
            'payee' => $payee->id,
        ];

        $this->json('POST', '/transaction/create', $requestData)
            ->seeJson([
                'error' => true,
                'category' => UserException::CATEGORY,
            ])->assertResponseStatus(UserException::STATUS);
    }

    public function testListTransactions()
    {
        $transaction = new Transaction();
        $transaction->amount = 10;
        $transaction->payer_id = User::factory()->create()->id;
        $transaction->payee_id = User::factory()->create()->id;
        $transaction->notified = true;

        $transaction2 = new Transaction();
        $transaction2->amount = 10;
        $transaction2->payer_id = User::factory()->create()->id;
        $transaction2->payee_id = User::factory()->create()->id;
        $transaction2->notified = true;

        $transaction3 = new Transaction();
        $transaction3->amount = 10;
        $transaction3->payer_id = User::factory()->create()->id;
        $transaction3->payee_id = User::factory()->create()->id;
        $transaction3->notified = true;

        $transaction->save();
        $transaction2->save();
        $transaction3->save();

        $list = $this->json('GET', '/transaction/list')->response->json();
        $this->assertCount(3, $list);
        /** @var Transaction $firstTransaction */
        $firstTransaction = $list[0];

        $this->assertEquals($transaction->amount, $firstTransaction['amount']);
        $this->assertEquals($transaction->payer_id, $firstTransaction['payer_id']);
        $this->assertEquals($transaction->payee_id, $firstTransaction['payee_id']);
        $this->assertEquals($transaction->notified, $firstTransaction['notified']);

        $this->assertEquals($transaction->payee->cpf, $firstTransaction['payee']['cpf']);
        $this->assertEquals($transaction->payee->email, $firstTransaction['payee']['email']);

        $this->assertEquals($transaction->payer->cpf, $firstTransaction['payer']['cpf']);
        $this->assertEquals($transaction->payer->email, $firstTransaction['payer']['email']);
    }
}
