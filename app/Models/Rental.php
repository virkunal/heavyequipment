<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rental extends Model
{
    protected $fillable = [
        'boom_lift_id',
        'user_id',
        'rental_type',
        'start_date',
        'end_date',
        'quantity',
        'rate',
        'duration',
        'total_amount',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'quantity' => 'integer',
            'rate' => 'decimal:2',
            'duration' => 'integer',
            'total_amount' => 'decimal:2',
        ];
    }

    public function boomLift(): BelongsTo
    {
        return $this->belongsTo(BoomLift::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
