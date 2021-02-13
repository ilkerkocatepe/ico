<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sell extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'stage_id',
        'method_id',
        'sellable_id',
        'sellable_type',
        'amount',
        'price',
        'total',
        'user_note',
        'admin_note',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }

    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class,'method_id');
    }

    public function sellable()
    {
        return $this->morphTo();
    }

    public function referral_earnings()
    {
        return $this->hasMany(ReferralEarnings::class);
    }

    public function bonus_earning()
    {
        return $this->hasOne(BonusEarnings::class);
    }
}
