<?php

namespace App\Http\Controllers;

use App\Domains\Transaction\Services\ListTransactions;
use App\Domains\Transaction\Services\PerformTransaction;
use App\Domains\Transaction\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class TransactionController extends Controller
{
    private PerformTransaction $servicePerformTransaction;
    private ListTransactions $listTransactions;

    public function __construct(
        PerformTransaction $servicePerformTransaction,
        ListTransactions $listTransactions
    ) {
        $this->servicePerformTransaction = $servicePerformTransaction;
        $this->listTransactions = $listTransactions;
    }

    public function performTransaction(Request $request)
    {
        /** @var Transaction $transaction */
        $transaction = $this->servicePerformTransaction->handle($request->toArray());
        return $this->buildSuccessfulResponse($transaction->toArray());
    }

    public function listTransactions()
    {
        /** @var Collection $list */
        $list = $this->listTransactions->handle();
        return $this->buildSuccessfulResponse($list->toArray());
    }
}
