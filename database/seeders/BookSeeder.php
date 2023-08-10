<?php

declare(strict_types=1);

namespace Database\Seeders;

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
            'name' => '青チャート',
            'subject_id' => '2',
            'type_id' => '1',
            'max' => '100',
        ]);

        DB::table('books')->insert([
            'name' => 'チャート',
            'subject_id' => '1',
            'type_id' => '1',
            'max' => '3',
        ]);
    }
}
