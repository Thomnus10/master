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
            ['FITA Crackers','lightly salted, round crackers',62.00,'Biscuits','pc/s'],
            ['Milk','Essential for cooking, baking, or drinking.',140.00,'Dairy and Eggs','pc/s'],
            ['Butter','Adds rich flavor to baking, cooking, and spreads.',196.00,'Dairy and Eggs','kg'],
            ['Cheddar Cheese','Sharp and creamy, perfect for sandwiches or snacking.',224.00,'Dairy and Eggs','kg'],
            ['Yogurt','Creamy and tangy, great for breakfast or a snack.',42.00,'Dairy and Eggs','pc/s'],
            ['Eggs','Versatile for cooking, baking, or scrambling.',112.00,'Dairy and Eggs','dozen'],
            ['Chicken Breasts','Lean and protein-packed, great for grilling or baking.',280.00,'Meat and Seafood','kg'],
            ['Ground Beef','Perfect for burgers, tacos, and meatballs.',252.00,'Meat and Seafood','kg'],
            ['Salmon Fillets','Rich in omega-3s, great for grilling or baking.',448.00,'Meat and Seafood','kg'],
            ['Shrimp','Sweet and tender, ideal for stir-fries, grilling, or shrimp cocktails.',336.00,'Meat and Seafood','kg'],
            ['Bacon','Crispy and flavorful, perfect for breakfast or adding to dishes.',308.00,'Meat and Seafood','kg'],
            ['Whole Wheat Bread','Nutritious and hearty, perfect for sandwiches.',140.00,'Bread and Bakery','pc/s'],
            ['Croissants','Flaky and buttery, perfect for breakfast or snacking.',84.00,'Bread and Bakery','pc/s'],
            ['Bagels (6-pack)','Soft and chewy, ideal for breakfast with cream cheese.',168.00,'Bread and Bakery','dozen'],
            ['Muffins (4-pack)','Sweet and fluffy, a perfect morning treat.',224.00,'Bread and Bakery','dozen'],
            ['Pizza Dough','Ready-to-use dough for homemade pizza nights.',168.00,'Bread and Bakery','pc/s'],
            ['Canned Tomatoes','Perfect for sauces, soups, or stews.',84.00,'Canned and Jarred Goods','pc/s'],
            ['Canned Beans','Protein-rich, ideal for salads or stews.',56.00,'Canned and Jarred Goods','pc/s'],
            ['Peanut Butter','Creamy or crunchy, great for sandwiches or snacks.',168.00,'Canned and Jarred Goods','pc/s'],
            ['Jam','Sweet and fruity, perfect for spreading on toast.',196.00,'Canned and Jarred Goods','pc/s'],
            ['Canned Tuna','Quick and easy protein for salads or sandwiches.',56.00,'Canned and Jarred Goods','pc/s'],
            ['Potato Chips','Crispy and salty, perfect for snacking.',140.00,'Snacks and Chips','pc/s'],
            ['Pretzels','Salty and crunchy snack for any time.',168.00,'Snacks and Chips','pc/s'],
            ['Granola Bars (Box of 6)','Healthy and filling for on-the-go energy.',196.00,'Snacks and Chips','pack'],
            ['Popcorn','Light and airy, great for movie nights.',84.00,'Snacks and Chips','g'],
            ['Tortilla Chips','Crunchy and ideal for dips.',168.00,'Snacks and Chips','g'],
            ['Frozen Pizza','Quick and easy meal with various toppings.',336.00,'Frozen Foods','pc/s'],
            ['Ice Cream Pint','Creamy dessert available in many flavors.',224.00,'Frozen Foods','liters'],
            ['Frozen Vegetables','Convenient and healthy, great as sides.',112.00,'Frozen Foods','g'],
            ['Frozen French Fries','Crispy and tasty, ideal with burgers.',140.00,'Frozen Foods','g'],
            ['Frozen Burritos (4-pack)','Quick and satisfying frozen meal.',224.00,'Frozen Foods','dozen'],
            ['Coffee','Roasted beans for a perfect cup at home.',280.00,'Beverages','g'],
            ['Green Tea (20 bags)','Light and healthy, packed with antioxidants.',168.00,'Beverages','pc/s'],
            ['Bottled Water 500ml','Essential hydration, portable.',55.00,'Beverages','liters'],
            ['Orange Juice','Fresh and tangy, rich in Vitamin C.',196.00,'Beverages','liters'],
            ['Soda Can','Fizzy and refreshing drink.',84.00,'Beverages','liters'],
            ['Ketchup','Classic condiment for burgers and fries.',112.00,'Condiments and Sauces','g'],
            ['Mayonnaise','Creamy and rich, perfect for spreads.',168.00,'Condiments and Sauces','g'],
            ['Soy Sauce','Savory flavor enhancer for dishes.',140.00,'Condiments and Sauces','liters'],
            ['Hot Sauce','Spicy kick for meals and snacks.',112.00,'Condiments and Sauces','liters'],
            ['Olive Oil','Ideal for cooking and dressing.',280.00,'Condiments and Sauces','liters'],
            ['Salt','Basic seasoning to enhance flavor.',56.00,'Spices and Seasonings','g'],
            ['Black Pepper','Adds bold flavor to any dish.',140.00,'Spices and Seasonings','g'],
            ['Garlic Powder','Easy way to add garlic flavor.',112.00,'Spices and Seasonings','g'],
            ['Oregano','Herb for Italian-style dishes.',112.00,'Spices and Seasonings','g'],
            ['Cinnamon','Warm and sweet, ideal for baking.',140.00,'Spices and Seasonings','g'],
        ];

        foreach ($products as [$name, $description, $price, $categoryName, $unitName]) {
            $category = Category::firstOrCreate(['name' => $categoryName]);
            $unit = Unit::firstOrCreate(['name' => $unitName]);
            $supplier = Supplier::inRandomOrder()->first();

            $product = Product::create([
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'category_id' => $category->id,
                'unit_id' => $unit->id,
            ]);

            $product->suppliers()->attach($supplier->id, [
                'price' => $price,
                'quantity' => rand(10, 50),
            ]);
        }
    }
}

