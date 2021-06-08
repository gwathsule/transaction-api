<?php

namespace App\Http\Controllers;

use App\Domains\User\Services\CreateUser;
use App\Domains\User\Services\ListUsers;
use App\Domains\User\User;
use App\Exceptions\InternalServerException;
use App\Exceptions\UserException;
use App\Exceptions\ValidationException;
use Illuminate\Http\Request;
use Exception;
use Ramsey\Collection\Collection;

class UserController extends Controller
{
    private CreateUser $createUser;
    private ListUsers $listUsers;

    public function __construct(
        CreateUser $createUser,
        ListUsers $listUsers
    )
    {
        $this->listUsers = $listUsers;
        $this->createUser = $createUser;
    }

    public function createUser(Request $request)
    {
        try {
            /** @var User $user */
            $user = $this->createUser->handle($request->toArray());
            return $this->buildSuccessfulResponse($user->toArray());
        } catch (ValidationException $exception) {
            return $this->buildUserErrorResponse(
                $exception->getUserMessage(),
                $exception->getCategory(),
                $exception->getStatus(),
                $exception->getErrors()
            );
        } catch (UserException $exception) {
            return $this->buildUserErrorResponse(
                $exception->getUserMessage(),
                $exception->getCategory(),
                $exception->getStatus(),
            );
        } catch (Exception $exception) {
            return $this->buildUserErrorResponse(
                InternalServerException::USER_MESSAGE,
                InternalServerException::CATEGORY,
                InternalServerException::STATUS
            );
        }
    }

    public function listUsers()
    {
        try {
            /** @var Collection $list */
            $list = $this->listUsers->handle();
            return $this->buildSuccessfulResponse($list->toArray());
        } catch (Exception $exception) {
            return $this->buildUserErrorResponse(
                InternalServerException::USER_MESSAGE,
                InternalServerException::CATEGORY,
                InternalServerException::STATUS
            );
        }
    }
}
