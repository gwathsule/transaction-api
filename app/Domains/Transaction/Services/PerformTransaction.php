<?php

namespace App\Domains\Transaction\Services;

use App\Core\Service;
use App\Domains\Transaction\Transaction;
use App\Domains\Transaction\TransactionRepository;
use App\Domains\Transaction\Validators\PerformTransactionValidator;
use App\Domains\User\User;
use App\Domains\User\UserRepository;
use App\Exceptions\UserException;

class PerformTransaction extends Service
{
    private UserRepository $userRepository;
    private TransactionRepository $transactionRepository;

    public function __construct(
        UserRepository $userRepository,
        TransactionRepository $transactionRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->transactionRepository = $transactionRepository;
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

    protected function perform(array $data)
    {
        /** @var User $payer */
        $payer = $this->userRepository->getById($data['payer']);
        /** @var User $payee */
        $payee = $this->userRepository->getById($data['payee']);

        if($payer->balance - $data['amount'] < 0) {
            throw new UserException('User with insufficient balance.');
        }

        $payer->balance =- $data['amount'];
        $payee->balance =+ $data['amount'];

        $transaction = new Transaction();
        $transaction->amount = $data['amount'];
        $transaction->payee = $payee->id;
        $transaction->payer = $payer->id;

        $this->userRepository->update($payee);
        $this->userRepository->update($payer);
        $this->transactionRepository->save($transaction);
    }
}
