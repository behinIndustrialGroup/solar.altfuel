<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use SolarPlantRequests\Enums\PanelStatus;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('solar_plant_panels', function (Blueprint $table) {
            $table->id();
            $table->string('serial')->unique();
            $table->foreignId('manufacturer_user_id')->constrained('users');
            $table->integer('production_year');
            $table->integer('expiration_year');
            $table->string('status')->default(PanelStatus::PENDING_APPROVAL->value);
            $table->foreignId('solar_plant_request_id')->constrained('solar_plant_requests')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solar_plant_panels');
    }
};
