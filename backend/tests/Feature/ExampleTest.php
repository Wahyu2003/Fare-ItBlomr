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
        // 1. Buat user testing
        $user = User::factory()->create();
        
        // 2. Authentikasi user
        $this->actingAs($user);
        
        // 3. Test akses ke home
        $response = $this->get('/');
        
        // 4. Verifikasi
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
