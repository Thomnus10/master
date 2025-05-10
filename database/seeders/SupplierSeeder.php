<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    public function run()
    {
        $suppliers = [
            ['name' => 'Fresh Produce Inc.','contact' => '1234567890'],
            ['name' => 'Ocean Meats Co.','contact' => '2345678901'],
            ['name' => 'Daily Dairy Ltd.','contact' => '3456789012'],
        ];

        foreach ($suppliers as $data) {
            Supplier::create($data);
        }
    }
}

