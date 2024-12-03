<?php

namespace Database\Seeders;

use App\Models\Theme;
use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = [
            [
                'name' => 'Cranberry',
                'colors' => [
                    'root' => [
                        'background' => '332 70% 99%',
                        'foreground' => '332 90% 8%',
                        'muted' => '332 60% 97%',
                        'mutedForeground' => '332 50% 15%',
                        'popover' => '332 100% 99%',
                        'popoverForeground' => '332 90% 8%',
                        'card' => '332 70% 99%',
                        'cardForeground' => '332 90% 8%',
                        'border' => '332 90% 95%',
                        'input' => '332 90% 95%',
                        'primary' => '332 76% 43%',
                        'primaryForeground' => '332 100% 99%',
                        'secondary' => '332 50% 96%',
                        'secondaryForeground' => '332 81% 26%',
                        'accent' => '148 25% 50%',
                        'accentForeground' => '148 50% 97%',
                        'destructive' => '349 75% 58%',
                        'destructiveForeground' => '349 80% 97%',
                        'ring' => '332 85% 80%',
                    ],
                ],
                'radius' => '0.5rem',
                'is_system' => true,
            ],
            [
                'name' => 'Rostro',
                'colors' => [
                    'root' => [
                        'background' => '212 100% 99%',
                        'foreground' => '212 90% 8%',
                        'muted' => '212 60% 97%',
                        'mutedForeground' => '212 50% 15%',
                        'popover' => '212 100% 99%',
                        'popoverForeground' => '212 90% 8%',
                        'card' => '212 100% 99%',
                        'cardForeground' => '212 90% 8%',
                        'border' => '212 66% 92%',
                        'input' => '212 66% 92%',
                        'primary' => '212 65% 40%',
                        'primaryForeground' => '212 100% 99%',
                        'secondary' => '212 50% 96%',
                        'secondaryForeground' => '212 40% 26%',
                        'accent' => '34 90% 52%',
                        'accentForeground' => '34 50% 96%',
                        'destructive' => '349 75% 58%',
                        'destructiveForeground' => '349 80% 97%',
                        'ring' => '212 85% 80%',
                    ],
                ],
                'radius' => '0.5rem',
                'is_system' => true,
            ],
            [
                'name' => 'Spruce',
                'colors' => [
                    'root' => [
                        'background' => '159 70% 99%',
                        'foreground' => '159 90% 8%',
                        'muted' => '159 60% 97%',
                        'mutedForeground' => '159 50% 15%',
                        'popover' => '159 100% 99%',
                        'popoverForeground' => '159 90% 8%',
                        'card' => '159 70% 99%',
                        'cardForeground' => '159 90% 8%',
                        'border' => '159 66% 92%',
                        'input' => '159 66% 92%',
                        'primary' => '159 90% 34%',
                        'primaryForeground' => '159 100% 99%',
                        'secondary' => '159 50% 96%',
                        'secondaryForeground' => '159 50% 25%',
                        'accent' => '292 37% 59%',
                        'accentForeground' => '292 70% 98%',
                        'destructive' => '349 75% 58%',
                        'destructiveForeground' => '349 80% 97%',
                        'ring' => '159 65% 80%',
                    ],
                ],
                'radius' => '0.5rem',
                'is_system' => true,
            ],
            [
                'name' => 'Honeybee',
                'colors' => [
                    'root' => [
                        'background' => '54 70% 99%',
                        'foreground' => '54 90% 8%',
                        'muted' => '54 60% 97%',
                        'mutedForeground' => '54 50% 15%',
                        'popover' => '54 100% 99%',
                        'popoverForeground' => '54 90% 8%',
                        'card' => '54 70% 99%',
                        'cardForeground' => '54 90% 8%',
                        'border' => '54 66% 92%',
                        'input' => '54 66% 92%',
                        'primary' => '54 65% 62%',
                        'primaryForeground' => '54 70% 10%',
                        'secondary' => '54 50% 96%',
                        'secondaryForeground' => '54 92% 38%',
                        'accent' => '0 88% 68%',
                        'accentForeground' => '0 50% 97%',
                        'destructive' => '349 75% 58%',
                        'destructiveForeground' => '349 80% 97%',
                        'ring' => '54 65% 80%',
                    ],
                ],
                'radius' => '0.5rem',
                'is_system' => true,
            ],
            [
                'name' => 'Strawbaerie',
                'colors' => [
                    'root' => [
                        'background' => '22 70% 99%',
                        'foreground' => '22 90% 8%',
                        'muted' => '22 60% 97%',
                        'mutedForeground' => '22 50% 15%',
                        'popover' => '22 100% 99%',
                        'popoverForeground' => '22 90% 8%',
                        'card' => '22 70% 99%',
                        'cardForeground' => '22 90% 8%',
                        'border' => '22 66% 92%',
                        'input' => '22 66% 92%',
                        'primary' => '22 87% 55%',
                        'primaryForeground' => '22 70% 99%',
                        'secondary' => '22 50% 96%',
                        'secondaryForeground' => '22 97% 38%',
                        'accent' => '94 50% 49%',
                        'accentForeground' => '94 50% 97%',
                        'destructive' => '349 75% 58%',
                        'destructiveForeground' => '349 80% 97%',
                        'ring' => '22 65% 80%',
                    ],
                ],
                'radius' => '0.5rem',
                'is_system' => true,
            ],
        ];

        foreach ($colors as $color) {
            Theme::create($color);
        }
    }
}
