<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function scopeSearch(Builder $query, $request): Builder
    {
        $search = $request['q'] ?? null;

        return $query->when($search, function ($query) use ($search) {
            $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%']);
        });
    }

    public function indonesiaCities(): HasMany
    {
        return $this->hasMany(IndonesiaCity::class, 'province_code', 'code');
    }
}
