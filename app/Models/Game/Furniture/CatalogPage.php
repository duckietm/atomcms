<?php

namespace App\Models\Game\Furniture;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CatalogPage extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function catalogItems(): HasMany
    {
        return $this->hasMany(CatalogItem::class, 'page_id');
    }
}
