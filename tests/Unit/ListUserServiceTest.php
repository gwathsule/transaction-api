<?php

namespace Unit;

use App\Domains\User\Services\ListUsers;
use App\Domains\User\User;
use App\Domains\User\UserRepository;
use Laravel\Lumen\Testing\DatabaseMigrations;
use TestCase;

class ListUserServiceTest extends TestCase
{
    use DatabaseMigrations;

    private ListUsers $service;

    public function setUp(): void
    {
        $this->service = new ListUsers(
            new UserRepository()
        );
        parent::setUp();
    }

    public function tearDown(): void
    {
        unset($this->service);
    }

    public function testListUsersSuccessful()
    {
        /** @var User $user1 */
        $user1 = User::factory()->create();
        User::factory()->create();
        User::factory()->create();

        $list = $this->service->handle([]);
        $this->assertCount(3, $list);
        /** @var User $firstUser */
        $firstUser = $list[0];
        $this->assertEquals($user1->isStore, (bool) $firstUser->isStore);
        $this->assertEquals($user1->name, $firstUser->name);
        $this->assertEquals($user1->cpf, $firstUser->cpf);
        $this->assertEquals($user1->email, $firstUser->email);
        $this->assertEquals($user1->password, $firstUser->password);
        $this->assertEquals($user1->balance, $firstUser->balance);
    }
}
