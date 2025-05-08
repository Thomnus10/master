<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Inventory;
use App\Models\Product;
use Carbon\Carbon;

class InventorySeeder extends Seeder
{
    public function run()
    {
        $products = Product::all();

        foreach ($products as $product) {
            Inventory::create([
                'product_id' => $product->id,
                'quantity' => rand(10, 100),
                'expiration_date' => Carbon::now()->addMonths(rand(1, 12)),
            ]);
        }
    }
}
