<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subjects')->insert([
            'name' => '国語',
        ]);
        DB::table('subjects')->insert([
            'name' => '数学',
        ]);
        DB::table('subjects')->insert([
            'name' => '英語',
        ]);
        DB::table('subjects')->insert([
            'name' => '理科',
        ]);
        DB::table('subjects')->insert([
            'name' => '社会',
        ]);
    }
}
