<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('door_access_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('iot_device_id')->constrained()->cascadeOnDelete();
            $table->foreignId('reservation_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamp('access_time');
            $table->enum('door_status', ['Opened', 'Closed', 'Failed'])->default('Closed');
            $table->text('note')->nullable();
            $table->timestamps();

            $table->index('access_time');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('door_access_logs');
    }
};
