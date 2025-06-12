<?php

namespace Tests\Feature\Acceptance;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class AdminDaycareTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * @author MischaSasse
     * 
     * a test to check if an admin can render settings/admin/dagopvang
     */
    public function test_admin_daycare_page_can_be_rendered_as_admin(): void
    {
        $admin = User::factory()->create(['role_id' => 1]);
        $response = $this->actingAs($admin)->get('/settings/admin/dagopvang');

        $response->assertStatus(200);
    }

   
    /**
     * @author MischaSasse
     * 
     * a test to check if a non-admin cannot render settings/admin/dagopvang
     */
    public function  test_admin_daycare_page_cannot_be_rendered_as_user_who_isnt_admin()
    {
        $user = User::factory()->create(['role_id' => 2]);
        $response = $this->actingAs($user)->get('/settings/admin/dagopvang');

        $response->assertStatus(403);
    }
}
