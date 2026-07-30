<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('solar_projects', function (Blueprint $table) {

            if (!Schema::hasColumn('solar_projects', 'installation_start_date')) {
                $table->date('installation_start_date')
                      ->nullable()
                      ->after('inspector_id')
                      ->comment('تاریخ شروع نصب');
            }

            if (!Schema::hasColumn('solar_projects', 'installation_end_date')) {
                $table->date('installation_end_date')
                      ->nullable()
                      ->after('installation_start_date')
                      ->comment('تاریخ پایان نصب');
            }

            if (!Schema::hasColumn('solar_projects', 'commissioning_date')) {
                $table->date('commissioning_date')
                      ->nullable()
                      ->after('installation_end_date')
                      ->comment('تاریخ بهره برداری');
            }

            if (!Schema::hasColumn('solar_projects', 'latitude')) {
                $table->decimal('latitude', 10, 7)
                      ->nullable()
                      ->after('commissioning_date')
                      ->comment('عرض جغرافیایی');
            }

            if (!Schema::hasColumn('solar_projects', 'longitude')) {
                $table->decimal('longitude', 10, 7)
                      ->nullable()
                      ->after('latitude')
                      ->comment('طول جغرافیایی');
            }

            if (!Schema::hasColumn('solar_projects', 'satba_contract_number')) {
                $table->string('satba_contract_number', 191)
                      ->nullable()
                      ->after('longitude')
                      ->comment('شماره قرارداد ساتبا');
            }

            if (!Schema::hasColumn('solar_projects', 'status')) {
                $table->enum('status', [
                    'in_progress',
                    'ready_for_inspection',
                    'approved',
                    'rejected',
                    'active',
                    'inactive',
                ])->default('in_progress')
                  ->after('satba_contract_number')
                  ->comment('وضعیت پروژه: در حال اجرا/آماده بازرسی/تایید شده/رد شده/فعال/غیر فعال');
            }

            if (!Schema::hasColumn('solar_projects', 'health_card_no')) {
                $table->string('health_card_no', 191)
                      ->nullable()
                      ->after('status')
                      ->comment('شماره گواهی سلامت');
            }

            if (!Schema::hasColumn('solar_projects', 'health_card_issue_date')) {
                $table->date('health_card_issue_date')
                      ->nullable()
                      ->after('health_card_no')
                      ->comment('تاریخ صدور گواهی سلامت');
            }

            if (!Schema::hasColumn('solar_projects', 'health_card_expiry_date')) {
                $table->date('health_card_expiry_date')
                      ->nullable()
                      ->after('health_card_issue_date')
                      ->comment('تاریخ انقضای گواهی سلامت');
            }

            if (!Schema::hasColumn('solar_projects', 'description')) {
                $table->text('description')
                      ->nullable()
                      ->after('health_card_expiry_date')
                      ->comment('توضیحات پروژه');
            }
        });
    }

    public function down(): void
    {
        Schema::table('solar_projects', function (Blueprint $table) {
            $columnsToDrop = [
                'installation_start_date',
                'installation_end_date',
                'commissioning_date',
                'latitude',
                'longitude',
                'satba_contract_number',
                'status',
                'health_card_no',
                'health_card_issue_date',
                'health_card_expiry_date',
                'description',
            ];

            foreach ($columnsToDrop as $col) {
                if (Schema::hasColumn('solar_projects', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
