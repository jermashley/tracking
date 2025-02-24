<?php

use App\Models\Image;
use App\Models\Theme;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->boolean('is_active')->default(true);
            $table->string('name');
            $table->string('website')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->integer('pipeline_company_id')->unique();
            $table->foreignIdFor(Image::class, 'logo_image_id')->nullable();
            $table->foreignIdFor(Image::class, 'banner_image_id')->nullable();
            $table->foreignIdFor(Image::class, 'footer_image_id')->nullable();
            $table->foreignIdFor(Theme::class)->nullable();
            $table->boolean('enable_map')->default(false);
            $table->boolean('requires_brand')->default(false);
            $table->string('brand')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
