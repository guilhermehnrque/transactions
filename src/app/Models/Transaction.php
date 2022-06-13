<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Wallet;

class Transfer extends Model
{
    protected $table = 'transactions';

    protected $fillable = [
        'value', 'status', 'payer', 'payee'
    ];

    public function walletPayer()
    {
        return $this->belongsTo(Wallet::class, 'payer', 'id');
    }

    public function walletPayee()
    {
        return $this->belongsTo(Wallet::class, 'payee', 'id');
    }
}