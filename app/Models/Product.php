<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = "products";
    protected $guarded = [
        'create_by_user_id',
        'shop_id',
    //    'status'
    ];
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function brandmodel()
    {
        return $this->hasOne(BrandModel::class);
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
