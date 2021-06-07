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

        $this->json('POST', '/transaction', $requestData)
            ->seeJson([
                'created' => true,
            ]);
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
