<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_root_redirects_to_home_page(): void
    {
        $response = $this->get('/');

        $response->assertRedirect(route('home.page'));
    }

    public function test_admin_login_page_is_displayed(): void
    {
        $response = $this->get('/admin/login');

        $response->assertStatus(200);
    }

    public function test_health_endpoint_is_up(): void
    {
        $response = $this->get('/up');

        $response->assertStatus(200);
    }
}
