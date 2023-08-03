<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class ComprehensionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comprehensions')->insert([
            'name' => '--',
        ]);
        DB::table('comprehensions')->insert([
            'name' => '完璧',
        ]);
        DB::table('comprehensions')->insert([
            'name' => '50%',
        ]);
        DB::table('comprehensions')->insert([
            'name' => 'とき直し',
        ]);
    }
}
