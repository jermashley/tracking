<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Theme extends Model
{
    /** @use HasFactory<\Database\Factories\ThemeFactory> */
    use HasFactory, HasUuid;

    protected $fillable = [
        'name',
        'colors',
        'radius',
        'is_system',
    ];

    protected $casts = [
        'colors' => 'array',
        'is_system' => 'boolean',
    ];
}
