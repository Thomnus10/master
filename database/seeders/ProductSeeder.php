<?php
namespace Database\Seeders; 
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            // Bread and Bakery (category_id = 4)
            ['Whole Wheat Bread', 'Nutritious and hearty, perfect for sandwiches.', 140, 4, 4],
            ['Croissants', 'Flaky and buttery, perfect for breakfast or snacking.', 84, 4, 4],
            ['Bagels (6-pack)', 'Soft and chewy, ideal for breakfast with cream cheese.', 168, 4, 9],
            ['Muffins (4-pack)', 'Sweet and fluffy, a perfect morning treat.', 224, 4, 9],
            ['Pizza Dough', 'Ready-to-use dough for homemade pizza nights.', 168, 4, 4],

            // Canned and Jarred Goods (category_id = 2)
            ['Canned Tomatoes', 'Perfect for sauces, soups, or stews.', 84, 5, 3],
            ['Canned Beans', 'Protein-rich, ideal for salads or stews.', 56, 5, 3],
            ['Peanut Butter', 'Creamy or crunchy, great for sandwiches or snacks.', 168, 5, 3],
            ['Jam', 'Sweet and fruity, perfect for spreading on toast.', 196, 5, 3],
            ['Canned Tuna', 'Quick and easy protein for salads or sandwiches.', 56, 5, 3],

            // Snacks and Chips (category_id = 3)
            ['Potato Chips', 'Crispy and salty, perfect for snacking.', 140, 6, 3],
            ['Pretzels', 'Salty and crunchy snack for any time.', 168, 6, 3],
            ['Granola Bars (Box of 6)', 'Healthy and filling for on-the-go energy.', 196, 6, 9],
            ['Popcorn', 'Light and airy, great for movie nights.', 84, 6, 3],
            ['Tortilla Chips', 'Crunchy and ideal for dips.', 168, 6, 3],

            // Frozen Foods (category_id = 4)
            ['Frozen Pizza', 'Quick and easy meal with various toppings.', 336, 7, 4],
            ['Ice Cream Pint', 'Creamy dessert available in many flavors.', 224, 7, 2],
            ['Frozen Vegetables', 'Convenient and healthy, great as sides.', 112, 7, 3],
            ['Frozen French Fries', 'Crispy and tasty, ideal with burgers.', 140, 7, 3],
            ['Frozen Burritos (4-pack)', 'Quick and satisfying frozen meal.', 224, 7, 9],

            // Beverages (category_id = 5)
            ['Coffee', 'Roasted beans for a perfect cup at home.', 280, 8, 3],
            ['Green Tea (20 bags)', 'Light and healthy, packed with antioxidants.', 168, 8, 4],
            ['Bottled Water 500ml', 'Essential hydration, portable.', 55, 8, 2],
            ['Orange Juice', 'Fresh and tangy, rich in Vitamin C.', 196, 8, 2],
            ['Soda Can', 'Fizzy and refreshing drink.', 84, 8, 2],

            // Condiments and Sauces (category_id = 6)
            ['Ketchup', 'Classic condiment for burgers and fries.', 112, 9, 3],
            ['Mayonnaise', 'Creamy and rich, perfect for spreads.', 168, 9, 3],
            ['Soy Sauce', 'Savory flavor enhancer for dishes.', 140, 9, 2],
            ['Hot Sauce', 'Spicy kick for meals and snacks.', 112, 9, 2],
            ['Olive Oil', 'Ideal for cooking and dressing.', 280, 9, 2],

            // Spices and Seasonings (category_id = 7)
            ['Salt', 'Basic seasoning to enhance flavor.', 56, 10, 3],
            ['Black Pepper', 'Adds bold flavor to any dish.', 140, 10, 3],
            ['Garlic Powder', 'Easy way to add garlic flavor.', 112, 10, 3],
            ['Oregano', 'Herb for Italian-style dishes.', 112, 10, 3],
            ['Cinnamon', 'Warm and sweet, ideal for baking.', 140, 10, 3],
        ];

        foreach ($products as $product) {
            Product::create([
                'name' => $product[0],
                'description' => $product[1],
                'price' => $product[2],
                'category_id' => $product[3],
                'unit_id' => $product[4],
            ]);
        }
    }
}
