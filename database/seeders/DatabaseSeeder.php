<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ThemeSeeder::class,
            ImageTypeSeeder::class,
            ImageSeeder::class,
            CompanySeeder::class,
            RolesAndPermissionsSeeder::class,
            UserSeeder::class,
            AllowedDomainSeeder::class,
        ]);
    }
}
