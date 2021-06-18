<?php

namespace Tests\Feature;

use App\Models\Playlist;
use Tests\CreatesUser;
use Tests\TestCase;

class ManagePlaylistTest extends TestCase
{
    use CreatesUser;
    
    public function read_playlist($user)
    {
        return $this->actingAs($user)->get(route('playlist.index'));
    }
    public function test_can_read_playlist_as_user()
    {
        $this->read_playlist($this->user)->assertStatus(200);
    }
    public function test_can_read_playlist_as_admin()
    {
        $this->read_playlist($this->admin)->assertStatus(200);
    }
    public function test_can_read_playlist_as_super_admin()
    {
        $this->read_playlist($this->super_admin)->assertStatus(200);
    }
    
    public function create_playlist($user)
    {
        return $this->actingAs($user)->post(route('playlist.store'), [
            'name' => 'English-course',
            'slug' => 'english-course',
            'description' => 'My Lovely English Course',
            'tags' => ['english'],
            'user_id' => $this->user->id,
            'thumbnail' => "",
            ]);
    }

    public function test_can_not_create_playlist_as_user()
    {
        $this->create_playlist($this->user)->assertStatus(403);
    }

    public function test_can_create_playlist_as_admin()
    {
        $this->create_playlist($this->admin)->assertStatus(302);
    }
    
    public function test_can_create_playlist_as_super_admin()
    {
        $this->create_playlist($this->super_admin)->assertStatus(302);
    }

    public function update_playlist($user)
    {
        $playlist = Playlist::factory()->create();
        return $this->actingAs($user)->put(route('playlist.update',$playlist->slug), [
            'name' => 'English Course',
            'slug' => 'english-course',
            'description' => 'My Lovely English Course',
            'tags' => ['english'],
            'thumbnail' => '',
            ]);
    }

    public function test_can_update_playlist_as_the_owner()
    {
        $this->update_playlist($this->admin)->assertStatus(302);
    }

    public function test_can_not_update_playlist_because_not_as_the_owner()
    {
        $this->update_playlist($this->user)->assertStatus(403);
    }

    public function delete_playlist($user) 
    {
        $playlist = Playlist::factory()->create(['user_id'=>2]);
        return $this->actingAs($user)->delete(route('playlist.destroy',$playlist->slug));
    }

    public function test_can_delete_playlist_as_the_owner()
    {
        $this->delete_playlist($this->admin)->assertStatus(302);
    }
    
    public function test_can_not_delete_playlist_because_not_as_the_owner()
    {
        $this->delete_playlist($this->user)->assertStatus(403);
    }
}
