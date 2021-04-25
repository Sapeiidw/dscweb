<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
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
            Permission::insert([
                [
                    "name" => "create-".$value,
                    "guard_name" => 'web',
                ],
                [
                    "name" => "read-".$value,
                    "guard_name" => 'web',
                ],
                [
                    "name" => "update-".$value,
                    "guard_name" => 'web',
                ],
                [
                    "name" => "delete-".$value,
                    "guard_name" => 'web',
                ],
            ]);
        }    
        Permission::insert([
            [
                'name' => 'watch-premium',
                "guard_name" => 'web',
            ],
        ]);
    }
}
