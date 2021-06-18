<?php

namespace Tests\Feature;

use Spatie\Tags\Tag;
use Tests\CreatesUser;
use Tests\TestCase;

class ManageTagTest extends TestCase
{
    use CreatesUser;
    
    public function read_tag($user)
    {
        return $this->actingAs($user)->get(route('tag.index'));
    }
    public function test_can_read_tag_as_user()
    {
        $this->read_tag($this->user)->assertStatus(200);
    }
    public function test_can_read_tag_as_admin()
    {
        $this->read_tag($this->admin)->assertStatus(200);
    }
    public function test_can_read_tag_as_super_admin()
    {
        $this->read_tag($this->super_admin)->assertStatus(200);
    }
    
    public function create_tag($user)
    {
        return $this->actingAs($user)->post(route('tag.store'), [
            'name' => 'English-course',
            ]);
    }

    public function test_can_not_create_tag_as_user()
    {
        $this->create_tag($this->user)->assertStatus(403);
    }

    public function test_can_create_tag_as_admin()
    {
        $this->create_tag($this->admin)->assertStatus(302);
    }
    
    public function test_can_create_tag_as_super_admin()
    {
        $this->create_tag($this->super_admin)->assertStatus(302);
    }

    public function update_tag($user)
    {
        $tag = Tag::create(['name'=>'tag']);
        return $this->actingAs($user)->put(route('tag.update',$tag->id), [
            'name' => 'English Course',
            ]);
    }

    public function test_can_update_tag_as_admin()
    {
        $this->update_tag($this->admin)->assertStatus(302);
    }

    public function test_can_not_update_tag_because_not_as_a()
    {
        $this->update_tag($this->user)->assertStatus(403);
    }

    public function delete_tag($user) 
    {
        $tag = Tag::create(['name'=>'tag']);
        return $this->actingAs($user)->delete(route('tag.destroy',$tag->id));
    }

    public function test_can_delete_tag_as_the_owner()
    {
        $this->delete_tag($this->admin)->assertStatus(302);
    }
    
    public function test_can_not_delete_tag_because_not_as_the_owner()
    {
        $this->delete_tag($this->user)->assertStatus(403);
    }
}
