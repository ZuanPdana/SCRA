<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalSewa extends Model
{
    use HasFactory;

    protected $table = 'jadwal_sewa';

    protected $fillable = [
        'day_of_week',
        'start_time',
        'end_time',
    ];
}
