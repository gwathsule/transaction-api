<?php

namespace App\Exceptions;

use Throwable;

interface UserExceptionInterface extends Throwable
{
    public function getUserMessage(): string;

    public function getCategory(): string;

    public function getStatus(): int;
}
