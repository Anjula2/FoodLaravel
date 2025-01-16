<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'carts';
    
    protected $fillable = [
        'name',
        'phone',
        'address',
        'product_title',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
