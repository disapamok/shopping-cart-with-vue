<?php

namespace App\Models;

use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const ORDER_NUMBER_PREFIX = "ABC";

    protected $appends = ['created_date'];

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->format('Y-m-d h:i A');
    }
}
