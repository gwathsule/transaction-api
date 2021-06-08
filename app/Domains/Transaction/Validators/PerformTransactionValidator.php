<?php

namespace App\Domains\Transaction\Validators;

use App\Core\Validator;
use App\Domains\User\User;
use App\Domains\User\UserRepository;

class PerformTransactionValidator extends Validator
{
    public function rules()
    {
        return [
            'value' => ['required', 'numeric'],
            'payer' => ['required', 'numeric', 'exists:' . User::class . ',id'],
            'payee' => ['required', 'numeric', 'exists:' . User::class . ',id'],
        ];
    }

    public function isAuthorized(): bool
    {
        /** @var User $user */
        $user = (new UserRepository())->getById($this->data['payer']);
        if ($user->isStore) {
            return false;
        }
        return true;
    }
}
