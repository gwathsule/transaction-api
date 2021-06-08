<?php

namespace App\Exceptions;

abstract class InternalServerException extends UserException implements UserExceptionInterface
{
    public const STATUS = 500;
    public const CATEGORY = 'internal';
    public const USER_MESSAGE = 'Internal server error.';

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
