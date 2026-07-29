<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inverters_catalog', function (Blueprint $table) {
            $table->id();
            
            // Basic Information
            $table->string('brand')->comment('برند مانند Longi, Trina');
            $table->string('manufacture')->comment('نام شرکت سازنده');
            $table->string('country_of_manufacture')->comment('کشور تولید');
            $table->string('model_name')->comment('نام مدل');
            $table->string('model_code')->comment('کد مدل');
            $table->enum('inverter_type', ['On-Grid', 'Off-Grid', 'Hybrid'])->comment('نوع اینورتر');
            
            // Power Specifications
            $table->decimal('rated_power_kw', 10, 2)->comment('توان نامی به کیلووات');
            $table->integer('mppt_count')->comment('تعداد MPPT');
            $table->integer('strings_per_mppt')->comment('تعداد ورودی هر MPPT');
            
            // Electrical Specifications - Input
            $table->decimal('max_dc_input_voltage', 10, 2)->comment('حداکثر ولتاژ ورودی DC');
            $table->decimal('max_input_current', 10, 2)->comment('حداکثر جریان ورودی');
            $table->string('mpp_voltage_range')->comment('محدوده ولتاژ MPP');
            $table->decimal('max_pv_input_power', 10, 2)->comment('حداکثر توان ورودی PV');
            
            // Electrical Specifications - Output
            $table->decimal('max_output_current', 10, 2)->comment('حداکثر جریان خروجی');
            $table->decimal('output_voltage', 10, 2)->comment('ولتاژ خروجی AC');
            $table->decimal('output_frequency', 10, 2)->comment('فرکانس خروجی');
            
            // Performance
            $table->decimal('max_efficiency', 5, 2)->comment('حداکثر راندمان (درصد)');
            $table->decimal('thd', 5, 2)->nullable()->comment('Total Harmonic Distortion');
            
            // Protection & Features
            $table->string('protection_level')->default('IP65')->comment('درجه حفاظت IP65/IP66');
            $table->string('cooling_type')->nullable()->comment('روش خنک سازی: Natural/Fan');
            $table->boolean('dc_switch')->default(false)->comment('کلید DC');
            $table->boolean('ac_switch')->default(false)->comment('کلید AC');
            $table->boolean('reverse_polarity_protection')->default(false)->comment('حفاظت پلاریته معکوس');
            $table->boolean('display')->default(false)->comment('صفحه نمایشگر');
            $table->boolean('anti_islanding_protection')->default(false)->comment('حفاظت ضد جزیره‌ای');
            $table->boolean('leakage_current_protection')->default(false)->comment('حفاظت جریان نشتی');
            $table->boolean('spd_type')->default(false)->comment('نوع SPD');
            
            // Communication
            $table->json('communication_protocols')->nullable()->comment('پروتکل‌های ارتباطی: WiFi, CAN, RS485');
            
            // Warranty & Standards
            $table->string('warranty_period')->comment('مدت گارانتی');
            $table->json('standards')->nullable()->comment('استانداردها');
            
            // Documentation
            $table->string('datasheet_path')->comment('فایل دیتاشیت PDF');
            $table->text('notes')->nullable()->comment('توضیحات');
            
            // Laboratory Certification
            $table->boolean('lab_certified')->default(false)->comment('تاییدیه آزمایشگاه');
            $table->string('lab_name')->nullable()->comment('نام آزمایشگاه');
            
            $table->timestamps();
            
            // Indexes
            $table->index('brand');
            $table->index('inverter_type');
            $table->index('rated_power_kw');
            $table->index('lab_certified');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inverters_catalog');
    }
};
