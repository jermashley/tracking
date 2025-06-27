<?php

namespace App\Models;

use App\Traits\HasUuid;
use Database\Factories\CompanyFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Log;

/**
 * @property int $id
 * @property string $uuid
 * @property int $is_active
 * @property string $name
 * @property string|null $website
 * @property string|null $phone
 * @property string|null $email
 * @property int $pipeline_company_id
 * @property int|null $logo_image_id
 * @property int|null $banner_image_id
 * @property int|null $footer_image_id
 * @property int|null $theme_id
 * @property int $enable_map
 * @property int $requires_brand
 * @property string|null $brand
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read CompanyApiToken|null $apiToken
 * @property-read \App\Models\Image|null $banner
 * @property-read \App\Models\Image|null $footer
 * @property-read \App\Models\Image|null $logo
 * @property-read \App\Models\Theme|null $theme
 *
 * @method static CompanyFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereBannerImageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereEnableMap($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereFooterImageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereLogoImageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company wherePipelineCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereRequiresBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereThemeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereWebsite($value)
 *
 * @mixin \Eloquent
 */
class Company extends Model
{
    /** @use HasFactory<CompanyFactory> */
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
        'brand',
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

    public function apiToken(): HasOne
    {
        return $this->hasOne(CompanyApiToken::class);
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
                    $company = $query->whereRaw('BINARY `brand` = ?', [$brand])->first();

                    if ($company->pipeline_company_id !== $pipelineCompanyId) {
                        return $company = null;
                    }

                    break;
                case $companyId:
                    $company = $query->where('pipeline_company_id', $companyId)->first();

                    if ($company->pipeline_company_id !== $pipelineCompanyId) {
                        return $company = null;
                    }

                    break;
                case $pipelineCompanyId:
                    $company = $query->where('pipeline_company_id', $pipelineCompanyId)->first();

                    break;
                default:
                    return null;
            }

            if ($company && $company->requires_brand && ! $brand) {
                return null;
            }

            return $company;
        } catch (\Exception $e) {
            Log::channel('database')->error('Error finding company by identifier: '.$e->getMessage());

            return null;
        }
    }
}
