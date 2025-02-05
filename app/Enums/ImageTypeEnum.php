<?php

namespace App\Enums;

enum ImageTypeEnum: string
{
    case LOGO = 'logo';
    case BANNER = 'banner';
    case PROFILE = 'profile';
    case BACKGROUND = 'background';
    case FOOTER = 'footer';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
