<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IndonesiaVillage extends Model
{
    protected $fillable = [
        'code',
        'district_code',
        'name',
        'meta',
    ];

    public function districtCode(): BelongsTo
    {
        return $this->belongsTo(IndonesiaDistrict::class, 'district_code', 'code');
    }

    public function scopeFilterByCode(Builder $query, $code): Builder
    {
        return $query->where('code', $code);
    }

    public function scopeSearch(Builder $query, $request): Builder
    {
        $search = $request['q'] ?? null;
        $district = $request['district'];

        return $query->when($search, function ($query) use ($search) {
            $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%']);
        })
            ->whereHas('districtCode', fn($query) => $query->where('name', $district));
    }
}
