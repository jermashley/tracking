<?php

namespace Database\Seeders;

use App\Enums\ImageTypeEnum;
use App\Models\ImageType;
use Illuminate\Database\Seeder;

class ImageTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (ImageTypeEnum::cases() as $imageType) {
            ImageType::create([
                'name' => $imageType->value,
            ]);
        }
    }
}
