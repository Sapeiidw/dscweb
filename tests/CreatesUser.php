<?php

namespace Tests;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;

trait CreatesUser
{
    protected $super_admin, $admin, $user;

    public function setUp(): void
    {
        parent::setUp();
        
        Role::firstOrCreate(['name'=>'super-admin']);
        Role::firstOrCreate(['name'=>'admin']);
        Role::firstOrCreate(['name'=>'user']);
        
        $this->super_admin = User::factory()->create(['id'=>1]);
        $this->super_admin->assignRole('super-admin');

        $this->admin = User::factory()->create(['id'=>2]);
        $this->admin->assignRole('admin');

        $this->user = User::factory()->create(['id'=>3]);
        $this->user->assignRole('user');
        
        $this->premium_user = User::factory()->create(['id'=>4]);
        $this->premium_user->assignRole('user');
        $this->actingAs($this->premium_user)
        ->post('subscribe', [
            'payment_method' => 'pm_card_visa',
            'plan' => 'price_1IkRFRLZUh8627nbly70s6t3',
        ]);

        $this->setupPermissions();
    }

    protected function setupPermissions()
    {
       
        $permission = [
            'user',
            'role',
            'permission',
            'playlist',
            'video',
            'tag',
        ];
        foreach ($permission as $key => $value) {
            Permission::firstOrCreate([
                    "name" => "create-".$value,
                    "guard_name" => 'web',
                ]);
            Permission::firstOrCreate([
                    "name" => "read-".$value,
                    "guard_name" => 'web',
                ]);
            Permission::firstOrCreate([
                    "name" => "update-".$value,
                    "guard_name" => 'web',
                ]);
            Permission::firstOrCreate([
                    "name" => "delete-".$value,
                    "guard_name" => 'web',
                ]);
        }   
        $this->super_admin
            ->syncPermissions([
                'create-user', 'read-user', 'update-user', 'delete-user',
                'create-role', 'read-role', 'update-role', 'delete-role',
                'create-permission', 'read-permission', 'update-permission', 'delete-permission',
                'create-playlist', 'read-playlist', 'update-playlist', 'delete-playlist',
                'create-video', 'read-video', 'update-video', 'delete-video',
                'create-tag', 'read-tag', 'update-tag', 'delete-tag',
            ]);

        $this->admin
            ->syncPermissions([
                'create-user', 'read-user', 'update-user', 'delete-user',
                'create-playlist', 'read-playlist', 'update-playlist', 'delete-playlist',
                'create-video', 'read-video', 'update-video', 'delete-video',
                'create-tag', 'read-tag', 'update-tag', 'delete-tag',
            ]);

        $this->user
            ->syncPermissions([
                'read-playlist',
                'read-video',
                'read-tag',
            ]);

        $this->premium_user
            ->syncPermissions([
                'read-playlist',
                'read-video',
                'read-tag',
            ]);

        $this->app->make(PermissionRegistrar::class)->registerPermissions();
    }
}
