<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'suppliers';

    protected $fillable = [
        'name',
        'contact',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_supplier')
                    ->using(ProductSupplier::class)
                    ->withPivot(['quantity', 'price'])
                    ->withTimestamps();
    }
}
