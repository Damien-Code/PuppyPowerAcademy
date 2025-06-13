<?php

namespace Tests\Feature\Integration;

use App\Models\Daycare;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DaycareTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @author MischaSasse
     * 
     * Checks if a user can request a daycare date for their dog, 
     * after which it checks if an admin can change the daycare date 
     */
    public function test_user_can_request_daycare_and_admin_can_change_date(): void
    {
        $admin = User::factory()->create(['role_id' => 1]);
        $now = Carbon::today()->toDateTimeString();
        
        $data = [
            'id' => 1,
            'name'=> 'dog',
            'race'=> 'golden retriever',
            'age' =>'5',
            'been_to_daycare'=>false,
            'date'=> $now,
            'oldDate' => $now
        ];
        $this->actingAs($admin)->post('/dagopvang', $data);
        $daycare = Daycare::first();
        //check if in database
        $this->assertDatabaseHas('daycares', ['id' => $daycare->id, 'date' => $daycare->date]);

        $tomorrow = Carbon::today()->addDay()->format('Y-m-d H:i:s');
        $data['date'] = $tomorrow;
        $this->actingAs($admin)->post('/settings/admin/dagopvang', $data);
        $this->assertDatabaseHas('daycare_dogs', ['daycare_id' => 2]);
    }
}
