<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerRequest extends Model
{
    protected $fillable = [
        'user_id',
        'customer_name',
        'email',
        'meal_name',
        'message',
        'image_path',
        'description',
        'price',
        'is_accepted',
    ];
}
