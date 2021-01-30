<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentMethod extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'type',
        'status'
    ];

    public function cryptoPays()
    {
        return $this->hasMany(CryptoPay::class);
    }

    public function cryptoGateways()
    {
        return $this->hasMany(CryptoGateway::class,'payment_id');
    }
}
