<?php

namespace Feature;

use App\Domains\Store\Store;
use App\Domains\User\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use TestCase;

class TransactionTest extends TestCase
{
    use DatabaseMigrations;

    public function testPerformTransactionSuccessful()
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

        $this->json('POST', '/transaction/create', $requestData)
            ->seeJson([
                'amount' => $requestData['value'],
                'payer_id' => $payer->id,
                'payee_id' => $payee->id,
            ]);
        $payer->refresh();
        $payee->refresh();
        $this->assertEquals($payer->balance, $newPayerBalance);
        $this->assertEquals($payee->balance, $newPayeeBalance);
    }

    public function testTryPerformTransactionValidationError()
    {
    }

    public function testTryPerformTransactionWithUserError()
    {
    }

    public function testTryPerformTransactionWithInternalServerError()
    {
    }
}
