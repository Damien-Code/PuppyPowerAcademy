<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @author  Damien-Code
     * Test that a user can send a contact message.
     */
    public function test_user_can_send_contact_message(): void
    {
        // Data to be sent to the store method
        $data = [
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'message' => 'Test Message',
            'completed_at' => null,
        ];
        // Send a POST request to the store route
        $response = $this->post('/contact', $data);
        // Assert that the response is a redirect
        $response->assertStatus(302);
        $this->assertDatabasehas('contacts', $data);
    }
}
