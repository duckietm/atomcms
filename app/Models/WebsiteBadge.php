<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteBadge extends Model
{
    use HasFactory;

    protected $fillable = [
        'badge_key',
        'badge_name',
        'badge_description',
    ];
}
