<?php

namespace Tests\Feature;

use App\Models\Playlist;
use App\Models\Video;
use Tests\CreatesUser;
use Tests\TestCase;

class ManageVideoTest extends TestCase
{
    use CreatesUser;

    public function read_all_video($user)
    {
        return $this->actingAs($user)->get(route('video.index'));
    }
    public function test_can_not_read_all_video_as_user()
    {
        $this->read_all_video($this->user)->assertStatus(403);
    }
    public function test_can_read_all_video_as_admin()
    {
        $this->read_all_video($this->super_admin)->assertStatus(200);
    }
    public function test_can_read_all_video_as_super_admin()
    {
        $this->read_all_video($this->super_admin)->assertStatus(200);
    }

    public function show_video_inside_playlist($user,$status)
    {
        $playlist = Playlist::factory()->create(['id'=>1]);
        $video = Video::factory()->create([
            'id'=>1,
            'available_for' => $status,
        ]);
        $video->playlists()->sync(1);
        return $this->actingAs($user)->get(route('playlist.video',[$playlist->slug,$video->episode]));
    }

    public function test_can_show_free_video_inside_playlist_as_free_user()
    {
        $this->show_video_inside_playlist($this->user,"free")->assertDontSee("Butuh premium");
    }

    public function test_can_not_show_premium_video_inside_playlist_because_not_premium_user()
    {
        $this->show_video_inside_playlist($this->user,"premium")->assertSee("Butuh premium");
    }

    public function test_can_show_premium_video_inside_playlist_as_premium_user   ()
    {
        $this->show_video_inside_playlist($this->premium_user,"premium")
        ->assertSessionDoesntHaveErrors()
        ->assertDontSee("Butuh premium");
    }
    // Create
    public function create_video($user)
    {
        $playlist = Playlist::factory()->create();
        return $this->actingAs($user)->post(route('video.store'), [
            'id' => 1,
            'name' => 'Intro',
            'slug' => 'intro',
            'code' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/3VTkBuxU4yk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
            'duration' => '5:00',
            'episode' => 0,
            'available_for' => 'free',
            'playlists' => $playlist->id,
            ]);        
    }

    public function test_can_not_create_video_as_user()
    {
        $this->create_video($this->user)->assertStatus(403);
    }

    public function test_can_create_video_as_admin()
    {
        $this->create_video($this->admin)->assertStatus(302);
    }
    
    public function test_can_create_video_as_super_admin()
    {
        $this->create_video($this->super_admin)->assertStatus(302);
    }

    public function update_video($user)
    {
        $video = Video::factory()->create(['id'=>1]);
        return $this->actingAs($user)->put(route('video.update',$video->id), [
            'name' => 'Intro',
            'slug' => 'intro',
            'code' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/3VTkBuxU4yk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
            'duration' => '5:00',
            'episode' => 0,
            'available_for' => 'free',
            ]);
    }

    public function test_can_update_video_as_the_owner()
    {
        $this->update_video($this->admin)->assertStatus(302);
    }

    public function test_can_not_update_video_because_not_as_the_owner()
    {
        $this->update_video($this->user)->assertStatus(403);
    }

    public function delete_video($user) 
    {
        $video = Video::factory()->create();
        return $this->actingAs($user)->delete(route('video.destroy',$video->id));
    }

    public function test_delete_video_as_the_owner()
    {
        $this->delete_video($this->admin)->assertStatus(302);
    }
    
    public function test_delete_video_not_as_the_owner()
    {
        $this->delete_video($this->user)->assertStatus(403);
    }
}
