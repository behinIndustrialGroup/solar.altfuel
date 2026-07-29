<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('solar_plant_requests', function (Blueprint $table) {
            if (!Schema::hasColumn('solar_plant_requests', 'applicant_type')) {
                $table->string('applicant_type', 20)->default('individual')->after('user_id');
            }
            if (!Schema::hasColumn('solar_plant_requests', 'company_name')) {
                $table->string('company_name')->nullable()->after('applicant_type');
            }
            if (!Schema::hasColumn('solar_plant_requests', 'registration_number')) {
                $table->string('registration_number')->nullable()->after('company_name');
            }
            if (!Schema::hasColumn('solar_plant_requests', 'ceo_national_id')) {
                $table->string('ceo_national_id', 20)->nullable()->after('registration_number');
            }
            if (!Schema::hasColumn('solar_plant_requests', 'immigration_code')) {
                $table->string('immigration_code', 20)->nullable()->after('ceo_national_id');
            }
            if (!Schema::hasColumn('solar_plant_requests', 'landline')) {
                $table->string('landline', 20)->nullable()->after('immigration_code');
            }
            if (!Schema::hasColumn('solar_plant_requests', 'province')) {
                $table->string('province')->after('landline');
            }
            if (!Schema::hasColumn('solar_plant_requests', 'city')) {
                $table->string('city')->after('province');
            }
            if (!Schema::hasColumn('solar_plant_requests', 'usage_type')) {
                $table->string('usage_type', 20)->after('city');
            }
            if (!Schema::hasColumn('solar_plant_requests', 'is_shared_property')) {
                $table->boolean('is_shared_property')->default(false)->after('usage_type');
            }
            if (!Schema::hasColumn('solar_plant_requests', 'installation_area')) {
                $table->unsignedInteger('installation_area')->nullable()->after('is_shared_property');
            }
            if (!Schema::hasColumn('solar_plant_requests', 'surface_type')) {
                $table->string('surface_type', 20)->after('installation_area');
            }
            if (!Schema::hasColumn('solar_plant_requests', 'purpose')) {
                $table->string('purpose', 20)->after('surface_type');
            }
            if (!Schema::hasColumn('solar_plant_requests', 'capacity_kw')) {
                $table->unsignedInteger('capacity_kw')->after('purpose');
            }
            if (!Schema::hasColumn('solar_plant_requests', 'has_three_phase')) {
                $table->boolean('has_three_phase')->default(false)->after('capacity_kw');
            }
            if (!Schema::hasColumn('solar_plant_requests', 'wants_loan')) {
                $table->boolean('wants_loan')->default(false)->after('has_three_phase');
            }
            if (!Schema::hasColumn('solar_plant_requests', 'unique_code')) {
                $table->string('unique_code', 20)->unique()->after('wants_loan');
            }
        });
    }

    public function down(): void
    {
        Schema::table('solar_plant_requests', function (Blueprint $table) {
            $table->dropColumn([
                'applicant_type',
                'company_name',
                'registration_number',
                'ceo_national_id',
                'immigration_code',
                'landline',
                'province',
                'city',
                'usage_type',
                'is_shared_property',
                'installation_area',
                'surface_type',
                'purpose',
                'capacity_kw',
                'has_three_phase',
                'wants_loan',
                'unique_code',
            ]);
        });
    }
};
