<?php

namespace App\Exceptions;

class AuthorizationException extends UserException
{
    private const CATEGORY = 'authorization';
    private const STATUS = 401;

    public function getUserMessage(): string
    {
        return $this->message;
    }

    public function getCategory(): string
    {
        return self::CATEGORY;
    }

    public function getStatus(): int
    {
        return self::STATUS;
    }
}
