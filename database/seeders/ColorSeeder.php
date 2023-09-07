<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('colors')->insert([
            'name' => 'blue',
        ]);
        DB::table('colors')->insert([
            'name' => 'red',
        ]);
        DB::table('colors')->insert([
            'name' => 'orange',
        ]);
        DB::table('colors')->insert([
            'name' => 'green',
        ]);
        DB::table('colors')->insert([
            'name' => 'purple',
        ]);
    }
}
