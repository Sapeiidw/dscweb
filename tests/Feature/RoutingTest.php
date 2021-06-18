<?php

namespace Tests\Feature;

use Tests\CreatesUser;
use Tests\TestCase;

class RoutingTest extends TestCase
{
    use CreatesUser;

    public function test_navigate_to_dashboard_with_authentication_and_has_permission()
    {
        $this->actingAs($this->user)->get("/dashboard")->assertStatus(200);
    }

    public function test_navigate_to_playlist_with_authentication_and_has_permission()
    {
        $this->actingAs($this->user)->get("/playlist")->assertStatus(200);
    }

    public function test_navigate_to_page_tag_with_authentication_and_has_permission()
    {
        $this->actingAs($this->user)->get("/tag")->assertStatus(200);
    }
    
    public function test_navigate_to_profile_page()
    {
        $this->actingAs($this->user)->get('/profile')->assertStatus(200);
    }
}
