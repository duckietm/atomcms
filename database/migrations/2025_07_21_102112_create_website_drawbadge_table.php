<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('website_settings')->insert([
            [
                'key' => 'drawbadge_currency_value',
                'value' => '150',
                'comment' => 'Adjust here the amount that is required for buying a custom badge',
            ],
            [
                'key' => 'drawbadge_currency_type',
                'value' => 'credits',
                'comment' => 'Adjust here the currency type (credits, duckets, diamonds, points)',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('website_settings')->whereIn('key', [
            'drawbadge_currency_value',
            'drawbadge_currency_type',
        ])->delete();
    }
};