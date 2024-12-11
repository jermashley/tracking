<?php

namespace App\Models;

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
            Company::where('logo_image_id', $image->id)->update(['logo_image_id' => null]);
        });
    }

    protected $fillable = [
        'name',
        'file_path',
        'image_type_id',
    ];
}
