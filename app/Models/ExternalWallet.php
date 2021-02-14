<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Propaganistas\LaravelFakeId\RoutesWithFakeIds;

class ExternalWallet extends Model
{
    use HasFactory;
    use SoftDeletes;
    use RoutesWithFakeIds;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'type',
        'address',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function crypto_pays()
    {
        return $this->hasMany(CryptoPay::class);
    }
}
