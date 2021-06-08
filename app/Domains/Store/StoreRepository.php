<?php

namespace App\Domains\Store;

use App\Core\Repository;

class StoreRepository extends Repository
{
    public function getModel(): string
    {
        return Store::class;
    }
}
