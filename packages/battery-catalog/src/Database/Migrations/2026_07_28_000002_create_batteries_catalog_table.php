<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('batteries_catalog', function (Blueprint $table) {
            $table->id();
            
            // Basic Information
            $table->string('brand')->comment('برند');
            $table->string('manufacture')->comment('نام شرکت سازنده');
            $table->string('country_of_manufacture')->comment('کشور تولید');
            $table->string('model_name')->comment('نام مدل');
            $table->string('model_code')->comment('کد مدل');
            $table->string('battery_type')->comment('نوع باتری: LiFePO4, Lithium-ion, Lead Acid');
            
            // Capacity & Voltage
            $table->decimal('energy_capacity_kwh', 10, 2)->comment('ظرفیت انرژی (kWh)');
            $table->decimal('capacity_ah', 10, 2)->comment('ظرفیت (Ah)');
            $table->decimal('nominal_voltage', 10, 2)->comment('ولتاژ نامی (V)');
            
            // Charge & Discharge
            $table->decimal('max_charge_current', 10, 2)->comment('حداکثر جریان شارژ (A)');
            $table->decimal('max_discharge_current', 10, 2)->comment('حداکثر جریان دشارژ (A)');
            
            // Performance
            $table->integer('cycle_life')->comment('تعداد سیکل عمر');
            $table->decimal('depth_of_discharge', 5, 2)->comment('عمق دشارژ DOD (%)');
            
            // Expandability
            $table->boolean('expandable')->default(false)->comment('قابلیت توسعه');
            $table->integer('max_parallel_units')->nullable()->comment('حداکثر تعداد باتری قابل اتصال');
            
            // Protection & Communication
            $table->string('ip_rating')->comment('درجه حفاظت IP');
            $table->json('communication_protocols')->nullable()->comment('پروتکل‌های ارتباطی');
            
            // Physical Specifications
            $table->string('dimensions')->comment('ابعاد');
            $table->decimal('weight', 10, 2)->comment('وزن (kg)');
            
            // Warranty & Standards
            $table->integer('warranty_years')->comment('مدت گارانتی (سال)');
            $table->json('standards')->nullable()->comment('استانداردها');
            
            // Documentation
            $table->string('datasheet_path')->comment('فایل دیتاشیت PDF');
            $table->text('notes')->nullable()->comment('توضیحات');
            
            // Union Approval
            $table->boolean('union_approved')->default(false)->comment('مورد تایید اتحادیه');
            $table->date('union_approval_date')->nullable()->comment('تاریخ تایید اتحادیه');
            
            // Laboratory Certification
            $table->boolean('lab_certified')->default(false)->comment('تاییدیه آزمایشگاه');
            $table->string('lab_name')->nullable()->comment('نام آزمایشگاه');
            
            $table->timestamps();
            
            // Indexes
            $table->index('brand');
            $table->index('battery_type');
            $table->index('energy_capacity_kwh');
            $table->index('lab_certified');
            $table->index('union_approved');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('batteries_catalog');
    }
};
