<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Film;
use App\Models\User;
use App\Models\Critic;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FilmApiTest extends TestCase
{
    use RefreshDatabase; 

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(); 
    }

    public function it_can_list_all_films()
    {
        Film::factory(10)->create(); 
        $response = $this->getJson('/api/films');
        $response->assertStatus(200)
                 ->assertJsonCount(10, 'data'); 
    }
    public function it_can_get_film_with_critics()
    {
        $film = Film::factory()->create();
        Critic::factory(5)->create(['film_id' => $film->id]); 

        $response = $this->getJson("/api/films/{$film->id}/critics");
        $response->assertStatus(200)
                 ->assertJsonStructure(['id', 'title', 'critics']);
    }

    public function it_returns_404_for_non_existing_film()
    {
        $response = $this->getJson('/api/films/99999');
        $response->assertStatus(404);
    }

    public function it_can_create_a_new_user()
    {
        $data = [
            'login' => 'testuser',
            'password' => 'password123',
            'email' => 'test@example.com',
            'first_name' => 'Test',
            'last_name' => 'User',
        ];
        $response = $this->postJson('/api/users', $data);
        $response->assertStatus(201)
                 ->assertJson(['login' => 'testuser']);
    }

    public function it_can_update_a_user()
    {
        $user = User::factory()->create();
        $updateData = ['email' => 'updated@example.com'];

        $response = $this->putJson("/api/users/{$user->id}", $updateData);
        $response->assertStatus(200)
                 ->assertJson(['email' => 'updated@example.com']);
    }

    public function it_can_delete_a_critic()
    {
        $critic = Critic::factory()->create();
        $response = $this->deleteJson("/api/critics/{$critic->id}");
        $response->assertStatus(204);
    }
}

