<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'capacity',
        'location',
        'amenities',
        'price_per_hour',
        'images',
        'is_available',
        'opening_time',
        'closing_time',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'amenities' => 'array',
            'images' => 'array',
            'is_available' => 'boolean',
            'price_per_hour' => 'decimal:2',
        ];
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Helper to match old EJS "operatingHours.opening" style access
    public function getOperatingHoursAttribute(): array
    {
        return [
            'opening' => $this->opening_time,
            'closing' => $this->closing_time,
        ];
    }

    // First image helper (EJS used images[0])
    public function getMainImageAttribute(): ?string
    {
        return $this->images[0] ?? null;
    }
}