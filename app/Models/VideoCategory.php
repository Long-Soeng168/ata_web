<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image', 'description'];

    public function videos()
    {
        return $this->hasMany(Video::class, 'category_id');
    }
}
