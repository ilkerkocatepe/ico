<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'group',
        'value'
    ];

    public function getSetting($setting)
    {
        return Setting::where('setting', $setting)->first()->value;
    }

    public static function value($setting)
    {
        return Setting::where('setting', $setting)->first()->value;
    }
}
