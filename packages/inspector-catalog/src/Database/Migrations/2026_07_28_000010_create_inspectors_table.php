<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inspectors', function (Blueprint $table) {
            $table->id();

            // ارتباط با جدول کاربران
            $table->unsignedBigInteger('user_id')->unique()->comment('شناسه کاربر بازرس');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // اطلاعات هویتی
            $table->string('inspector_code')->unique()->comment('کد بازرس');
            $table->string('first_name')->comment('نام');
            $table->string('last_name')->comment('نام خانوادگی');
            $table->string('national_id', 10)->unique()->comment('کد ملی');

            // اطلاعات تماس
            $table->string('mobile', 11)->comment('شماره همراه');
            $table->string('phone', 11)->nullable()->comment('تلفن ثابت');

            // محل فعالیت
            $table->string('province')->comment('استان محل فعالیت');
            $table->string('city')->comment('شهر محل فعالیت');
            $table->text('address')->comment('آدرس');

            // گواهی
            $table->boolean('is_certificated')->default(false)->comment('دارای گواهی صلاحیت حرفه‌ای');

            $table->timestamps();

            // Indexes
            $table->index('province');
            $table->index('is_certificated');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inspectors');
    }
};
