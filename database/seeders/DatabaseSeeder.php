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
    }
}
