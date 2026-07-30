<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('solar_projects', function (Blueprint $table) {
            if (!Schema::hasColumn('solar_projects', 'inspection_ids')) {
                $table->json('inspection_ids')
                      ->nullable()
                      ->after('installed_battery_ids')
                      ->comment('آرایه شناسه‌های بازرسی‌های ثبت شده برای این پروژه');
            }
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('solar_projects', 'inspection_ids')) {
            Schema::table('solar_projects', function (Blueprint $table) {
                $table->dropColumn('inspection_ids');
            });
        }
    }
};
