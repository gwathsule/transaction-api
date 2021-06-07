<?php

namespace App\Exceptions;

abstract class InternalServerException extends UserException implements UserExceptionInterface
{
    const STATUS = 500;
    const CATEGORY = 'internal';
    const USER_MESSAGE = 'Internal server error.';

    public function getUserMessage(): string
    {
        return self::USER_MESSAGE;
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
