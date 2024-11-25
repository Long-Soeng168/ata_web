<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoPlaylistUser extends Model
{
    use HasFactory;

    protected $table = 'video_playlist_user';
    protected $guarded = [];
 
}
