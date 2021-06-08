<?php

namespace Unit;

use App\Domains\User\Services\CreateUser;
use App\Domains\User\User;
use App\Domains\User\UserRepository;
use Laravel\Lumen\Testing\DatabaseMigrations;
use TestCase;

class CreateUserServiceTest extends TestCase
{
    use DatabaseMigrations;

    private CreateUser $service;

    public function setUp(): void
    {
        $this->service = new CreateUser(
            new UserRepository()
        );
        parent::setUp();
    }

    public function tearDown(): void
    {
        unset($this->service);
    }

    public function testCreateUserSuccessful()
    {
        /** @var User $user */
        $user = User::factory()->make();

        $requestData = [
            'name' => $user->name,
            'cpf' => $user->cpf,
            'email' => $user->email,
            'password' => 'Abc@1234',
            'password_confirmation' => 'Abc@1234',
            'balance' => 100.5
        ];

        $user = $this->service->handle($requestData);

        $this->assertNotNull($user->id);
        $this->assertEquals($requestData['name'], $user->name);
        $this->assertEquals($requestData['cpf'], $user->cpf);
        $this->assertEquals($requestData['email'], $user->email);
        $this->assertEquals($requestData['balance'], $user->balance);
        $this->assertFalse($user->isStore);
    }
}
