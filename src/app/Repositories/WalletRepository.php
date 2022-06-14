<?php

namespace App\Repositories;

use App\Models\Wallet;

class WalletRepository
{
    protected $wallet;

    public function __construct(Wallet $wallet)
    {
        $this->wallet = $wallet;
    }

    public function create(array $data)
    {
        return $this->wallet->create($data);
    }

    public function getUserWallet(int $userId)
    {
        return $this->wallet->where('user_id', $userId)->first();
    }

    public function updateBalance(int $walletId, int $userId, float $newBalance)
    {
        return $this->wallet->where('id', $walletId )
            ->where('user_id', $userId)
            ->update(['current_balance' => $newBalance]);
    }

}
