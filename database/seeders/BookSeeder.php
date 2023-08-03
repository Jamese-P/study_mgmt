<?php

declare(strict_types=1);

namespace Database\Seeders;

use DateTimeImmutable;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('books')->insert([
            'user_id' => '1',
            'name' => '青チャート',
            'subject_id' => '2',
            'type_id' => '1',
            'max' => '100',
            'a_day' => '3',
            'finished' => '0',
            'today_finished' => '0',
            'intarval_id' => '1',
            'next_learn_at' => new DateTimeImmutable(),
        ]);

        DB::table('books')->insert([
            'user_id' => '1',
            'name' => 'チャート',
            'subject_id' => '1',
            'type_id' => '1',
            'max' => '3',
            'a_day' => '10',
            'finished' => '0',
            'today_finished' => '0',
            'intarval_id' => '1',
            'next_learn_at' => new DateTimeImmutable('+1 day'),
        ]);
    }
}
