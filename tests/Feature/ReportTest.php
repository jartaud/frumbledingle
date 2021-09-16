<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_report_page_is_rendered()
    {
        $this->get('/report')
            ->assertSee('report-table');
    }

    public function test_correct_data_is_loaded()
    {
        $this->get('/report')
            ->assertViewIs('report');

        $this->json('GET', route('report.index'))
            ->assertStatus(200);
    }
}
