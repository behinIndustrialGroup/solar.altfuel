<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('solar_plant_requests', function (Blueprint $table) {
            // Applicant info
            $table->string('applicant_type', 20)->default('individual')->after('user_id');
            $table->string('company_name')->nullable()->after('applicant_type');
            $table->string('registration_number')->nullable()->after('company_name');
            $table->string('ceo_national_id', 20)->nullable()->after('registration_number');
            $table->string('immigration_code', 20)->nullable()->after('ceo_national_id');
            $table->string('landline', 20)->nullable()->after('immigration_code');

            // Installation location
            $table->string('province')->after('landline');
            $table->string('city')->after('province');

            // Technical specs
            $table->string('usage_type', 20)->after('city');
            $table->boolean('is_shared_property')->default(false)->after('usage_type');
            $table->unsignedInteger('installation_area')->nullable()->after('is_shared_property');
            $table->string('surface_type', 20)->after('installation_area');
            $table->string('purpose', 20)->after('surface_type');
            $table->unsignedInteger('capacity_kw')->after('purpose');
            $table->boolean('has_three_phase')->default(false)->after('capacity_kw');
            $table->boolean('wants_loan')->default(false)->after('has_three_phase');

            // Request tracking
            $table->string('unique_code', 20)->unique()->after('wants_loan');
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
