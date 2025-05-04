<?php

namespace Database\Seeders; // <-- This is the missing part

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Bread and Bakery',
            'Canned and Jarred Goods',
            'Snacks and Chips',
            'Frozen Foods',
            'Beverages',
            'Condiments and Sauces',
            'Spices and Seasonings',
        ];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
