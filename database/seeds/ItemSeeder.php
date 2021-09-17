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
        factory(\App\Models\Item::class)->create([
            'price' => $widgetsPrice->random(),
            'location_id' => 1,
            'category_id' => 3,
        ]);

        // Location 1, Chevrolet
        factory(\App\Models\Item::class)->create([
            'name' => 'Impala',
            'price' => 31620,
            'location_id' => 1,
            'category_id' => 4,
            'parent_category_id' => 1,
        ]);
        factory(\App\Models\Item::class)->create([
            'name' => 'Silverado 4500',
            'price' => 47627,
            'location_id' => 1,
            'category_id' => 4,
            'parent_category_id' => 1,
        ]);

        // Nissan
        factory(\App\Models\Item::class)->create([
            'name' => 'Versa',
            'price' => 14980,
            'location_id' => 1,
            'category_id' => 5,
            'parent_category_id' => 1,
        ]);
        factory(\App\Models\Item::class)->create([
            'name' => 'Maxima',
            'price' => 37090,
            'location_id' => 1,
            'category_id' => 5,
            'parent_category_id' => 1,
        ]);
        factory(\App\Models\Item::class)->create([
            'name' => 'Rogue Sport',
            'price' => 24160,
            'location_id' => 1,
            'category_id' => 5,
            'parent_category_id' => 1,
        ]);

        // Location 1, widgets
        factory(\App\Models\Item::class)->create([
            'price' => $widgetsPrice->random(),
            'location_id' => 2,
            'category_id' => 3,
        ]);

        // Location 2, Chevrolet
        factory(\App\Models\Item::class)->create([
            'name' => 'Sonic',
            'price' => 16720,
            'location_id' => 2,
            'category_id' => 4,
            'parent_category_id' => 1,
        ]);

        // Nissan
        factory(\App\Models\Item::class)->create([
            'name' => 'Murano',
            'price' => 32820,
            'location_id' => 2,
            'category_id' => 5,
            'parent_category_id' => 1,
        ]);
        factory(\App\Models\Item::class)->create([
            'name' => 'Armada',
            'price' => 48900,
            'location_id' => 2,
            'category_id' => 5,
            'parent_category_id' => 1,
        ]);

        // Purses
        factory(\App\Models\Item::class)->create([
            'name' => 'Auth Louis Vuitton Monogram',
            'price' => 4500,
            'location_id' => 2,
            'category_id' => 6,
            'parent_category_id' => 2,
        ]);
    }
}
