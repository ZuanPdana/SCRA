<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classroom extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_name',
        'room_code',
        'location',
        'capacity',
        'facilities',
        'status',
        'description',
    ];

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function iotDevices(): HasMany
    {
        return $this->hasMany(IotDevice::class);
    }

    public function hariLibur(): HasMany
    {
        return $this->hasMany(HariLibur::class);
    }
}
