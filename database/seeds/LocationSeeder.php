<?php

use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Location::class)->create(['name' => 'Frumbledingle Corp']);
        factory(\App\Models\Location::class)->create(['name' => 'Plupbuckle, Inc.']);
    }
}
