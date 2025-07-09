<?php

namespace Database\Seeders;

use App\Models\AllowedDomain;
use App\Models\User;
use Illuminate\Database\Seeder;

class AllowedDomainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // AllowedDomain::factory()
        //     ->count(10)
        //     ->create();

        AllowedDomain::create([
            'domain' => 'prologuetechnology.com',
            'description' => 'Prologue Technology (technology arm of Flat World Global Solutions)',
            'is_active' => true,
            'created_by' => User::inRandomOrder()->first()->id,
            'updated_by' => User::inRandomOrder()->first()->id,
        ]);
    }
}
