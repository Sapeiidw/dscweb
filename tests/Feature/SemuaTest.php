<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class SemuaTest extends TestCase
{

    use RefreshDatabase;

    protected $super_admin, $admin, $user;

    public function setUp(): void
    {
        parent::setUp();
        
        Role::create(['name'=>'super-admin']);
        Role::create(['name'=>'admin']);
        Role::create(['name'=>'user']);
        
        $this->member = User::factory()->create();

        $this->super_admin = User::factory()->create();
        $this->super_admin->assignRole('super-admin');

        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');

        $this->user = User::factory()->create();
        $this->user->assignRole('user');
        
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
            Permission::Create([
                    "name" => "create-".$value,
                    "guard_name" => 'web',
                ]);
            Permission::Create([
                    "name" => "read-".$value,
                    "guard_name" => 'web',
                ]);
            Permission::Create([
                    "name" => "update-".$value,
                    "guard_name" => 'web',
                ]);
            Permission::Create([
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

        $this->app->make(PermissionRegistrar::class)->registerPermissions();
    }

    public function test_user_can_not_render_page_dashboard_without_authentication()
    {
        $this->get("/dashboard")->assertStatus(302);
    }

    public function test_user_can_not_render_page_playlist_without_authentication()
    {
        $this->get("/playlist")->assertStatus(302);
    }

    public function test_user_can_not_render_page_tag_without_authentication()
    {
        $this->get("/tag")->assertStatus(302);
    }

    public function test_user_can_not_render_page_video_without_authentication()
    {
        $this->get("/video")->assertStatus(302);
    }

    public function test_user_can_render_page_dashboard_with_authentication()
    {
        $this->actingAs($this->user)->get("/dashboard")->assertStatus(200);
    }

    public function test_user_can_render_page_playlist_with_authentication()
    {
        $this->actingAs($this->user)->get("/playlist")->assertStatus(200);
    }

    public function test_user_can_render_page_tag_with_authentication()
    {
        $this->actingAs($this->user)->get("/tag")->assertStatus(200);
    }

    public function test_user_can_render_page_video_with_authentication()
    {
        $this->actingAs($this->user)->get("/video")->assertStatus(200);
    }
    public function test_check_if_user_user_has_permission_to_create_playlist()
    {
        $this->assertTrue($this->super_admin->hasPermissionTo("create-playlist"));
    }
    public function test_user_can_create_playlist_if_user_user_has_permission()
    {
        $this->actingAs($this->super_admin)->post(route('playlist.store'), [
            'name' => 'English Course',
            'slug' => 'english-course',
            'description' => 'My Lovely English Course',
            'tags' => ['english'],
            'user_id' => $this->super_admin->id,
            'thumbnail' => '',
            ])->assertStatus(302);
    }

}
