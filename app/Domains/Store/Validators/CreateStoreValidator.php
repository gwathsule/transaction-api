<?php

namespace App\Domains\Store\Validators;

use App\Core\Validator;
use App\Domains\Store\Store;
use App\Domains\User\User;

class CreateStoreValidator extends Validator
{
    public function rules()
    {
        return [
            'name' => ['required', 'max:255'],
            'cpf' => ['required', 'max:11', 'unique:'.User::class.',cpf'],
            'cnpj' => ['required', 'max:14', 'unique:'.Store::class.',cnpj'],
            'email' => ['required', 'max:255', 'email', 'unique:'.User::class.',email'],
            'password' => ['required', 'max:255', 'confirmed'],
            'balance' => ['numeric'],
        ];
    }
}
