<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       DB::table('posts')->insert([
           [
            'user_id' => 1,
            'content' => fake()->text(),
            'image_url' => 'https://placehold.co/300',
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null
           ],
           [
            'user_id' => 2,
            'content' => fake()->text(),
            'image_url' => 'https://placehold.co/300',
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null
           ]
       ]);
    }
}
