<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = [
        'name',
        'type',
        'value',
        'is_active',
    ];

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_discount')
                    ->withTimestamps();
    }
}
