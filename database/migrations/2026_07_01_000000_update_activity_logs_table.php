<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('activity_logs', function (Blueprint $table) {
            // Check if columns don't exist before adding
            if (!Schema::hasColumn('activity_logs', 'activity_type')) {
                $table->string('activity_type')->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('activity_logs', 'module')) {
                $table->string('module')->nullable()->after('activity_type');
            }
            if (!Schema::hasColumn('activity_logs', 'title')) {
                $table->string('title')->nullable()->after('module');
            }
            if (!Schema::hasColumn('activity_logs', 'ip_address')) {
                $table->string('ip_address')->nullable()->after('description');
            }
            if (!Schema::hasColumn('activity_logs', 'user_agent')) {
                $table->text('user_agent')->nullable()->after('ip_address');
            }

            // Rename activity to activity if needed
            if (Schema::hasColumn('activity_logs', 'activity') && !Schema::hasColumn('activity_logs', 'activity_type')) {
                $table->renameColumn('activity', 'activity_type');
            }
        });
    }

    public function down(): void
    {
        Schema::table('activity_logs', function (Blueprint $table) {
            if (Schema::hasColumn('activity_logs', 'activity_type')) {
                $table->dropColumn('activity_type');
            }
            if (Schema::hasColumn('activity_logs', 'module')) {
                $table->dropColumn('module');
            }
            if (Schema::hasColumn('activity_logs', 'title')) {
                $table->dropColumn('title');
            }
            if (Schema::hasColumn('activity_logs', 'ip_address')) {
                $table->dropColumn('ip_address');
            }
            if (Schema::hasColumn('activity_logs', 'user_agent')) {
                $table->dropColumn('user_agent');
            }
        });
    }
};
