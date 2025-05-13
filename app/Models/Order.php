<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Order extends Model
{
    use HasFactory;

    // In Order.php
    protected $fillable = [
        'employee_id',
        'total_amount',
        'order_date',
        'status',
        'subtotal',
        'tax',
        'discount',
        'discount_amount',
        'payment_method',
        'amount_tendered',
        'change_amount',
        'notes',
    ];

    protected $casts = [
        'order_date' => 'datetime',
        'total_amount' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'amount_tendered' => 'decimal:2',
        'change_amount' => 'decimal:2',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_product')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }
    public function payment()
    {
        return $this->hasOne(Payment::class, 'order_id');
    }
    public function discounts()
    {
        return $this->belongsToMany(Discount::class, 'order_discount')
            ->withTimestamps();
    }
    public function getDiscountAmountAttribute()
    {
        if (!$this->discount_id) return 0;

        if ($this->discount_type === 'percentage') {
            return ($this->subtotal + $this->tax) * ($this->discount_value / 100);
        }

        return min($this->discount_value, $this->subtotal + $this->tax);
    }

    public function getTotalAmountAttribute()
    {
        return ($this->subtotal + $this->tax) - $this->discount_amount;
    }
}
