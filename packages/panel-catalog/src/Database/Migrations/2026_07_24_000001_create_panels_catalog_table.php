<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('panels_catalog', function (Blueprint $table) {
            $table->id();
            $table->string('brand');
            $table->string('manufacture');
            $table->string('country_of_manufacture');
            $table->string('model');
            $table->string('model_code');
            $table->string('technology');
            $table->enum('panel_type', ['Monofacial', 'Bifacial']);
            $table->decimal('rated_power_wp', 8, 2);
            $table->decimal('module_efficiency', 5, 2)->comment('percentage');
            $table->integer('number_of_cells');
            $table->enum('cell_type', ['Half cell', 'Full cell']);
            $table->decimal('voc', 8, 3)->comment('Open circuit voltage');
            $table->decimal('isc', 8, 3)->comment('Short circuit current');
            $table->decimal('vmp', 8, 3)->comment('Voltage at max power');
            $table->decimal('imp', 8, 3)->comment('Current at max power');
            $table->decimal('max_system_voltage', 8, 2);
            $table->decimal('temperature_coefficient', 6, 4)->comment('Power temperature coefficient');
            $table->string('power_tolerance');
            $table->string('product_warranty');
            $table->string('performance_warranty');
            $table->boolean('iec_61215')->default(false);
            $table->boolean('iec_61730')->default(false);
            $table->string('connector_type');
            $table->string('dimensions');
            $table->decimal('weight', 8, 2);
            $table->string('datasheet_path')->nullable();
            $table->string('datasheet_version')->nullable();
            $table->string('union_approval_status')->nullable();
            $table->date('production_date')->nullable();
            $table->date('discontinuation_date')->nullable();
            $table->boolean('lab_certified')->default(false);
            $table->string('lab_name')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('panels_catalog');
    }
};
