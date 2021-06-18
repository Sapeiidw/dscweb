<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    public function test_show_update_delete_profile()
    {
        $user = User::factory()->create(['id'=>1]);
        
        $this->actingAs($user)->get(route('profile.index'))->assertStatus(200);
        
        $this->actingAs($user)->put(route('profile.update', $user->id), [
            'name' => 'updated user',
        ])->assertStatus(302);

        $this->actingAs($user)->delete(route('profile.destroy', $user->id))->assertStatus(302);
        
    }

    public function test_change_password()
    {
        $user = User::factory()->create(['id'=>1]);
        $this->actingAs($user)->post(route('change_password'),[
            'old_password' => 'password',
            'password' => 'new_password',
        ])->assertStatus(302);
    }
}
