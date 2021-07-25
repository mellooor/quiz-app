<?php

namespace Database\Seeders;

use App\Models\UserRole;
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
        \App\Models\UserRole::factory()->create(['role' => 'user']);
        \App\Models\UserRole::factory()->create(['role' => 'admin']);
        \App\Models\User::factory()->admin()->create();
        \App\Models\User::factory(10)->create();
        \App\Models\QuizTopic::factory(2)->create();
        \App\Models\Quiz::factory(20)->create(['author_id' => 1, 'topic_id' => 1]);
        \App\Models\Quiz::factory(5)->create(['author_id' => 1, 'topic_id' => 2]);
        \App\Models\Quiz::factory(5)->create(['author_id' => 1, 'topic_id' => null]);
    }
}
