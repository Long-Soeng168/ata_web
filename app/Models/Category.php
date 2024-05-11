<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    use HasFactory;
    protected $table = "categories";
    protected $guarded = [];

    public function shop() {
        return $this->belongsTo(Shop::class, 'shop_id', 'id');
    }

    public function items() {
        return $this->hasMany(Item::class, 'category_id', 'id');
    }
}
