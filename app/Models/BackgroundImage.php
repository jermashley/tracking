<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BackgroundImage extends Model
{
    /** @use HasFactory<\Database\Factories\BackgroundFactory> */
    use HasFactory, HasUuid;

    protected $fillable = [
        'name',
        'url',
        'is_system',
    ];

    public function companies(): HasMany
    {
        return $this->hasMany(Company::class);
    }
}
