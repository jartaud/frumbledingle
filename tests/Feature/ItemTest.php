<?php

namespace Tests\Feature;

use App\Models\Category;
use Tests\TestCase;
use App\Models\Item;
use App\Models\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemTest extends TestCase
{
    use RefreshDatabase;

    public function test_item_page_is_rendered()
    {
        $this->get('/items')
            ->assertSee('items-table');
    }

    public function test_correct_data_is_loaded()
    {
        $location = factory(Location::class)->create();
        $category = factory(Category::class)->create();
        factory(Item::class, 2)->create([
            'location_id' => $location->id,
            'category_id' => $category->id,
        ]);

        $this->get('/items')
            ->assertViewIs('items')
            ->assertViewHas(['locations', 'categories']);

        $this->json('GET', route('items.index'))
            ->assertJson([
                'total' => 2,
                'current_page' => 1,
                'per_page' => 10,
                'from' => 1,
                'to' => 2,
                'last_page' => 1
            ])
            ->assertJsonCount(2, 'data')
            ->assertStatus(200);
    }
    
    public function test_it_saves_a_new_item_into_db()
    {
        $location = factory(Location::class)->create();
        $category = factory(Category::class)->create();

        $this->json('POST', route('items.store'), [
            'name' => 'The New Item',
            'location_id' => $location->id,
            'category_id' => $category->id,
            'price' => 150.05
        ])
        ->assertStatus(201);

        $this->assertDatabaseHas('items', ['name' => 'The New Item']);
    }

    public function test_it_validates_name()
    {
        $location = factory(Location::class)->create();
        $category = factory(Category::class)->create();
        factory(Item::class, 2)->create([
            'location_id' => $location->id,
            'category_id' => $category->id,
            'name' => 'The New Item'
        ]);

        $this->json('POST', route('items.store'), [
            'name' => ''
        ])
        ->assertJsonValidationErrors('name');
        
        // min 3
        $this->json('POST', route('items.store'), [
            'name' => 'aa'
        ])
        ->assertJsonValidationErrors('name');
        
        // max 255
        $this->json('POST', route('items.store'), [
            'name' => str_repeat('Z', 256)
        ])
        ->assertJsonValidationErrors('name');

        $this->json('POST', route('items.store'), [
            'location_id' => $location->id,
            'category_id' => $category->id,
            'name' => 'The New Item'
        ])
        ->assertJsonValidationErrors('name');
    }

    public function test_it_validates_price()
    {
        $this->json('POST', route('items.store'), [
            'price' => ''
        ])
        ->assertJsonValidationErrors('price');
        
        // min 3
        $this->json('POST', route('items.store'), [
            'price' => 'xx'
        ])
        ->assertJsonValidationErrors('price');
    }

    public function test_it_validates_category_id()
    {
        $this->json('POST', route('items.store'), [
            'category_id' => ''
        ])
        ->assertJsonValidationErrors('category_id');
        
        // min 3
        $this->json('POST', route('items.store'), [
            'category_id' => 'xx'
        ])
        ->assertJsonValidationErrors('category_id');
    }

    public function test_it_validates_location_id()
    {
        $this->json('POST', route('items.store'), [
            'location_id' => ''
        ])
        ->assertJsonValidationErrors('location_id');
        
        // min 3
        $this->json('POST', route('items.store'), [
            'location_id' => 'xx'
        ])
        ->assertJsonValidationErrors('location_id');
    }

    public function test_it_deletes_an_item()
    {
        $item = factory(Item::class)->create([
            'location_id' => factory(Location::class)->create()->id,
            'category_id' => factory(Category::class)->create()->id,
            'name' => 'The New Item'
        ]);

        $this->json('POST', route('items.destroy', $item->id), [
            '_method' => 'DELETE'
        ])
        ->assertStatus(200);

        $this->assertNotNull($item->fresh()->deleted_at);
    }
}
