<?php

namespace Database\Seeders; 

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Unit;
use App\Models\Supplier;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['FITA Crackers','lightly salted, round crackers',62.00,'1','4'],
            ['Milk','Essential for cooking, baking, or drinking.',140.00,'2','4'],
            ['Butter','Adds rich flavor to baking, cooking, and spreads.',196.00,'2','1'],
            ['Cheddar Cheese','Sharp and creamy, perfect for sandwiches or snacking.',224.00,'2','1'],
            ['Yogurt','Creamy and tangy, great for breakfast or a snack.',42.00,'2','4'],
            ['Eggs','Versatile for cooking, baking, or scrambling.',112.00,'2','5'],
            ['Chicken Breasts','Lean and protein-packed, great for grilling or baking.',280.00,'3','1'],
            ['Ground Beef','Perfect for burgers, tacos, and meatballs.',252.00,'3','1'],
            ['Salmon Fillets','Rich in omega-3s, great for grilling or baking.',448.00,'3','1'],
            ['Shrimp','Sweet and tender, ideal for stir-fries, grilling, or shrimp cocktails.',336.00,'3','1'],
            ['Bacon','Crispy and flavorful, perfect for breakfast or adding to dishes.',308.00,'3','1'],
            ['Whole Wheat Bread','Nutritious and hearty, perfect for sandwiches.',140.00,'4','4'],
            ['Croissants','Flaky and buttery, perfect for breakfast or snacking.',84.00,'4','4'],
            ['Bagels (6-pack)','Soft and chewy, ideal for breakfast with cream cheese.',168.00,'4','5'],
            ['Muffins (4-pack)','Sweet and fluffy, a perfect morning treat.',224.00,'4','5'],
            ['Pizza Dough','Ready-to-use dough for homemade pizza nights.',168.00,'4','4'],
            ['Canned Tomatoes','Perfect for sauces, soups, or stews.',84.00,'5','4'],
            ['Canned Beans','Protein-rich, ideal for salads or stews.',56.00,'5','4'],
            ['Peanut Butter','Creamy or crunchy, great for sandwiches or snacks.',168.00,'5','4'],
            ['Jam','Sweet and fruity, perfect for spreading on toast.',196.00,'5','4'],
            ['Canned Tuna','Quick and easy protein for salads or sandwiches.',56.00,'5','4'],
            ['Potato Chips','Crispy and salty, perfect for snacking.',140.00,'6','4'],
            ['Pretzels','Salty and crunchy snack for any time.',168.00,'6','4'],
            ['Granola Bars (Box of 6)','Healthy and filling for on-the-go energy.',196.00,'6','9'],
            ['Popcorn','Light and airy, great for movie nights.',84.00,'6','3'],
            ['Tortilla Chips','Crunchy and ideal for dips.',168.00,'6','3'],
            ['Frozen Pizza','Quick and easy meal with various toppings.',336.00,'7','4'],
            ['Ice Cream Pint','Creamy dessert available in many flavors.',224.00,'7','2'],
            ['Frozen Vegetables','Convenient and healthy, great as sides.',112.00,'7','3'],
            ['Frozen French Fries','Crispy and tasty, ideal with burgers.',140.00,'7','3'],
            ['Frozen Burritos (4-pack)','Quick and satisfying frozen meal.',224.00,'7','5'],
            ['Coffee','Roasted beans for a perfect 6 at home.',280.00,'8','3'],
            ['Green Tea (20 bags)','Light and healthy, packed with antioxidants.',168.00,'8','4'],
            ['Bottled Water 500ml','Essential hydration, portable.',55.00,'8','2'],
            ['Orange Juice','Fresh and tangy, rich in Vitamin C.',196.00,'8','2'],
            ['Soda Can','Fizzy and refreshing drink.',84.00,'8','2'],
            ['Ketchup','Classic condiment for burgers and fries.',112.00,'9','3'],
            ['Mayonnaise','Creamy and rich, perfect for spreads.',168.00,'9','3'],
            ['Soy Sauce','Savory flavor enhancer for dishes.',140.00,'9','2'],
            ['Hot Sauce','Spicy kick for meals and snacks.',112.00,'9','2'],
            ['Olive Oil','Ideal for cooking and dressing.',280.00,'9','2'],
            ['Salt','Basic seasoning to enhance flavor.',56.00,'10','3'],
            ['Black Pepper','Adds bold flavor to any dish.',140.00,'10','3'],
            ['Garlic Powder','Easy way to add garlic flavor.',112.00,'10','3'],
            ['Oregano','Herb for Italian-style dishes.',112.00,'10','3'],
            ['Cinnamon','Warm and sweet, ideal for baking.',140.00,'10','3'],
        ];

        foreach ($products as [$name, $description, $price, $categoryId, $unitId]) {
            $category = Category::firstOrCreate(['id' => $categoryId]);
            $unit = Unit::firstOrCreate(['id' => $unitId]);
            $supplier = Supplier::inRandomOrder()->first();

            $product = Product::create([
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'category_id' => $category->id,
                'unit_id' => $unit->id,
            ]);
            $supplierPrice = $price - ($price *0.10);
            $product->suppliers()->attach($supplier->id, [
                'price' => $supplierPrice,
                'quantity' => rand(10, 50),
            ]);
        }
    }
}

