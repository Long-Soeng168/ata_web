<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BodyType extends Model
{
    use HasFactory;
    protected $table = "body_types";
    protected $guarded = [];
    public function products()
    {
        return $this->belongsTo(Product::class);
    }
}
