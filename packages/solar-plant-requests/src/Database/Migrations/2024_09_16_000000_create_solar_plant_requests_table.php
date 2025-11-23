<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use SolarPlantRequests\Enums\SolarPlantRequestStatus;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('solar_plant_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('mobile', 20);
            $table->string('national_code', 20);
            $table->string('postal_code', 20);
            $table->text('address');
            $table->string('bill_identifier')->nullable();
            $table->unsignedInteger('area')->nullable();
            $table->foreignId('contractor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('contractor_name')->nullable();
            $table->foreignId('inspector_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('inspector_name')->nullable();
            $table->string('status', 64)->default(SolarPlantRequestStatus::UNDER_REVIEW->value);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solar_plant_requests');
    }
};
