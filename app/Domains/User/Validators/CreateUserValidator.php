<?php

namespace App\Domains\User\Validators;

use App\Core\Validator;
use App\Domains\User\User;

class CreateUserValidator extends Validator
{
    public function rules()
    {
        return [
            'name' => ['required', 'max:255'],
            'cpf' => ['required', 'max:11', 'unique:' . User::class . ',cpf'],
            'email' => ['required', 'max:255', 'email', 'unique:' . User::class . ',email'],
            'password' => ['required', 'max:255', 'confirmed'],
            'balance' => ['numeric', 'min:0'],
        ];
    }
}
