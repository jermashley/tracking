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
                'name' => 'Loftwall',
                'pipeline_company_id' => 472,
                'theme_id' => 1,
                'enable_map' => 1,
                'logo' => '/images/company_logos/loftwall.svg',
            ],
            [
                'name' => '4 State Trucks',
                'pipeline_company_id' => 438,
                'theme_id' => 2,
                'enable_map' => 1,
                'logo' => '/images/company_logos/4-state.png',
            ],
            [
                'name' => 'Jayco',
                'pipeline_company_id' => 120,
                'theme_id' => 3,
                'enable_map' => 1,
                'logo' => '/images/company_logos/jayco.png',
            ],
            [
                'name' => 'Ubique',
                'pipeline_company_id' => 742,
                'theme_id' => 4,
                'enable_map' => 1,
                'logo' => '/images/company_logos/ubique.png',
            ],
        ];

        foreach ($companies as $company) {
            Company::factory()->create($company);
        }
    }
}
