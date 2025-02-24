<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;

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
        'banner_image_id',
        'footer_image_id',
        'theme_id',
        'enable_map',
        'requires_brand',
        'brand'
    ];

    public function logo(): BelongsTo
    {
        return $this->belongsTo(Image::class, 'logo_image_id');
    }

    public function banner(): BelongsTo
    {
        return $this->belongsTo(Image::class, 'banner_image_id');
    }

    public function footer(): BelongsTo
    {
        return $this->belongsTo(Image::class, 'footer_image_id');
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

    public static function findByIdentifier(?string $brand = null, ?int $companyId = null, ?int $pipelineCompanyId = null): ?self
    {
        try {
            $query = self::query()
                ->where('is_active', true)
                ->with(['logo', 'banner', 'footer', 'theme']);

            switch (true) {
                case $brand:
                    $company = $query->where('brand', $brand)->first();

                    if ($company->pipeline_company_id !== $pipelineCompanyId) {
                        return $company = null;
                    }
                    break;
                case $companyId:
                    $company = $query->where('pipeline_company_id', $companyId)->first();
                    break;
                case $pipelineCompanyId:
                    $company = $query->where('pipeline_company_id', $pipelineCompanyId)->first();
                    break;
                default:
                    return null;
            }

            if ($company && $company->requires_brand && !$brand) {
                return null;
            }

            return $company;
        } catch (\Exception $e) {
            Log::channel('database')->error('Error finding company by identifier: ' . $e->getMessage());
            return null;
        }
    }
}
