<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CryptoGateway extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'payment_id',
        'name',
        'description',
        'image',
        'address_req',
        'confirm_decimal',
        'val1',
        'val2',
        'val3',
        'val4',
        'status'
    ];

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
