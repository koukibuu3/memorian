<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        DB::table('statuses')->insert([
            ['id' => 1, 'name' => 'ToDo', 'color_code' => '#00D763', 'created_at' => $now],
            ['id' => 2, 'name' => 'Doing', 'color_code' => '#0070D7', 'created_at' => $now],
            ['id' => 3, 'name' => 'in Review', 'color_code' => '#D77400', 'created_at' => $now],
            ['id' => 4, 'name' => 'Done', 'color_code' => '#AAAAAA', 'created_at' => $now],
        ]);
    }
}
