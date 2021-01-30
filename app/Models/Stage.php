<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Stage extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'amount',
        'softcap',
        'hardcap',
        'min_buy',
        'max_buy',
        'price_type',
        'fixed_price',
        'bonus_status',
        'bonus_minimum',
        'bonus_rate',
        'status',
        'started_at',
        'finished_at',
    ];

    public function price()
    {
        return $this->hasMany(Price::class);
    }

    public function sells()
    {
        return $this->hasMany(CryptoPay::class);
    }

    public static function activePrice()
    {
        return Stage::where('status','running')->latest()->first()->fixed_price;
    }

    public static function activeRemain()
    {
        return Stage::where('status','running')->latest()->first()->remain();
    }

    public static function activeStage()
    {
        return Stage::where('status','running')->latest()->first();
    }

    public static function activeStageSold()
    {
        $id = Stage::where('status','running')->latest()->first()->id;
    }

    public function remain()
    {
        $sold = $this->sells()->where('status','confirmed')->sum('amount');
        return ($this->amount - $sold);
    }

}
