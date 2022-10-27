<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@shocklogictest.com',
            'role' => true
        ]);

        User::factory()->create([
            'name' => 'tavo',
            'email' => 'tavo@shocklogictest.com',
        ]);

        User::factory(20)->create();

        Event::factory(3)->create();
    }
}
