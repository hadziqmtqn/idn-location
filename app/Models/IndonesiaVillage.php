<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndonesiaVillage extends Model
{
    protected $fillable = [
        'code',
        'district_code',
        'name',
        'meta',
    ];
}
