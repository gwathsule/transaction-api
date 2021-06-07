<?php

namespace Feature;

use App\Domains\User\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use TestCase;

class PerformTransactionTest extends TestCase
{
    use DatabaseMigrations;

    public function testPerformTransactionSuccessful()
    {
        /** @var User $payer */
        $payer = User::factory([
            'balance' => 100
        ])->create();
        /** @var User $payee */
        $payee = User::factory([
            'balance' => 100
        ])->create();

        $requestData = [
            'value' => 10,
            'payer' => $payer->id,
            'payee' => $payee->id,
        ];

        $this->post('/transaction');
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
