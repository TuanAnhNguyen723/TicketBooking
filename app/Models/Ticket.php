<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    protected $fillable = [
        'event_id',
        'order_id',
        'type',
        'quantity',
        'price',
        'visit_date',
        'qr_code',
        'status'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'visit_date' => 'date',
        'quantity' => 'integer',
        'rating' => 'integer'
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
