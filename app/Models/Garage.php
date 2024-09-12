<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Garage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'location', 'user_id', 'like', 'unlike', 'rate', 'comment', 'logo', 'banner', 'bio'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function promotions()
    {
        return $this->hasMany(Promotion::class);
    }

    public function garagePosts()
    {
        return $this->hasMany(GaragePost::class);
    }

    public function expert()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }
}
