<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use DateTime;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::tabel('users')->insert([
            'name'=>'test',
            'email'=>'example.com',
            'password'=>Hash::make('password'),
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
            ]);
    }
}
