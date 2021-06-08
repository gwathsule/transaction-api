<?php

namespace Feature;

use App\Domains\Store\Store;
use App\ExternalServices\Notify\Notifier;
use App\ExternalServices\TransactionAuthorizer\Authorizer;
use Illuminate\Support\Facades\Http;
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
}
