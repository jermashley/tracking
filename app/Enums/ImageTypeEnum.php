<?php

namespace App\Enums;

enum ImageTypeEnum: string
{
    case LOGO = 'Logo';
    case BANNER = 'Banner';
    case PROFILE = 'Profile';
    case BACKGROUND = 'Background';
}
