<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Work extends Model
{
    protected $fillable = [
        'legacy_id',
        'work_category_id',
        'slug',
        'title',
        'subtitle',
        'client_name',
        'product_name',
        'campaign_name',
        'media_type',
        'description',
        'thumbnail',
        'gallery_images',
        'youtube_id',
        'external_url',
        'is_featured_home',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'gallery_images' => 'array',
            'is_featured_home' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(WorkCategory::class, 'work_category_id');
    }

    public function isVideo(): bool
    {
        return ! empty($this->youtube_id);
    }
}
