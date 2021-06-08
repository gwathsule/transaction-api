<?php

namespace Unit;

use App\Domains\Store\Services\ListStores;
use App\Domains\Store\Store;
use App\Domains\Store\StoreRepository;
use App\Domains\User\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use TestCase;

class ListStoreServiceTest extends TestCase
{
    use DatabaseMigrations;

    private ListStores $service;

    public function setUp(): void
    {
        $this->service = new ListStores(
            new StoreRepository()
        );
        parent::setUp();
    }

    public function tearDown(): void
    {
        unset($this->service);
    }

    public function testListStoreSuccessful()
    {
        /** @var Store $store */
        $store1 = Store::factory()->create([
            'user_id' => User::factory()->create(['isStore' => true])->id,
        ]);
        Store::factory()->create([
            'user_id' => User::factory()->create(['isStore' => true])->id,
        ]);
        Store::factory()->create([
            'user_id' => User::factory()->create(['isStore' => true])->id,
        ]);
        $list = $this->service->handle([]);
        $this->assertCount(3, $list);
        /** @var Store $firstStore */
        $firstStore = $list[0];
        $this->assertEquals($store1->cnpj, $firstStore->cnpj);
        $this->assertEquals($store1->user->isStore, $firstStore->user->isStore);
        $this->assertEquals($store1->user->name, $firstStore->user->name);
        $this->assertEquals($store1->user->cpf, $firstStore->user->cpf);
        $this->assertEquals($store1->user->email, $firstStore->user->email);
        $this->assertEquals($store1->user->password, $firstStore->user->password);
        $this->assertEquals($store1->user->balance, $firstStore->user->balance);
    }
}
