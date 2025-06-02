<?php

namespace Feature\Integration;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_send_contact_message_and_admin_can_complete_message(): void
    {
        $admin = User::factory()->create(['role_id' => 1]);

        // Data to be sent to the store method
        $data = [
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'message' => 'Test Message',
            'completed_at' => null,
        ];
        // Send a POST request to the store route
        $this->post('/contact', $data);
        $contact = Contact::first();

        $now = now()->format('Y-m-d H:i:s');
        $this->actingAs($admin)->patch(route('admin.contact.update', $contact->id), ['completed_at' => $now]);
        $this->assertDatabaseHas('contacts', ['id' => $contact->id, 'completed_at' => $now]);
    }
}
