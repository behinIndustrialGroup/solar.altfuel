<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop the unique index first so we can update duplicates (only if it exists)
        Schema::table('solar_plant_requests', function (Blueprint $table) {
            $indexes = collect(DB::select("SHOW INDEX FROM solar_plant_requests WHERE Key_name = 'solar_plant_requests_unique_code_unique'"));
            if ($indexes->isNotEmpty()) {
                $table->dropUnique('solar_plant_requests_unique_code_unique');
            }
        });

        // Backfill empty/null unique_code values for existing rows
        $rows = DB::table('solar_plant_requests')
            ->whereNull('unique_code')
            ->orWhere('unique_code', '')
            ->get(['id']);

        foreach ($rows as $row) {
            $code = self::generateUniqueCode();
            // Ensure no collision with codes already in the table
            while (DB::table('solar_plant_requests')->where('unique_code', $code)->exists()) {
                $code = self::generateUniqueCode();
            }
            DB::table('solar_plant_requests')
                ->where('id', $row->id)
                ->update(['unique_code' => $code]);
        }

        // Re-add the unique index now that all rows have distinct codes
        Schema::table('solar_plant_requests', function (Blueprint $table) {
            $table->unique('unique_code');
        });
    }

    public function down(): void
    {
        // Nothing to reverse — backfilled codes are benign
    }

    private static function generateUniqueCode(): string
    {
        $prefix = 'SPR';
        $timestamp = time();
        $random = strtoupper(substr(bin2hex(random_bytes(3)), 0, 4));
        return $prefix . $timestamp . $random;
    }
};
