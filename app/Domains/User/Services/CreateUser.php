<?php

namespace App\Domains\User\Services;

use App\Core\Service;
use App\Domains\User\User;
use App\Domains\User\UserRepository;
use App\Domains\User\Validators\CreateUserValidator;

class CreateUser extends Service
{
    private UserRepository $userRepository;

    public function __construct(
        UserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    /**
     * @param array $data
     * @return array
     * @throws \App\Exceptions\AuthorizationException
     * @throws \App\Exceptions\ValidationException
     */
    public function validate(array $data)
    {
        $validator = new CreateUserValidator($data);
        return $validator->validate();
    }

    protected function perform(array $data)
    {
        $user = new User();
        $user->name = $data['name'];
        $user->cpf = $data['cpf'];
        $user->email = $data['email'];
        $user->password = $data['password'];
        $user->balance = $data['balance'] ?? 0;
        $user->isStore = false;
        $this->userRepository->save($user);

        return $user;
    }
}
