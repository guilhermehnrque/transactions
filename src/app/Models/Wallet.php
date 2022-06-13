<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Transaction;

class Wallet extends Model
{
    protected $table = 'wallets';

    protected $fillable = [
        'current_balance', 'status', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function payer()
    {
        return $this->hasMany(Transaction::class, 'payer', 'id');
    }

    public function payee()
    {
        return $this->hasMany(Transaction::class, 'payee', 'id');
    }

}
