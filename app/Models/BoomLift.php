<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoomLift extends Model
{
    /** @use HasFactory<\Database\Factories\BoomLiftFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'model',
        'description',
        'address',
        'latitude',
        'longitude',
        'specifications',
        'image',
        'hourly_rate',
        'daily_rate',
        'monthly_rate',
        'is_available',
    ];

    protected function casts(): array
    {
        return [
            'specifications' => 'array',
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
            'hourly_rate' => 'decimal:2',
            'daily_rate' => 'decimal:2',
            'monthly_rate' => 'decimal:2',
            'is_available' => 'boolean',
        ];
    }
}
