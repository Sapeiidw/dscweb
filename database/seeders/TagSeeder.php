<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Tags\Tag;

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
                'name' => 'english',
            ],
            [
                'name' => 'laravel',
            ],
            [
                'name' => 'mysql',
            ],
            [
                'name' => 'premium',
            ],
        ]);
    }
}
