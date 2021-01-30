<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Price extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'stage_id',
        'min_amount',
        'max_amount',
        'price',
        'status'
    ];

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }
}
