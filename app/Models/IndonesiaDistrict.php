<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    public function cityCode(): BelongsTo
    {
        return $this->belongsTo(IndonesiaCity::class, 'city_code', 'code');
    }

    public function scopeFilterByCode(Builder $query, $code): Builder
    {
        return $query->where('code', $code);
    }

    public function scopeSearch(Builder $query, $request): Builder
    {
        $search = $request['q'] ?? null;
        $city = $request['city'];

        return $query->when($search, function ($query) use ($search) {
            $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%']);
        })
            ->whereHas('cityCode', fn($query) => $query->where('name', $city));
    }
}
