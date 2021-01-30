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
        'user_id',
        'stage_id',
        'payment_id',
        'gateway_id',
        'external_wallet_id',
        'amount',
        'price',
        'total',
        'payable',
        'current_value',
        'txhash',
        'user_note',
        'admin_note',
        'status'
    ];

    public function stage()
    {
        $this->belongsTo(Stage::class);
    }
    public function user()
    {
        $this->belongsTo(User::class);
    }
}
