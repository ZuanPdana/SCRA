<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DoorAccessLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'iot_device_id',
        'reservation_id',
        'user_id',
        'access_time',
        'door_status',
        'note',
    ];

    protected function casts(): array
    {
        return [
            'access_time' => 'datetime',
        ];
    }

    public function iotDevice(): BelongsTo
    {
        return $this->belongsTo(IotDevice::class);
    }

    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
