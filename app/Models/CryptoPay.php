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
        $this->belongsTo(Stage::class);
    }

    public function user()
    {
        $this->belongsTo(User::class);
    }

    public function sells()
    {
        return $this->morphOne(Sell::class, 'sellable');
    }
}
