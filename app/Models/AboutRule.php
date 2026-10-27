<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutRule extends Model
{
    protected $fillable = [
        'title',
        'description',
        'icon_path',
        'sort_order',
    ];
}
