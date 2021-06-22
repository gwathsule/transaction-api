<?php

namespace App\ExternalServices\TransactionAuthorizer;

use Exception;

class ExternalAuthorizerException extends Exception
{
    public const STATUS = 503;
    public const CATEGORY = 'service_unavailable';
    public const USER_MESSAGE = 'Service Unavailable.';

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
