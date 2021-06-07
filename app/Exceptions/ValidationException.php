<?php

namespace App\Exceptions;

use Throwable;

class ValidationException extends UserException
{
    private const CATEGORY = 'validation';
    private const STATUS = 400;

    private array $errors;

    public function __construct(array $errors, $message = "", $code = 0, Throwable $previous = null)
    {
        $this->errors = $errors;
        parent::__construct($message, $code, $previous);
    }

    public function getErrors()
    {
        return $this->errors;
    }

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
