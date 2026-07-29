<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('solar_projects', function (Blueprint $table) {
            $table->id();

            // Related request from solar_plant_requests table
            $table->foreignId('request_id')
                  ->nullable()
                  ->constrained('solar_plant_requests')
                  ->nullOnDelete()
                  ->comment('شناسه تقاضای ثبت شده از جدول solar_plant_requests');

            // Related contractor from contractors table
            $table->foreignId('contractor_id')
                  ->nullable()
                  ->constrained('contractors')
                  ->nullOnDelete()
                  ->comment('شناسه پیمانکار از جدول contractors');

            // Related inspector from users table (role_id = 13)
            $table->foreignId('inspector_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete()
                  ->comment('شناسه بازرس از جدول users با role_id=13');

            // Installed equipment model IDs stored as JSON arrays
            $table->json('installed_panel_ids')->nullable()->comment('آرایه شناسه‌های مدل پنل‌های نصب شده از panels_catalog');
            $table->json('installed_inverter_ids')->nullable()->comment('آرایه شناسه‌های مدل اینورترهای نصب شده از inverters_catalog');
            $table->json('installed_battery_ids')->nullable()->comment('آرایه شناسه‌های مدل باتری‌های نصب شده از batteries_catalog');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solar_projects');
    }
};
