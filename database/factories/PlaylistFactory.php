<?php

namespace Database\Factories;

use App\Models\Playlist;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PlaylistFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Playlist::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->unique()->words($nb = 3, $asText = true);
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->text(200),
            'tags' => $this->faker->words($nb = 3, $asText = false),
            'user_id' => 2,
            'thumbnail' => '',
        ];
    }
}
