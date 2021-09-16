<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomepageTest extends TestCase
{
    public function test_homepage_is_rendered()
    {
        $this->get('/')
            ->assertStatus(200)
            ->assertSee('Frumbledingle Corp')
            ->assertSee('Locations')
            ->assertSee('Items')
            ->assertSee('Categories')
            ->assertSee('Report')
            ->assertSee('The Final Battle')
            ;
    }
}
