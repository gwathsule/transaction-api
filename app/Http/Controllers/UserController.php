<?php

namespace App\Http\Controllers;

use App\Domains\User\Services\CreateUser;
use App\Domains\User\Services\ListUsers;
use App\Domains\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class UserController extends Controller
{
    private CreateUser $createUser;
    private ListUsers $listUsers;

    public function __construct(
        CreateUser $createUser,
        ListUsers $listUsers
    ) {
        $this->listUsers = $listUsers;
        $this->createUser = $createUser;
    }

    public function createUser(Request $request)
    {
        /** @var User $user */
        $user = $this->createUser->handle($request->toArray());
        return $this->buildSuccessfulResponse($user->toArray());
    }

    public function listUsers()
    {
        /** @var Collection $list */
        $list = $this->listUsers->handle();
        return $this->buildSuccessfulResponse($list->toArray());
    }
}
