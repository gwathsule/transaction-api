<?php

namespace App\Domains\Transaction\Services;

use App\Core\Service;
use App\Domains\Transaction\Transaction;
use App\Domains\Transaction\TransactionRepository;
use App\Domains\Transaction\Validators\PerformTransactionValidator;
use App\Domains\User\User;
use App\Domains\User\UserRepository;
use App\Exceptions\AuthorizationException;
use App\Exceptions\UserException;
use App\ExternalServices\Notify\Notifier;
use App\ExternalServices\TransactionAuthorizer\Authorizer;
use Exception;
use Illuminate\Support\Facades\DB;

class PerformTransaction extends Service
{
    private UserRepository $userRepository;
    private TransactionRepository $transactionRepository;
    private Authorizer $authorizer;
    private Notifier $notifier;

    public function __construct(
        UserRepository $userRepository,
        TransactionRepository $transactionRepository,
        Authorizer $authorizer,
        Notifier $notifier
    )
    {
        $this->userRepository = $userRepository;
        $this->transactionRepository = $transactionRepository;
        $this->authorizer = $authorizer;
        $this->notifier = $notifier;
    }

    /**
     * @param array $data
     * @return array
     * @throws \App\Exceptions\AuthorizationException
     * @throws \App\Exceptions\ValidationException
     */
    public function validate(array $data)
    {
        $validator = new PerformTransactionValidator($data);
        return $validator->validate();
    }

    /**
     * @param array $data
     * @return Transaction
     * @throws UserException
     */
    public function perform(array $data)
    {
        DB::beginTransaction();
        try {
            /** @var User $payer */
            $payer = $this->userRepository->getById($data['payer']);
            /** @var User $payee */
            $payee = $this->userRepository->getById($data['payee']);

            if ($payer->balance - $data['value'] < 0) {
                throw new UserException('User with insufficient balance.');
            }

            $payer->balance -= $data['value'];
            $payee->balance += $data['value'];

            $transaction = new Transaction();
            $transaction->amount = $data['value'];
            $transaction->payee_id = $payee->id;
            $transaction->payer_id = $payer->id;

            $authorized = $this->authorizer->isAuthorized();
            if(! $authorized ) {
                throw new AuthorizationException('Not authorized.');
            }
            $transaction->notified = $this->notifier->notifyUser($payee->email);
            $this->userRepository->update($payee);
            $this->userRepository->update($payer);
            $this->transactionRepository->save($transaction);
        }catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
        DB::commit();

        return $transaction;
    }
}
