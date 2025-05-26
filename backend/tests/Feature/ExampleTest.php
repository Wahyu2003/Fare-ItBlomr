<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_application_returns_a_successful_response()
    {
        $user = User::factory()->admin()->create();
        $this->actingAs($user);
    
        $response = $this->get('/');
        $response->assertRedirect('/dashboard');
    
        $response = $this->get('/dashboard');
        $response->assertStatus(200);
    }


    public function test_unauthenticated_redirect()
    {
        // Test redirect untuk unauthenticated user
        $response = $this->get('/');
        $response->assertStatus(302)
                 ->assertRedirect('/login');
    }
}
