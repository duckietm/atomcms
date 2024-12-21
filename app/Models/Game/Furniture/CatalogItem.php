<?php

namespace App\Models\Game\Furniture;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CatalogItem extends Model
{
    protected $guarded = ['id'];

    public $timestamps = false;

    public function itemBase(): BelongsTo
    {
        return $this->belongsTo(ItemBase::class, 'item_ids', 'id');
    }
}
