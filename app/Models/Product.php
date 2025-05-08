<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'category_id',
        'unit_id',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_product')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }
    // Product.php
    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }
    // app/Models/Product.php

    public function totalInventoryQuantity()
    {
        return $this->inventories()->sum('quantity');
    }
    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class, 'product_supplier')
            ->using(ProductSupplier::class)
            ->withPivot(['quantity', 'price'])
            ->withTimestamps();
    }
}
