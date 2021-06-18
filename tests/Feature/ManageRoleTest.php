<?php

namespace Tests\Feature;

use Spatie\Permission\Models\Role;
use Tests\CreatesUser;
use Tests\TestCase;

class ManageRoleTest extends TestCase
{
    use CreatesUser;

    public function read_role($user)
    {
        return $this->actingAs($user)->get(route('role.index'));
    }
    public function test_can_not_read_role_as_user()
    {
        $this->read_role($this->user)->assertStatus(403);
    }
    public function test_can_read_role_as_admin()
    {
        $this->read_role($this->admin)->assertStatus(200);
    }
    public function test_can_read_role_as_super_admin()
    {
        $this->read_role($this->super_admin)->assertStatus(200);
    }
    
    public function create_role($user)
    {
        return $this->actingAs($user)->post(route('role.store'), [
            'name' => 'new-role',
            ]);
    }

    public function test_can_not_create_role_as_user()
    {
        $this->create_role($this->user)->assertStatus(403);
    }

    public function test_can_not_create_role_because_not_as_admin()
    {
        $this->create_role($this->admin)->assertStatus(403);
    }
    
    public function test_can_create_role_as_super_admin()
    {
        $this->create_role($this->super_admin)->assertStatus(302);
    }

    public function update_role($user)
    {
        $role = Role::create(['name'=>'role']);
        return $this->actingAs($user)->put(route('role.update',$role->id), [
            'name' => 'new-role',
            ]);
    }

    public function test_can_update_role_as_super_admin()
    {
        $this->update_role($this->super_admin)->assertStatus(302);
    }

    public function test_can_not_update_role_because_not_as_a_super_admin()
    {
        $this->update_role($this->admin)->assertStatus(403);
    }

    public function delete_role($user) 
    {
        $role = Role::create(['name'=>'role']);
        return $this->actingAs($user)->delete(route('role.destroy',$role->id));
    }

    public function test_can_delete_role_as_super_admin()
    {
        $this->delete_role($this->super_admin)->assertStatus(302);
    }
    
    public function test_can_not_delete_role_because_not_as_super_admin()
    {
        $this->delete_role($this->admin)->assertStatus(403);
    }
}
