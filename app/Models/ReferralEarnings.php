<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReferralEarnings extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'stage_id',
        'user_id',
        'referral_id',
        'sell_id',
        'amount',
        'level'
    ];

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function referral()
    {
        return $this->belongsTo(User::class);
    }

    public function sell()
    {
        return $this->belongsTo(Sell::class);
    }
}
