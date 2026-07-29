<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // اضافه کردن نقش بازرس اگر وجود نداشت
        $exists = DB::table('behin_roles')->where('name', 'بازرس')->exists();
        if (! $exists) {
            DB::table('behin_roles')->insert([
                'name'       => 'بازرس',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        DB::table('behin_roles')->where('name', 'بازرس')->delete();
    }
};
