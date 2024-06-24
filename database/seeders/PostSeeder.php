<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // creates 10 Posts for the User Admin
        \App\Models\Post::factory(10)->for(User::create([
            'name' => 'Admin',
            'email' => 'admin@hsv.de',
            'password' => bcrypt('hsv1887tv'),
        ]))->create();
    }
}
