<?php

namespace Feature;

use App\Domains\Store\Store;
use App\Domains\User\User;
use App\Exceptions\ValidationException;
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
                'balance' => 100.5,
                'isStore' => true,
            ])
            ->assertResponseOk();
    }

    public function testTryCreateStoreWithValidationError()
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
            'balance' => -50
        ];

        $this->json('POST', '/store/create', $requestData)
            ->seeJson([
                'error' => true,
                'category' => ValidationException::CATEGORY,
            ])
            ->assertResponseStatus(ValidationException::STATUS);
    }

    public function testListUsers()
    {
        /** @var Store $store1 */
        $store1 = Store::factory()->create([
            'user_id' => User::factory()->create(['isStore' => true])->id,
        ]);
        Store::factory()->create([
            'user_id' => User::factory()->create(['isStore' => true])->id,
        ]);
        Store::factory()->create([
            'user_id' => User::factory()->create(['isStore' => true])->id,
        ]);

        $list = $this->json('GET', '/store/list')->response->json();
        $this->assertCount(3, $list);
        $firstStore = $list[0];
        $this->assertEquals($store1->cnpj, $firstStore['cnpj']);
        $this->assertEquals($store1->user->isStore, (bool) $firstStore['user']['isStore']);
        $this->assertEquals($store1->user->name, $firstStore['user']['name']);
        $this->assertEquals($store1->user->cpf, $firstStore['user']['cpf']);
        $this->assertEquals($store1->user->email, $firstStore['user']['email']);
        $this->assertEquals($store1->user->balance, $firstStore['user']['balance']);
    }
}
