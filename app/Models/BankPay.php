<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankPay extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'bank_gateway_id',
        'deposit_amount',
        'rate',
        'value'
    ];

    public function sell()
    {
        return $this->morphOne(Sell::class, 'sellable');
    }
}
