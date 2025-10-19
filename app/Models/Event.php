<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    protected $fillable = [
        'name',
        'category',
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
        'is_active',
        'total_capacity'
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

    // Phương thức để lấy tên category bằng tiếng Việt
    public function getCategoryNameAttribute()
    {
        return match($this->category) {
            'event' => 'Sự kiện & Lễ hội',
            'attraction' => 'Địa điểm du lịch',
            default => 'Không xác định'
        };
    }

    // Phương thức để tự động tính status dựa trên ngày hiện tại
    public function getStatusAttribute()
    {
        if ($this->category !== 'event' || !$this->start_date || !$this->end_date) {
            return null; // Không áp dụng cho địa điểm du lịch hoặc không có ngày
        }
        
        $now = now()->toDateString();
        $startDate = $this->start_date;
        $endDate = $this->end_date;
        
        if ($now < $startDate) {
            return 'upcoming'; // Sắp diễn ra
        } elseif ($now >= $startDate && $now <= $endDate) {
            return 'ongoing'; // Đang diễn ra
        } else {
            return 'ended'; // Kết thúc
        }
    }

    // Phương thức để lấy tên status bằng tiếng Việt (chỉ cho sự kiện)
    public function getStatusNameAttribute()
    {
        if ($this->category !== 'event') {
            return null; // Không áp dụng cho địa điểm du lịch
        }
        
        return match($this->status) {
            'upcoming' => 'Sắp diễn ra',
            'ongoing' => 'Đang diễn ra',
            'ended' => 'Kết thúc',
            default => 'Không xác định'
        };
    }

    // Phương thức để lấy màu status
    public function getStatusColorAttribute()
    {
        if ($this->category !== 'event') {
            return null; // Không áp dụng cho địa điểm du lịch
        }
        
        return match($this->status) {
            'upcoming' => 'warning',
            'ongoing' => 'success',
            'ended' => 'secondary',
            default => 'light'
        };
    }

    // Scope để lọc theo category
    public function scopeEvents($query)
    {
        return $query->where('category', 'event');
    }

    public function scopeAttractions($query)
    {
        return $query->where('category', 'attraction');
    }
}
