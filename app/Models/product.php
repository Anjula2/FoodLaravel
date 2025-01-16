<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    protected $table = 'products';
    
    protected $fillable = [
        'name',
        'description',
        'price',
        'image_path',
    ];

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}