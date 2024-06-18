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
}
