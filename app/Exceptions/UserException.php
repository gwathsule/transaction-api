<?php

namespace App\Exceptions;

use Exception;

class UserException extends Exception implements UserExceptionInterface
{
    private const CATEGORY = 'user_error';
    private const STATUS = 400;

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
