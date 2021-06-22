<?php

namespace App\Core;

interface Notifier
{
    public function notifier($mensagem) : bool;
}
