<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = [
            [
                'name' => '4 State Trucks',
                'website' => 'https://www.4statetrucks.com/',
                'phone' => '(888) 875-7787',
                'email' => 'info@4statetrucks.com',
                'pipeline_company_id' => 438,
                'theme_id' => 7,
                'enable_map' => 0,
                'is_active' => 0,
                'requires_brand' => 0,
            ],
            [
                'name' => 'Jayco',
                'website' => 'https://www.jayco.com/',
                'phone' => '(800) 785-2926',
                'email' => 'info@jayco.com',
                'pipeline_company_id' => 120,
                'theme_id' => 8,
                'enable_map' => 1,
                'is_active' => 1,
                'requires_brand' => 0,
            ],
            [
                'name' => 'Loftwall',
                'website' => 'https://loftwall.com/',
                'phone' => '(214) 239-3162',
                'email' => 'info@loftwall.com',
                'pipeline_company_id' => 472,
                'theme_id' => 9,
                'enable_map' => 0,
                'is_active' => 0,
                'requires_brand' => 0,
            ],
            [
                'name' => 'Ubique',
                'website' => 'https://www.theubiquegroup.com/',
                'phone' => '(123) 456-7890',
                'email' => 'info@theubiquegroup.com',
                'pipeline_company_id' => 742,
                'theme_id' => 10,
                'enable_map' => 1,
                'is_active' => 1,
                'requires_brand' => 1,
                'brand' => 'ubique',
            ],
        ];

        foreach ($companies as $company) {
            Company::factory()->create($company);
        }
    }
}
