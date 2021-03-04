<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CryptoPay extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'gateway_id',
        'external_wallet_id',
        'payable',
        'current_value',
        'txhash'
    ];

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sell()
    {
        return $this->morphOne(Sell::class, 'sellable');
    }

    public function external_wallet()
    {
        return $this->belongsTo(ExternalWallet::class);
    }
}
