<?php

namespace Database\Seeders;

use App\Models\Video;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Video::insert([
            [
                'name' => 'Intro',
                'slug' => Str::slug('Intro'),
                'code' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/3VTkBuxU4yk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
                'duration' => '5:00',
                'episode' => 0,
                'available_for' => 'free',
            ],
            [
                'name' => 'Instalasi Project',
                'slug' => Str::slug('Instalasi Project'),
                'code' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/0VdIe1m8Ti8" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
                'duration' => '5:00',
                'episode' => 1,
                'available_for' => 'premium',
            ],
            [
                'name' => 'Setting Dashboard',
                'slug' => Str::slug('Setting Dashboard'),
                'code' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/JvjMC3lSEDo" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
                'duration' => '5:00',
                'episode' => 2,
                'available_for' => 'premium',
            ],
        ]);
        Video::find(1)->playlists()->sync(1);
        Video::find(2)->playlists()->sync(1);
        Video::find(3)->playlists()->sync(1);
    }
}
