<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jadwal_sewa', function (Blueprint $table) {
            $table->dropForeign(['classroom_id']);
            $table->dropUnique('jadwal_sewa_classroom_id_day_of_week_start_time_unique');
            $table->dropColumn('classroom_id');
            $table->unique(['day_of_week', 'start_time'], 'jadwal_sewa_day_of_week_start_time_unique');
        });
    }

    public function down(): void
    {
        Schema::table('jadwal_sewa', function (Blueprint $table) {
            $table->dropUnique('jadwal_sewa_day_of_week_start_time_unique');
            $table->foreignId('classroom_id')->nullable()->after('id');
            $table->foreign('classroom_id')->references('id')->on('classrooms')->cascadeOnDelete();
            $table->unique(['classroom_id', 'day_of_week', 'start_time'], 'jadwal_sewa_classroom_id_day_of_week_start_time_unique');
        });
    }
};
