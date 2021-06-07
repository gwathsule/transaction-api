<?php

namespace App\Domains\Transaction;

use App\Core\Repository;

class TransactionRepository extends Repository
{
    public function getModel(): string
    {
        return Transaction::class;
    }
}
