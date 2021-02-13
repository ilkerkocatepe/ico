<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BonusEarnings extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'stage_id',
        'user_id',
        'sell_id',
        'purchase_amount',
        'bonus_rate',
        'bonus_amount'
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
        return $this->belongsTo(Sell::class);
    }

    public function status()
    {
        return $this->stage()->bonus_status;
    }

    public function rate()
    {
        return $this->stage()->bonus_rate;
    }
}
