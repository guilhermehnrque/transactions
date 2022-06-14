<?php

namespace App\Repositories;

use App\Models\Transaction;

class TransactionsRepository
{
    protected $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function createTransaction(array $data)
    {
        return $this->transaction->create($data);
    }

    public function getTransactionById(int $transactionId)
    {
        return $this->transaction->find($transactionId);
    }


}
