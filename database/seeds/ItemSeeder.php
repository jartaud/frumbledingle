<?php

use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $widgetsPrice = collect([100.00, 45, 20, 60]);
        $carsPrice = collect([25000.00, 30000, 200000, 15000]);
        $pursesPrice = collect([300.00, 500, 150, 350, 1000]);
        // Location 1, widgets
        factory(\App\Models\Item::class, 3)->create([
            'price' => $widgetsPrice->random(),
            'location_id' => 1,
            'category_id' => 1,
        ]);

        // Location 2, widgets
        factory(\App\Models\Item::class, 3)->create([
            'price' => $widgetsPrice->shuffle()->random(),
            'location_id' => 2,
            'category_id' => 1,
        ]);

        // Location 1, cars
        factory(\App\Models\Item::class, 3)->create([
            'price' => $carsPrice->shuffle()->random(),
            'location_id' => 1,
            'category_id' => 2,
        ]);

        // Location 2, cars
        factory(\App\Models\Item::class, 3)->create([
            'price' => $carsPrice->random(),
            'location_id' => 2,
            'category_id' => 2,
        ]);

        // Location 1, purses
        factory(\App\Models\Item::class, 3)->create([
            'price' => $pursesPrice->random(),
            'location_id' => 1,
            'category_id' => 3,
        ]);

        // Location 2, purses
        factory(\App\Models\Item::class, 3)->create([
            'price' => $pursesPrice->shuffle()->random(),
            'location_id' => 2,
            'category_id' => 3,
        ]);
    }
}
