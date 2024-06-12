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
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'create_by_user_id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'update_by_user_id');
    }

}
