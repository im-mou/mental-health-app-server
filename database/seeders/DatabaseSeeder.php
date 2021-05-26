<?php

namespace Database\Seeders;

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
        \App\Models\User::factory(10)->create();
        \App\Models\Journal::factory(20)->create();
        \App\Models\Chat::factory(50)->create();
        \App\Models\Interest::factory(10)->create();
        \App\Models\UserInterest::factory(20)->create();
        \App\Models\Question::factory(10)->create();

    }
}
