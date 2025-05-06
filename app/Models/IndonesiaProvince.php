<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class IndonesiaProvince extends Model
{
    protected $fillable = [
        'code',
        'name',
        'meta',
    ];

    public function scopeFilterByCode(Builder $query, $code): Builder
    {
        return $query->where('code', $code);
    }
}
