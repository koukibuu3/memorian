<?php

namespace Database\Seeders;

use App\Infrastructures\Models\Task;
use App\Infrastructures\Models\TaskRelation;
use App\Infrastructures\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        User::factory()->create([
            'name' => 'Kouki Akasaka',
            'email' => 'test2@example.com',
        ]);

        // tasks
        Task::factory()->create(['id' => '01J58GXV59AS2TKCQW4H2JD1W2']);
        Task::factory()->create(['id' => '01J58GXV6W2WSCZP9P9P2KAH0Q']);
        Task::factory()->create(['id' => '01J58GXV6W2WSCZP9P9P2KAH0R']);
        Task::factory(2)->create();

        // task_relations
        TaskRelation::factory()->create([
            'parent_task_id' => '01J58GXV59AS2TKCQW4H2JD1W2',
            'child_task_id' => '01J58GXV6W2WSCZP9P9P2KAH0Q',
        ]);
        TaskRelation::factory()->create([
            'parent_task_id' => '01J58GXV59AS2TKCQW4H2JD1W2',
            'child_task_id' => '01J58GXV6W2WSCZP9P9P2KAH0R',
        ]);

        // statuses
        $this->call(StatusSeeder::class);
    }
}
