<?php

namespace App\Actions;

class GenerateThemeColors
{
    public static function execute(array $data): array
    {
        $primaryHue = $data['primary']['hue'];
        $primarySaturation = $data['primary']['saturation'];
        $primaryLightness = $data['primary']['brightness'];

        $accentHue = $data['accent']['hue'];
        $accentSaturation = $data['accent']['saturation'];
        $accentLightness = $data['accent']['brightness'];

        $deriveFrom = $data['deriveFrom'];

        switch ($deriveFrom) {
            case 'primary':
                $baseHue = $primaryHue;
                break;
            case 'accent':
                $baseHue = $accentHue;
                break;
            default:
                $baseHue = $primaryHue;
                break;
        }

        return [
            'root' => [
                'background' => "$baseHue 70% 99%",
                'foreground' => "$baseHue 90% 8%",
                'muted' => "$baseHue 60% 97%",
                'mutedForeground' => "$baseHue 50% 15%",
                'popover' => "$baseHue 100% 99%",
                'popoverForeground' => "$baseHue 90% 8%",
                'card' => "$baseHue 70% 99%",
                'cardForeground' => "$baseHue 90% 8%",
                'border' => "$baseHue 66% 92%",
                'input' => "$baseHue 66% 92%",
                'primary' => "$primaryHue $primarySaturation% $primaryLightness%",
                'primaryForeground' => "$primaryHue 100% 99%",
                'secondary' => "$baseHue 50% 96%",
                'secondaryForeground' => "$baseHue 40% 26%",
                'accent' => "$accentHue $accentSaturation% $accentLightness%",
                'accentForeground' => "$accentHue 50% 96%",
                'destructive' => '349 75% 58%',
                'destructiveForeground' => '349 80% 97%',
                'ring' => "$baseHue 85% 80%",
            ],
        ];
    }
}
