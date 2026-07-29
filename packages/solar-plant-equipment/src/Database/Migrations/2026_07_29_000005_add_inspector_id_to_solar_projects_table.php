<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * این میگریشن برای محیط‌هایی است که جدول solar_projects
 * قبلاً بدون ستون inspector_id ساخته شده باشد.
 * اگر migrate:fresh اجرا شود، میگریشن 000001 این ستون را می‌سازد
 * و این میگریشن ستون را skip می‌کند (چون وجود دارد).
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('solar_projects') && !Schema::hasColumn('solar_projects', 'inspector_id')) {
            Schema::table('solar_projects', function (Blueprint $table) {
                $table->foreignId('inspector_id')
                      ->nullable()
                      ->after('contractor_id')
                      ->constrained('users')
                      ->nullOnDelete()
                      ->comment('شناسه بازرس از جدول users با role_id=13');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('solar_projects', 'inspector_id')) {
            Schema::table('solar_projects', function (Blueprint $table) {
                $table->dropForeign(['inspector_id']);
                $table->dropColumn('inspector_id');
            });
        }
    }
};
