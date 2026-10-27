<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorkCategory extends Model
{
    protected $fillable = [
        'legacy_cid',
        'name',
        'slug',
        'sort_order',
    ];

    public function works(): HasMany
    {
        return $this->hasMany(Work::class)->orderBy('sort_order');
    }
}
