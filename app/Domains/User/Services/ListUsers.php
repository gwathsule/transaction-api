<?php

namespace App\Domains\User\Services;

use App\Core\Service;
use App\Domains\User\UserRepository;

class ListUsers extends Service
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function validate(array $data)
    {
        return [];
    }

    /**
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function perform(array $data)
    {
        return $this->userRepository->all();
    }
}
