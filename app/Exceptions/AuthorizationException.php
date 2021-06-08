<?php

namespace App\Exceptions;

class AuthorizationException extends UserException
{
    public const CATEGORY = 'authorization';
    public const STATUS = 401;

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
