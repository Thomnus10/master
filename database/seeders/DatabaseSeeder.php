<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed roles
        DB::table('roles')->insert([
            ['id' => 1, 'role_name' => 'admin'],
            ['id' => 2, 'role_name' => 'cashier'],
        ]);

        // Seed positions
        DB::table('positions')->insert([
            ['id' => 1, 'position_name' => 'manager'],
            ['id' => 2, 'position_name' => 'cashier'],
            ['id' => 3, 'position_name' => 'loader'],
        ]);

        // Create admin user (linked to John Doe)
        $adminUser = User::create([
            
            'username' => 'admin',
            'password' => Hash::make('admin'),
            'email' => 'admin@email.com',
            'role_id' => 1, // Admin role
        ]);

        // Create cashier user (linked to Jane Smith)
        $cashierUser = User::create([
            
            'username' => 'cashier',
            'password' => Hash::make('cashier'),
            'email' => 'cashier@email.com',
            'role_id' => 2, // Cashier role
        ]);

        // Seed employees, linking them to the correct users
        DB::table('employees')->insert([
            [
                'Fname' => 'Owin',
                'Mname' => 'A',
                'Lname' => 'Albacite',
                'position_id' => 1, // Manager
                'user_id' => $adminUser->id, // Linked to admin user
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Fname' => 'Darren',
                'Mname' => 'B',
                'Lname' => 'Nenel',
                'position_id' => 2, // Cashier
                'user_id' => $cashierUser->id, // Linked to cashier user
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
        $this->call([
            CategorySeeder::class,
            UnitSeeder::class,
            ProductSeeder::class,
            InventorySeeder::class,
        ]);
    }
}
