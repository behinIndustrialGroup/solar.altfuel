<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('installed_batteries', function (Blueprint $table) {
            $table->id();

            // Project reference
            $table->unsignedBigInteger('project_id')->comment('شناسه پروژه');

            // Battery model from batteries_catalog
            $table->unsignedBigInteger('battery_model_id')->comment('شناسه مدل باتری از جدول batteries_catalog');

            // Unique serial number on the physical battery
            $table->string('serial_number')->unique()->comment('شماره سریال باتری - منحصر به فرد - ترکیب عدد، حرف و خط تیره');

            // Equipment tag: BAT_01, BAT_02, ...
            $table->string('equipment_tag', 20)->comment('شناسه تجهیز در پروژه - مثال: BAT_01، BAT_02');

            // Installation location
            $table->enum('installation_location', [
                'battery_rack',         // رک باتری
                'battery_cabinet',      // کابینت باتری
                'battery_room',         // اتاق باتری
                'storage_container',    // کانتینر ذخیره‌ساز
                'other',                // سایر
            ])->comment('محل نصب باتری');

            // Equipment status
            $table->enum('status', [
                'installed',    // نصب شده
                'active',       // در حال بهره‌برداری
                'faulty',       // معیوب
                'replaced',     // تعویض شده
                'removed',      // از مدار خارج شده
            ])->default('installed')->comment('وضعیت تجهیز');

            $table->text('notes')->nullable()->comment('توضیحات');

            $table->timestamps();

            // Indexes
            $table->index('project_id');
            $table->index('battery_model_id');
            $table->index('status');
            $table->index('equipment_tag');
            $table->index(['project_id', 'equipment_tag']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('installed_batteries');
    }
};
