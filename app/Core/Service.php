<?php

namespace App\Core;

abstract class Service
{
    abstract public function validate(array $data);

    abstract protected function perform(array $data);

    public function handle(array $data = [])
    {
        $this->validate($data);
        return $this->perform($data);
    }
}
