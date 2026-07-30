<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_inspections', function (Blueprint $table) {
            $table->id();

            $table->foreignId('inspector_id')
                  ->constrained('users')
                  ->comment('شناسه بازرس پروژه');

            $table->foreignId('project_id')
                  ->constrained('solar_projects')
                  ->onDelete('cascade')
                  ->comment('شناسه پروژه');

            $table->date('visit_date')->comment('تاریخ بازدید');

            $table->enum('result', ['approved', 'rejected'])
                  ->comment('نتیجه بازرسی: تایید یا عدم تایید');

            $table->text('rejection_reason')
                  ->nullable()
                  ->comment('علت عدم تایید');

            // ==================== 1. اطلاعات پروژه ====================
            $table->boolean('project_info_matches_system')
                  ->default(false)
                  ->comment('اطلاعات پروژه با سامانه مطابقت دارد؟');
            $table->boolean('plant_capacity_correct')
                  ->default(false)
                  ->comment('ظرفیت نیروگاه صحیح است؟');
            $table->boolean('installation_location_correct')
                  ->default(false)
                  ->comment('محل نصب مطابق اطلاعات ثبت‌شده است؟');
            $table->text('project_info_notes')->nullable();

            // ==================== 2. پنل خورشیدی ====================
            $table->boolean('panel_brand_union_approved')
                  ->default(false)
                  ->comment('برند پنل مورد تأیید اتحادیه است؟');
            $table->boolean('panel_brand_matches_project')
                  ->default(false)
                  ->comment('برند و مدل پنل با اطلاعات ثبت شده پروژه یکسان است؟');
            $table->boolean('panel_model_approved')
                  ->default(false)
                  ->comment('مدل پنل مورد تأیید و با مدل پروژه یکسان است؟');
            $table->boolean('panel_serial_correct')
                  ->default(false)
                  ->comment('شماره سریال پنل صحیح است؟');
            $table->boolean('panel_quantity_correct')
                  ->default(false)
                  ->comment('تعداد پنل‌ها صحیح است؟');
            $table->boolean('panel_intact')
                  ->default(false)
                  ->comment('پنل سالم و بدون شکستگی است؟');
            $table->boolean('panel_orientation_correct')
                  ->default(false)
                  ->comment('جهت نصب پنل صحیح است؟');
            $table->boolean('panel_angle_correct')
                  ->default(false)
                  ->comment('زاویه نصب پنل مناسب است؟');
            $table->text('panel_notes')->nullable();

            // ==================== 3. استراکچر ====================
            $table->boolean('structure_standard')
                  ->default(false)
                  ->comment('استراکچر استاندارد است؟');
            $table->boolean('bolts_tightened')
                  ->default(false)
                  ->comment('پیچ و مهره‌ها محکم بسته شده‌اند؟');
            $table->boolean('no_corrosion')
                  ->default(false)
                  ->comment('خوردگی مشاهده نشده است؟');
            $table->boolean('proper_ground_clearance')
                  ->default(false)
                  ->comment('فاصله مناسب از سطح زمین رعایت شده است؟');
            $table->text('structure_notes')->nullable();

            // ==================== 4. کابل‌کشی DC ====================
            $table->boolean('cable_standard')
                  ->default(false)
                  ->comment('کابل‌ها استاندارد هستند؟');
            $table->boolean('proper_cross_section')
                  ->default(false)
                  ->comment('سطح مقطع کابل مناسب است؟');
            $table->boolean('proper_cabling')
                  ->default(false)
                  ->comment('کابل‌کشی به صورت صحیح انجام شده است؟');
            $table->boolean('mc4_connectors_standard')
                  ->default(false)
                  ->comment('کانکتورهای MC4 استاندارد هستند؟');
            $table->text('dc_cabling_notes')->nullable();

            // ==================== 5. اینورتر ====================
            $table->boolean('inverter_info_matches_project')
                  ->default(false)
                  ->comment('اطلاعات اینورتر با پروژه مطابقت دارد؟');
            $table->boolean('inverter_brand_approved')
                  ->default(false)
                  ->comment('برند اینورتر مورد تأیید است؟');
            $table->boolean('inverter_model_approved')
                  ->default(false)
                  ->comment('مدل اینورتر مورد تأیید است؟');
            $table->boolean('inverter_serial_correct')
                  ->default(false)
                  ->comment('شماره سریال اینورتر صحیح است؟');
            $table->boolean('inverter_proper_installation')
                  ->default(false)
                  ->comment('نصب اینورتر صحیح است؟');
            $table->boolean('inverter_ventilation_ok')
                  ->default(false)
                  ->comment('تهویه اینورتر مناسب است؟');
            $table->boolean('inverter_settings_correct')
                  ->default(false)
                  ->comment('تنظیمات اینورتر صحیح است؟');
            $table->text('inverter_notes')->nullable();

            // ==================== 6. باتری (در صورت وجود) ====================
            $table->boolean('battery_present')
                  ->default(false)
                  ->comment('آیا سیستم باتری وجود دارد؟');
            $table->boolean('battery_brand_approved')
                  ->default(false)
                  ->comment('برند باتری مورد تأیید است؟');
            $table->boolean('battery_model_matches_project')
                  ->default(false)
                  ->comment('مدل باتری مورد تأیید و با اطلاعات پروژه همخوانی دارد؟');
            $table->boolean('battery_serial_correct')
                  ->default(false)
                  ->comment('شماره سریال باتری صحیح است؟');
            $table->boolean('battery_cables_correct')
                  ->default(false)
                  ->comment('کابل‌های باتری صحیح هستند؟');
            $table->boolean('battery_bms_ok')
                  ->default(false)
                  ->comment('BMS عملکرد صحیح دارد؟');
            $table->boolean('battery_ventilation_ok')
                  ->default(false)
                  ->comment('تهویه باتری مناسب است؟');
            $table->text('battery_notes')->nullable();

            // ==================== 7. سیستم ارت و حفاظت ====================
            $table->boolean('grounding_implemented')
                  ->default(false)
                  ->comment('سیستم ارت اجرا شده است؟');
            $table->boolean('grounding_resistance_ok')
                  ->default(false)
                  ->comment('مقاومت ارت در محدوده مجاز است؟');
            $table->boolean('spd_installed')
                  ->default(false)
                  ->comment('SPD (محافظ رعد و برق) نصب شده است؟');
            $table->boolean('fuses_appropriate')
                  ->default(false)
                  ->comment('فیوزها مناسب و استاندارد هستند؟');
            $table->boolean('protection_switches_appropriate')
                  ->default(false)
                  ->comment('کلیدهای حفاظتی مناسب هستند؟');
            $table->text('grounding_notes')->nullable();

            // ==================== 8. تابلو برق ====================
            $table->boolean('electrical_panel_standard')
                  ->default(false)
                  ->comment('تابلو برق استاندارد است؟');
            $table->boolean('proper_wiring')
                  ->default(false)
                  ->comment('سیم‌کشی تابلو مناسب و استاندارد است؟');
            $table->boolean('labeling_done')
                  ->default(false)
                  ->comment('برچسب‌گذاری تابلو انجام شده است؟');
            $table->text('electrical_panel_notes')->nullable();

            // ==================== 9. عملکرد نیروگاه ====================
            $table->boolean('inverter_no_error')
                  ->default(false)
                  ->comment('اینورتر بدون خطا و کد هشدار کار می‌کند؟');
            $table->boolean('production_normal')
                  ->default(false)
                  ->comment('تولید برق نیروگاه طبیعی است؟');
            $table->boolean('monitoring_active')
                  ->default(false)
                  ->comment('سیستم مانیتورینگ فعال است؟');
            $table->boolean('performance_test_passed')
                  ->default(false)
                  ->comment('تست عملکرد نیروگاه موفقیت‌آمیز بوده است؟');
            $table->text('performance_notes')->nullable();

            // ==================== 10. ایمنی ====================
            $table->boolean('warning_signs_installed')
                  ->default(false)
                  ->comment('علائم هشدار نصب شده‌اند؟');
            $table->boolean('safety_equipment_ok')
                  ->default(false)
                  ->comment('تجهیزات ایمنی رعایت شده‌اند؟');
            $table->boolean('safe_access')
                  ->default(false)
                  ->comment('دسترسی ایمن به تجهیزات فراهم است؟');
            $table->boolean('moisture_protection')
                  ->default(false)
                  ->comment('حفاظت در برابر آب و رطوبت انجام شده است؟');
            $table->text('safety_notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_inspections');
    }
};
