<?php

namespace Tests\Feature;

use Spatie\Permission\Models\Permission;
use Tests\TestCase;
use Tests\CreatesUser;

class ManagePermissionTest extends TestCase
{
    use CreatesUser;

    public function read_permission($user)
    {
        return $this->actingAs($user)->get(route('permission.index'));
    }
    public function test_can_not_read_permission_as_user()
    {
        $this->read_permission($this->user)->assertStatus(403);
    }
    public function test_can_read_permission_as_admin()
    {
        $this->read_permission($this->admin)->assertStatus(200);
    }
    public function test_can_read_permission_as_super_admin()
    {
        $this->read_permission($this->super_admin)->assertStatus(200);
    }
    
    public function create_permission($user)
    {
        return $this->actingAs($user)->post(route('permission.store'), [
            'name' => 'new-permission',
            ]);
    }

    public function test_can_not_create_permission_as_user()
    {
        $this->create_permission($this->user)->assertStatus(403);
    }

    public function test_can_not_create_permission_because_not_as_admin()
    {
        $this->create_permission($this->admin)->assertStatus(403);
    }
    
    public function test_can_create_permission_as_super_admin()
    {
        $this->create_permission($this->super_admin)->assertStatus(302);
    }

    public function update_permission($user)
    {
        $permission = Permission::create(['name'=>'permission']);
        return $this->actingAs($user)->put(route('permission.update',$permission->id), [
            'name' => 'new-permission',
            ]);
    }

    public function test_can_update_permission_as_super_admin()
    {
        $this->update_permission($this->super_admin)->assertStatus(302);
    }

    public function test_can_not_update_permission_because_not_as_a_super_admin()
    {
        $this->update_permission($this->admin)->assertStatus(403);
    }

    public function delete_permission($user) 
    {
        $permission = Permission::create(['name'=>'permission']);
        return $this->actingAs($user)->delete(route('permission.destroy',$permission->id));
    }

    public function test_can_delete_permission_as_super_admin()
    {
        $this->delete_permission($this->super_admin)->assertStatus(302);
    }
    
    public function test_can_not_delete_permission_because_not_as_super_admin()
    {
        $this->delete_permission($this->admin)->assertStatus(403);
    }
}
