<?php

namespace Tests\Feature\Integration;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @author Damien-Code
     * Test that a user can send a contact message and an admin can complete the message.
     * This integration test focuses on storing a contact message first
     * and lets an admin complete (update) the contact message.
     */
    public function test_user_can_send_contact_message_and_admin_can_complete_message(): void
    {
        // Create admin
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
        // Retrieve the first message
        $contact = Contact::first();
        // Format the current date and time, because it is stored in the controller like this
        $now = now()->format('Y-m-d H:i:s');
        // Send a PATCH request to the update route while acting as admin
        $this->actingAs($admin)->patch(route('admin.contact.update', $contact->id), ['completed_at' => $now]);
        // Assert that the message was updated
        $this->assertDatabaseHas('contacts', ['id' => $contact->id, 'completed_at' => $now]);
    }
}
