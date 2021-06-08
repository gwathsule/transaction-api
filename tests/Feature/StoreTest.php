<?php

namespace Feature;

use App\Domains\Store\Store;
use App\Domains\User\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use TestCase;

class StoreTest extends TestCase
{
    use DatabaseMigrations;

    public function testCreateStore()
    {
        /** @var Store $store */
        $store = Store::factory()->make();
        /** @var User $user */
        $user = User::factory()->make();

        $requestData = [
            'name' => $user->name,
            'cpf' => $user->cpf,
            'cnpj' => $store->cnpj,
            'email' => $user->email,
            'password' => 'Abc@1234',
            'password_confirmation' => 'Abc@1234',
            'balance' => 100.5
        ];

        $this->json('POST', '/store/create', $requestData)
            ->seeJson([
                'cnpj' => $store->cnpj,
                'name' => $user->name,
                'cpf' => $user->cpf,
                'email' => $user->email,
                'balance' => "100.5",
                'isStore' => "1",
            ])
            ->assertResponseOk();
    }
}
