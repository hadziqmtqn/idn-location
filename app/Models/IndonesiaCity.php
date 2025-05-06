<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IndonesiaCity extends Model
{
    protected $fillable = [
        'code',
        'province_code',
        'name',
        'meta',
    ];

    public function indonesiaDistricts(): HasMany
    {
        return $this->hasMany(IndonesiaDistrict::class, 'city_code', 'code');
    }

    public function scopeFilterByCode(Builder $query, $code): Builder
    {
        return $query->where('code', $code);
    }
}
