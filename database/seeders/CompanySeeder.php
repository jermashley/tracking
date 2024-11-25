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
            ],
            [
                'name' => '4 State Trucks',
                'pipeline_company_id' => 438,
                'theme_id' => 1,
            ],
            [
                'name' => 'Jayco',
                'pipeline_company_id' => 120,
                'theme_id' => 1,
            ],
            [
                'name' => 'Ubique',
                'pipeline_company_id' => 742,
                'theme_id' => 1,
            ],
        ];

        foreach ($companies as $company) {
            Company::factory()->create($company);
        }
    }
}
