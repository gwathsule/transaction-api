<?php

namespace Unit;

use App\Domains\Transaction\Services\ListTransactions;
use App\Domains\Transaction\Transaction;
use App\Domains\Transaction\TransactionRepository;
use App\Domains\User\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use TestCase;

class ListTransactionsServiceTest extends TestCase
{
    use DatabaseMigrations;

    private ListTransactions $service;

    public function setUp(): void
    {
        $this->service = new ListTransactions(
            new TransactionRepository()
        );
        parent::setUp();
    }

    public function tearDown(): void
    {
        unset($this->service);
    }

    public function testListTransactionsSuccessful()
    {
        $transaction = new Transaction();
        $transaction->amount = 10;
        $transaction->payer_id = User::factory()->create()->id;
        $transaction->payee_id = User::factory()->create()->id;
        $transaction->notified = true;

        $transaction2 = new Transaction();
        $transaction2->amount = 10;
        $transaction2->payer_id = User::factory()->create()->id;
        $transaction2->payee_id = User::factory()->create()->id;
        $transaction2->notified = true;

        $transaction3 = new Transaction();
        $transaction3->amount = 10;
        $transaction3->payer_id = User::factory()->create()->id;
        $transaction3->payee_id = User::factory()->create()->id;
        $transaction3->notified = true;

        $transaction->save();
        $transaction2->save();
        $transaction3->save();

        $list = $this->service->handle([]);
        $this->assertCount(3, $list);
        /** @var Transaction $firstTransaction */
        $firstTransaction = $list[0];

        $this->assertEquals($transaction->amount, $firstTransaction->amount);
        $this->assertEquals($transaction->payer_id, $firstTransaction->payer_id);
        $this->assertEquals($transaction->payee_id, $firstTransaction->payee_id);
        $this->assertEquals($transaction->notified, $firstTransaction->notified);

        $this->assertEquals($transaction->payee->cpf, $firstTransaction->payee->cpf);
        $this->assertEquals($transaction->payee->email, $firstTransaction->payee->email);

        $this->assertEquals($transaction->payer->cpf, $firstTransaction->payer->cpf);
        $this->assertEquals($transaction->payer->email, $firstTransaction->payer->email);
    }
}
