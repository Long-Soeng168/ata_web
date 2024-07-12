<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GaragePost extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function garages() {
        return $this->belongsTo(Garage::class, 'garage_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'create_by_user_id', 'id');
    }

}
