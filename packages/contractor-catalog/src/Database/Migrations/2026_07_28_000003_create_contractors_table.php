<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contractors', function (Blueprint $table) {
            $table->id();

            // Company Info
            $table->string('company_name')->comment('نام شرکت');
            $table->string('national_id', 11)->unique()->comment('شناسه ملی شرکت');

            // CEO Info
            $table->string('ceo_name')->comment('نام مدیر عامل');
            $table->string('ceo_national_code', 10)->comment('کد ملی مدیر عامل');
            $table->string('ceo_mobile', 11)->comment('تلفن همراه مدیر عامل');

            // Contact Person
            $table->string('contact_person_name')->comment('نام شخص رابط');
            $table->string('contact_person_mobile', 11)->comment('شماره همراه شخص رابط');

            // Company Contact
            $table->string('company_phone', 11)->nullable()->comment('تلفن شرکت');

            // Location
            $table->string('province')->comment('استان');
            $table->string('city')->comment('شهر');
            $table->text('address')->comment('آدرس');

            // License
            $table->string('license_number')->unique()->comment('شماره پروانه کسب');
            $table->date('license_issue_date')->comment('تاریخ صدور پروانه کسب');
            $table->date('license_expiry_date')->comment('تاریخ انقضای پروانه کسب');

            // Stats
            $table->unsignedInteger('registered_projects_count')->default(0)->comment('تعداد پروژه‌های ثبت شده');

            $table->timestamps();

            // Indexes
            $table->index('province');
            $table->index('license_expiry_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contractors');
    }
};
