<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            if (!Schema::hasColumn('reservations', 'purpose_type')) {
                $table->enum('purpose_type', ['Perkuliahan', 'Kegiatan Lain'])->nullable()->after('purpose');
            }
            if (!Schema::hasColumn('reservations', 'mata_kuliah')) {
                $table->string('mata_kuliah')->nullable()->after('purpose_type');
            }
            if (!Schema::hasColumn('reservations', 'dosen_id')) {
                $table->foreignId('dosen_id')->nullable()->constrained('users')->cascadeOnDelete()->after('mata_kuliah');
            }
            if (!Schema::hasColumn('reservations', 'kegiatan')) {
                $table->text('kegiatan')->nullable()->after('dosen_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropForeignKeyIfExists(['dosen_id']);
            if (Schema::hasColumn('reservations', 'purpose_type')) {
                $table->dropColumn('purpose_type');
            }
            if (Schema::hasColumn('reservations', 'mata_kuliah')) {
                $table->dropColumn('mata_kuliah');
            }
            if (Schema::hasColumn('reservations', 'dosen_id')) {
                $table->dropColumn('dosen_id');
            }
            if (Schema::hasColumn('reservations', 'kegiatan')) {
                $table->dropColumn('kegiatan');
            }
        });
    }
};
