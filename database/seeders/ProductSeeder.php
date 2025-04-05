<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Adding sample products to the database
        Product::create([
            'name' => 'Rice',
            'category' => 'Grains',
            'stock' => 100,
            'price' => 50.00
        ]);

        Product::create([
            'name' => 'Milk',
            'category' => 'Dairy',
            'stock' => 50,
            'price' => 70.00
        ]);

        Product::create([
            'name' => 'Eggs',
            'category' => 'Poultry',
            'stock' => 200,
            'price' => 10.00
        ]);
    }
}
