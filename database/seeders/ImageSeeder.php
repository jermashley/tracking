<?php

namespace Database\Seeders;

use App\Models\Image;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $images = [
            [
                'name' => '4 State Trucks Logo',
                'file_path' => '/images/company_logos/4-state.png',
            ],
            [
                'name' => 'Jayco Logo',
                'file_path' => '/images/company_logos/jayco.png',
            ],
            [
                'name' => 'Loftwall Logo',
                'file_path' => '/images/company_logos/loftwall.svg',
            ],
            [
                'name' => 'Ubique Group Logo',
                'file_path' => '/images/company_logos/ubique.png',
            ],
        ];

        foreach ($images as $image) {
            Image::factory()->create($image);
        }
    }
}
