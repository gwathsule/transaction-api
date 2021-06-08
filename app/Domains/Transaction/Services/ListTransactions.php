<?php

namespace App\Domains\Transaction\Services;

use App\Core\Service;
use App\Domains\Transaction\TransactionRepository;

class ListTransactions extends Service
{
    private TransactionRepository $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function validate(array $data)
    {
        return [];
    }

    /**
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function perform(array $data = [])
    {
        return $this->transactionRepository->all();
    }
}
