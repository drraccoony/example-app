<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // Create some teams...
        \App\Models\team::factory()->create([
            'name' => 'Alpha Team',
            'owner_id' => 2
        ]);
        \App\Models\team::factory()->create([
            'name' => 'Bravo Team',
            'owner_id' => 4
        ]);
        \App\Models\team::factory()->create([
            'name' => 'Charlie Team',
            'owner_id' => 1
        ]);

        // Create some activities...
        \App\Models\activities::factory(5)->create();
        \App\Models\activities::factory(2)->mainstage()->points500()->create();

        // Create some users.
        \App\Models\User::factory(5)->create();
        \App\Models\User::factory(2)->unverified()->create();

        // Create a consistent known user for us to login with.
        // Password hash defaults to 'password'
        \App\Models\User::factory()->create([
            'name' => 'Rico',
            'email' => 'drraccoony@gmail.com',
            'team_id' => 1,
        ]);
    }
}
