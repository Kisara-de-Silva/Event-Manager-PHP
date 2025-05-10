<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_create_an_event()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->post('/events', [
            'title' => 'Test Event',
            'description' => 'Test description',
            'event_date' => now()->addDays(3)->format('Y-m-d'),
        ]);

        $response->assertRedirect('/events');
        $this->assertDatabaseHas('events', [
            'title' => 'Test Event',
            'user_id' => $user->id,
        ]);
    }
}
