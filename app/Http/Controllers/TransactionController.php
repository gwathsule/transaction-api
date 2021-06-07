<?php

namespace App\Http\Controllers;

use App\Domains\Transaction\Services\PerformTransaction;
use App\Domains\Transaction\Transaction;
use App\Exceptions\InternalServerException;
use App\Exceptions\UserException;
use App\Exceptions\ValidationException;
use Exception;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    private PerformTransaction $servicePerformTransaction;
    public function __construct(PerformTransaction $servicePerformTransaction)
    {
        $this->servicePerformTransaction = $servicePerformTransaction;
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
}
