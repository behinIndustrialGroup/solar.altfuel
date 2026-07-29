<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('installed_panels', function (Blueprint $table) {
            $table->id();

            // Project reference
            $table->unsignedBigInteger('project_id')->comment('شناسه پروژه');

            // Panel model from panels_catalog
            $table->unsignedBigInteger('panel_model_id')->comment('شناسه مدل پنل از جدول panels_catalog');

            // Unique serial number per physical panel
            $table->string('serial_number')->unique()->comment('شماره سریال پنل - منحصر به فرد - ترکیب عدد، حرف و خط تیره');

            // Physical location within the plant
            $table->unsignedSmallInteger('section_number')->comment('شماره بخش (Section)');
            $table->unsignedSmallInteger('string_number')->comment('شماره استرینگ (String)');
            $table->unsignedSmallInteger('panel_number')->comment('شماره پنل در استرینگ');

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
            $table->index('panel_model_id');
            $table->index('status');
            $table->index(['project_id', 'section_number', 'string_number', 'panel_number'], 'ip_proj_sec_str_pan_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('installed_panels');
    }
};