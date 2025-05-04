<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventory'; // because it's not the default plural "inventories"

    protected $fillable = [
        'product_id',
        'quantity',
        'expiration_date',
    ];

    // Relationship
    // Inventory.php (Model)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
