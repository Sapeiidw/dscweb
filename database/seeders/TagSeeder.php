<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tag::insert([
            [
                'name' => 'php',
                'slug' => 'php',
            ],
            [
                'name' => 'laravel',
                'slug' => 'laravel',
            ],
            [
                'name' => 'permium',
                'slug' => 'permium',
            ],
            [
                'name' => 'free',
                'slug' => 'free',
            ],
        ]);
    }
}
