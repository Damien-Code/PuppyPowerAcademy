<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @author Damien-Code
     * A basic test where the contact page can be rendered without login.
     */
    public function test_contactPageCanBeRenderedWithoutLogin(): void
    {
        $response = $this->get('/contact');

        $response->assertStatus(200);
    }

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
            'is_completed' => false,
        ];
        // Send a POST request to the store route
        $response = $this->post('/contact', $data);
        // Assert that the response is a redirect
        $response->assertStatus(302);
        $this->assertDatabasehas('contacts', $data);

    }
}
