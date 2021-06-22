<?php

namespace App\Core;

interface Authorizer
{
    public function isAuthorized() : bool;
}
