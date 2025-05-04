<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Inventory;
use Carbon\Carbon;

class InventorySeeder extends Seeder
{
    public function run()
    {
        // Assuming product IDs from 12 to 25
        foreach (range(12, 25) as $productId) {
            Inventory::create([
                'product_id' => $productId,
                'quantity' => rand(20, 30),
                'expiration_date' => Carbon::now()->addDays(rand(30, 180)), // expires in 1 to 6 months
            ]);
        }
    }
}
