<?php

// Database/Seeders/UnitSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Unit;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $units = ['kg', 'liters', 'g', 'pc/s','dozen','cup','gallon','sack','pack'];

        foreach ($units as $unit) {
            Unit::create(['type' => $unit]);
        }
    }
}
