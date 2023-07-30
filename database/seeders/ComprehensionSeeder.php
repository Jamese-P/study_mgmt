<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComprehensionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::tabel('comprehensions')->insert([
            'name'=>'完璧',
            ]);
        DB::tabel('comprehensions')->insert([
            'name'=>'50%',
            ]);
        DB::tabel('comprehensions')->insert([
            'name'=>'とき直し',
            ]);
    }
}
