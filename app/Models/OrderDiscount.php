<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderDiscount extends Pivot
{
    protected $table = 'order_discount';

    protected $fillable = [
        'order_id',
        'discount_id',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }
}
