<?php

namespace Database\Seeders;

use App\Models\Playlist;
use Illuminate\Database\Seeder;

class PlaylistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Playlist = Playlist::insert([
            [
                'name' => 'Laravel 8',
                'slug' => 'laravel-8',
                'description' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Saepe repellat aspernatur vitae sapiente quidem voluptates?',
                'thumbnail' => null,
                'genre' => 'laravel,php,mysql',
                'user_id' => 2,
            ],
            [
                'name' => 'Laravel 7',
                'slug' => 'laravel-7',
                'description' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Saepe repellat aspernatur vitae sapiente quidem voluptates?',
                'thumbnail' => null,
                'genre' => 'laravel,php,mysql',
                'user_id' => 3,
            ],
        ]);
        Playlist::find(1)->tags()->sync([1,2,3]);
        Playlist::find(2)->tags()->sync([1,2,4]);
    }
}
