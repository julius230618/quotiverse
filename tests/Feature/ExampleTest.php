<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_forwarded_https_is_used_for_generated_asset_urls(): void
    {
        Route::get('/_test/proxy-scheme', fn () => asset('css/quotiverse.css'));

        $this->withServerVariables(['REMOTE_ADDR' => '127.0.0.1'])
            ->withHeader('X-Forwarded-Proto', 'https')
            ->get('/_test/proxy-scheme')
            ->assertOk()
            ->assertSee('https://localhost/css/quotiverse.css');
    }
}
