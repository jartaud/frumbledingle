<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LocationTest extends TestCase
{
    use RefreshDatabase;

    public function test_location_page_is_rendered()
    {
        $this->get('/locations')
            ->assertSee('locations-table');
    }

    public function test_correct_data_is_loaded()
    {
        factory(Location::class, 2)->create();

        $this->json('GET', route('locations.index'))
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
    
    public function test_it_saves_a_new_location_into_db()
    {
        $this->json('POST', route('locations.store'), [
            'name' => 'The New Location'
        ])
        ->assertStatus(201);

        $this->assertDatabaseHas('locations', ['name' => 'The New Location']);
    }

    public function test_it_validates_the_payload()
    {
        $this->json('POST', route('locations.store'), [
            'name' => ''
        ])
        ->assertJsonValidationErrors('name');
        
        // min 3
        $this->json('POST', route('locations.store'), [
            'name' => 'aa'
        ])
        ->assertJsonValidationErrors('name');
        
        // max 255
        $this->json('POST', route('locations.store'), [
            'name' => str_repeat('Z', 256)
        ])
        ->assertJsonValidationErrors('name');

        factory(Location::class)->create(['name' => 'The Location']);
        $this->json('POST', route('locations.store'), [
            'name' => 'The Location'
        ])
        ->assertJsonValidationErrors('name');
    }

    public function test_it_deletes_a_location()
    {
        $location = factory(Location::class)->create(['name' => 'The Location']);

        $this->json('POST', route('locations.destroy', $location->id), [
            '_method' => 'DELETE'
        ])
        ->assertStatus(200);

        $this->assertSoftDeleted('locations', $location->fresh()->toArray());
    }
}
