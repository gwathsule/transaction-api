<?php

namespace App\Core;

interface Notifier
{
    public function notify($mensagem) : bool;
}
