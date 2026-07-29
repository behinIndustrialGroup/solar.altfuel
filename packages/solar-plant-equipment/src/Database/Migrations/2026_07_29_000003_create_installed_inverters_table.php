<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('installed_inverters', function (Blueprint $table) {
            $table->id();

            // Project reference
            $table->unsignedBigInteger('project_id')->comment('شناسه پروژه');

            // Inverter model from inverters_catalog
            $table->unsignedBigInteger('inverter_model_id')->comment('شناسه مدل اینورتر از جدول inverters_catalog');

            // Unique serial number on the physical device
            $table->string('serial_number')->unique()->comment('شماره سریال اینورتر - منحصر به فرد - ترکیب عدد، حرف و خط تیره');

            // Equipment tag: INV_01, INV_02, ...
            $table->string('equipment_tag', 20)->comment('شناسه تجهیز در پروژه - مثال: INV_01، INV_02');

            // Installation location
            $table->enum('installation_location', [
                'electrical_room',      // اتاق برق
                'control_room',         // اتاق کنترل
                'equipment_container',  // کانکس تجهیزات
                'outdoor',              // فضای باز
                'wall_mounted',         // روی دیوار
                'on_structure',         // روی استراکچر
                'other',                // سایر
            ])->comment('محل نصب اینورتر');

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
            $table->index('inverter_model_id');
            $table->index('status');
            $table->index('equipment_tag');
            $table->index(['project_id', 'equipment_tag']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('installed_inverters');
    }
};
