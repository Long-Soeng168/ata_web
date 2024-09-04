<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoPlaylist extends Model
{
    use HasFactory;

    protected $table = 'video_playlists';
    protected $guarded = [];

    public function videos()
    {
        return $this->hasMany(Video::class, 'playlist_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(VideoCategory::class, 'category_id', 'id');
    }

}
