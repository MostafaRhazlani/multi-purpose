<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('settings')->insert([
            [
                'key' => 'page_name',
                'value' => 'Test App',
            ],

            [
                'key' => 'date_format',
                'value' => 'MM/DD/YYYY',
            ],

            [
                'key' => 'pagination_limit',
                'value' => 10,
            ],
        ]);
    }
}
