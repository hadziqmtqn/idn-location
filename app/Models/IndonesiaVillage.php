<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class IndonesiaVillage extends Model
{
    protected $fillable = [
        'code',
        'district_code',
        'name',
        'meta',
    ];

    public function scopeFilterByCode(Builder $query, $code): Builder
    {
        return $query->where('code', $code);
    }
}
