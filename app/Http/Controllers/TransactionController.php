<?php

namespace App\Http\Controllers;

use App\Domains\Transaction\Services\ListTransactions;
use App\Domains\Transaction\Services\PerformTransaction;
use App\Domains\Transaction\Transaction;
use App\Exceptions\InternalServerException;
use App\Exceptions\UserException;
use App\Exceptions\ValidationException;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class TransactionController extends Controller
{
    private PerformTransaction $servicePerformTransaction;
    private ListTransactions $listTransactions;

    public function __construct(
        PerformTransaction $servicePerformTransaction,
        ListTransactions $listTransactions
    )
    {
        $this->servicePerformTransaction = $servicePerformTransaction;
        $this->listTransactions = $listTransactions;
    }

    public function performTransaction(Request $request)
    {
        try {
            /** @var Transaction $transaction */
            $transaction = $this->servicePerformTransaction->handle($request->toArray());
            return $this->buildSuccessfulResponse($transaction->toArray());
        } catch (ValidationException $exception) {
            return $this->buildUserErrorResponse(
                $exception->getUserMessage(),
                $exception->getCategory(),
                $exception->getStatus(),
                $exception->getErrors()
            );
        } catch (UserException $exception) {
            return $this->buildUserErrorResponse(
                $exception->getUserMessage(),
                $exception->getCategory(),
                $exception->getStatus(),
            );
        } catch (Exception $exception) {
            return $this->buildUserErrorResponse(
                InternalServerException::USER_MESSAGE,
                InternalServerException::CATEGORY,
                InternalServerException::STATUS
            );
        }
    }

    public function listTransactions()
    {
        try {
            /** @var Collection $list */
            $list = $this->listTransactions->handle();
            return $this->buildSuccessfulResponse($list->toArray());
        } catch (Exception $exception) {
            return $this->buildUserErrorResponse(
                InternalServerException::USER_MESSAGE,
                InternalServerException::CATEGORY,
                InternalServerException::STATUS
            );
        }
    }
}
