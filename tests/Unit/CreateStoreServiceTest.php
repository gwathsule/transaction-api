<?php

namespace Unit;

use App\Domains\Store\Services\CreateStore;
use App\Domains\Store\Store;
use App\Domains\Store\StoreRepository;
use App\Domains\User\User;
use App\Domains\User\UserRepository;
use Laravel\Lumen\Testing\DatabaseMigrations;
use TestCase;

class CreateStoreServiceTest extends TestCase
{
    use DatabaseMigrations;

    private CreateStore $service;

    public function setUp(): void
    {
        $this->service = new CreateStore(
            new StoreRepository(),
            new UserRepository()
        );
        parent::setUp();
    }

    public function tearDown(): void
    {
        unset($this->service);
    }

    public function testCreateStoreSuccessful()
    {
        /** @var Store $store */
        $store = Store::factory()->make();
        /** @var User $user */
        $user = User::factory()->make();

        $requestData = [
            'cnpj' => $store->cnpj,
            'name' => $user->name,
            'cpf' => $user->cpf,
            'email' => $user->email,
            'password' => 'Abc@1234',
            'password_confirmation' => 'Abc@1234',
            'balance' => 100.5
        ];

        $store = $this->service->handle($requestData);

        $this->assertNotNull($store->id);
        $this->assertEquals($requestData['cnpj'], $store->cnpj);
        $this->assertEquals($requestData['name'], $store->user->name);
        $this->assertEquals($requestData['cpf'], $store->user->cpf);
        $this->assertEquals($requestData['email'], $store->user->email);
        $this->assertEquals($requestData['balance'], $store->user->balance);
        $this->assertTrue((bool) $store->user->isStore);
    }
}
