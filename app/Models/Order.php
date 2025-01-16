<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'customer_name',
        'contact_number',
        'shipping_address',
        'total_price',
        'total_items', 
        'items',
        'status',
        'delivery_method',
        'is_completed',
    ];

    protected $casts = [
        'items' => 'array',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class); 
    }

}
