<?php

declare(strict_types=1);

namespace Database\Seeders;

use DateTimeImmutable;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Book_mgmtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('book_mgmts')->insert([
            'user_id' => '1',
            'book_id' => '1',
            'a_day' => '3',
            'today_finished' => '0',
            'intarval_id' => '1',
            'next_learn_at' => new DateTimeImmutable(),
        ]);

        DB::table('book_mgmts')->insert([
            'user_id' => '1',
            'book_id' => '2',
            'a_day' => '10',
            'today_finished' => '0',
            'intarval_id' => '1',
            'next_learn_at' => new DateTimeImmutable('+1 day'),
        ]);
    }
}
