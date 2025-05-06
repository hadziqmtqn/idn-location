<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IndonesiaDistrict extends Model
{
    protected $fillable = [
        'code',
        'city_code',
        'name',
        'meta',
    ];

    public function indonesiaVillages(): HasMany
    {
        return $this->hasMany(IndonesiaVillage::class, 'district_code', 'code');
    }

    public function scopeFilterByCode(Builder $query, $code): Builder
    {
        return $query->where('code', $code);
    }
}
