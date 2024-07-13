<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function videocategory()
    {
        return $this->belongsTo(VideoCategory::class, 'category_id', 'id');
    }
}
