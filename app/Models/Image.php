<?php

namespace App\Models;

use App\Enums\ImageTypeEnum;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    /** @use HasFactory<\Database\Factories\ImageFactory> */
    use HasFactory, HasUuid;

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($image) {
            switch ($image->type) {
                case ImageTypeEnum::LOGO->value:
                    Company::where('logo_image_id', $image->id)->update(['logo_image_id' => null]);
                    break;

                case ImageTypeEnum::BANNER->value:
                    Company::where('logo_banner_id', $image->id)->update(['logo_banner_id' => null]);
                    break;

                case ImageTypeEnum::FOOTER->value:
                    Company::where('logo_footer_id', $image->id)->update(['logo_footer_id' => null]);
                    break;

                default:
                    return;
            }
        });
    }

    protected $fillable = [
        'name',
        'file_path',
        'image_type_id',
    ];
}
