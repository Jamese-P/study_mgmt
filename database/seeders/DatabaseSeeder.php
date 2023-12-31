<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            TypeSeeder::class,
            IntarvalSeeder::class,
            SubjectSeeder::class,
            ComprehensionSeeder::class,
            ColorSeeder::class,
            //BookSeeder::class,
            //Book_mgmtSeeder::class,
        ]);
    }
}
