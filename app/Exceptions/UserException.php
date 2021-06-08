<?php

namespace App\Exceptions;

use Exception;

class UserException extends Exception implements UserExceptionInterface
{
    public const CATEGORY = 'user_error';
    public const STATUS = 400;

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
