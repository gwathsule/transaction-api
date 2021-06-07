<?php

namespace App\Domains\User;

use App\Core\Repository;

class UserRepository extends Repository
{

    public function getModel(): string
    {
        return User::class;
    }
}
