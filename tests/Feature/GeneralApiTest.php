<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GeneralApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_invalid_route_returns_404()
    {
        $response = $this->getJson('/api/nonexistent-endpoint');
        $response->assertNotFound();
    }
}
