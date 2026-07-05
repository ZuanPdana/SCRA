<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JadwalMataKuliah extends Model
{
    use HasFactory;

    protected $table = 'jadwal_mata_kuliah';

    protected $fillable = [
        'classroom_id',
        'dosen_id',
        'mata_kuliah',
        'day_of_week',
        'start_time',
        'end_time',
    ];

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }

    public function dosen(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }
}
