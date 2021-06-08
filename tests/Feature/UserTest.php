<?php

namespace Feature;

use App\Domains\Store\Store;
use App\Domains\User\User;
use App\Exceptions\ValidationException;
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
            'balance' => 50.7
        ];

        $this->json('POST', '/user/create', $requestData)
            ->seeJson([
                'name' => $user->name,
                'cpf' => $user->cpf,
                'email' => $user->email,
                'balance' => 50.7,
                'isStore' => false,
            ])
            ->assertResponseOk();
    }

    public function testTryCreateUserWithValidationError()
    {
        Store::factory()->make();
        /** @var User $user */
        $user = User::factory()->make();

        $requestData = [
            'name' => $user->name,
            'cpf' => $user->cpf,
            'email' => $user->email,
            'password' => 'Abc@1234',
            'password_confirmation' => 'Abc@1234',
            'balance' => -50
        ];

        $this->json('POST', '/user/create', $requestData)
            ->seeJson([
                'error' => true,
                'category' => ValidationException::CATEGORY,
            ])
            ->assertResponseStatus(ValidationException::STATUS);
    }

    public function testListUsers()
    {
        /** @var User $user1 */
        $user1 = User::factory()->create();
        User::factory()->create();
        User::factory()->create();

        $list = $this->json('GET', '/user/list')->response->json();
        $this->assertCount(3, $list);
        $firstUser = $list[0];
        $this->assertEquals($user1->isStore, (bool) $firstUser['isStore']);
        $this->assertEquals($user1->name, $firstUser['name']);
        $this->assertEquals($user1->cpf, $firstUser['cpf']);
        $this->assertEquals($user1->email, $firstUser['email']);
        $this->assertEquals($user1->balance, $firstUser['balance']);
    }
}
