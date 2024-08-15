<?php

namespace Database\Factories;

use App\Infrastructures\Models\TaskRelation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<TaskRelation>
 */
class TaskRelationFactory extends Factory
{
    protected $model = TaskRelation::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'parent_task_id' => Str::ulid(),
            'child_task_id' => Str::ulid(),
        ];
    }
}
