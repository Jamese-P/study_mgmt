<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IntarvalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::tabel('intarvals')->insert([
            'name'=>'毎日',
            'days'=>'1'
            ]);
        DB::tabel('intarvals')->insert([
            'name'=>'二日おき',
            'days'=>'2'
            ]);
        DB::tabel('intarvals')->insert([
            'name'=>'三日おき',
            'days'=>'3'
            ]);
        DB::tabel('intarvals')->insert([
            'name'=>'毎週',
            'days'=>'7'
            ]);
    }
}
