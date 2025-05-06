<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    public function provinceCode(): BelongsTo
    {
        return $this->belongsTo(IndonesiaProvince::class, 'province_code', 'code');
    }

    public function scopeFilterByCode(Builder $query, $code): Builder
    {
        return $query->where('code', $code);
    }

    public function scopeSearch(Builder $query, $request): Builder
    {
        $search = $request['q'] ?? null;
        $province = $request['province'];

        return $query->when($search, function ($query) use ($search) {
            $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%']);
        })
            ->whereHas('provinceCode', fn($query) => $query->where('name', $province));
    }
}
