<?php

namespace Feature\Acceptance;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
     * @author Damien-Code
     * An acceptance test where the contact page displays the user's name if logged in.
     */
    public function  test_contact_view_displays_user_name_if_logged_in()
    {
        // Create a user
        $user = User::factory()->create();
        // Send a GET request to the contact route while logged in
        $response = $this->actingAs($user)->get('/contact');

        // Assert that the response is a success
        $response->assertStatus(200);
        // Assert that the view contains the user's name
        $response->assertSee($user->name);
    }
}
