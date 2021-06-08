<?php

namespace Feature;

use App\Domains\User\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    public function testCreateUser()
    {
        /** @var User $user */
        $user = User::factory()->make();

        $requestData = [
            'name' => $user->name,
            'cpf' => $user->cpf,
            'email' => $user->email,
            'password' => 'Abc@1234',
            'password_confirmation' => 'Abc@1234',
        ];

        $this->json('POST', '/user/create', $requestData)
            ->seeJson([
                'name' => $user->name,
                'cpf' => $user->cpf,
                'email' => $user->email,
                'balance' => 0,
                'isStore' => false,
            ])
            ->assertResponseOk();
    }
}
