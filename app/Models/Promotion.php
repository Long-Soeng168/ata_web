<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'garage_id',
        'title',
        'description',
        'start_date',
        'end_date',
        'image'
    ];

    public function garage()
    {
        return $this->belongsTo(Garage::class, 'garage_id');
    }
}

