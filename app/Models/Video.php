<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function playlist()
    {
        return $this->belongsTo(VideoPlaylist::class, 'playlist_id', 'id');
    }
}
