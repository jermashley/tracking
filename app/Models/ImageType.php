<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageType extends Model
{
    /** @use HasFactory<\Database\Factories\ImageTypeFactory> */
    use HasFactory, HasUuid;
}
