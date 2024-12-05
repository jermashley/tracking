<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Company extends Model
{
    /** @use HasFactory<\Database\Factories\CompanyFactory> */
    use HasFactory, HasUuid;

    protected $fillable = [
        'name',
        'logo',
        'website',
        'phone',
        'email',
        'pipeline_company_id',
        'logo_image_id',
        'theme_id',
        'enable_map',
    ];

    public function logo(): BelongsTo
    {
        return $this->belongsTo(Image::class, 'logo_image_id');
    }

    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class);
    }

    public static function booleanFields(): array
    {
        return [
            'enable_map',
        ];
    }
}
