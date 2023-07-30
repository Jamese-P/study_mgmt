<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subjects')->insert([
            'name'=>'国語',
            ]);
        DB::table('subjects')->insert([
            'name'=>'数学',
            ]);
        DB::table('subjects')->insert([
            'name'=>'英語',
            ]);
        DB::table('subjects')->insert([
            'name'=>'理科',
            ]);
        DB::table('subjects')->insert([
            'name'=>'社会',
            ]);
    }
}
