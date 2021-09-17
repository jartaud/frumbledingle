<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Parents
        Category::insert([
            ['name' => 'Cars', 'created_at' => 'NOW()', 'updated_at' => 'NOW()'],
            ['name' => 'Purses', 'created_at' => 'NOW()', 'updated_at' => 'NOW()'],
        ]);

        Category::insert([
            [
                'name' => 'Widgets',
                'created_at' => 'NOW()',
                'updated_at' => 'NOW()',
                'parent_id' => null,
            ],
            [
                'name' => 'Chevrolet',
                'created_at' => 'NOW()',
                'updated_at' => 'NOW()',
                'parent_id' => 1,
            ],
            [
                'name' => 'Nissan',
                'created_at' => 'NOW()',
                'updated_at' => 'NOW()',
                'parent_id' => 1,
            ],
            [
                'name' => 'Louis Vuitton',
                'created_at' => 'NOW()',
                'updated_at' => 'NOW()',
                'parent_id' => 2,
            ],
        ]);
    }
}
