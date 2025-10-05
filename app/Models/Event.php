<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    protected $fillable = [
        'name',
        'description',
        'short_description',
        'image',
        'gallery',
        'adult_price',
        'child_price',
        'location',
        'start_date',
        'end_date',
        'opening_time',
        'closing_time',
        'is_active'
        , 'total_capacity'
    ];

    protected $casts = [
        'gallery' => 'array',
        'adult_price' => 'decimal:2',
        'child_price' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'opening_time' => 'datetime:H:i',
        'closing_time' => 'datetime:H:i',
        'is_active' => 'boolean'
        , 'total_capacity' => 'integer'
    ];

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }
}
