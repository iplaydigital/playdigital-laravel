<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'code',
        'title',
        'subtitle',
        'icon_path',
        'sort_order',
    ];
}
