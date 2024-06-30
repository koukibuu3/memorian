<?php

declare(strict_types=1);

namespace App\Domains\Task\Repositories;

use App\Domains\Task\Entities\Task;
use App\Infrastructures\Models\Task as TaskModel;

final class TaskRepository implements TaskRepositoryInterface
{
    /**
     * @return Task[]
     */
    public function findAll(): array
    {
        $taskModels = TaskModel::with('assignee')->get();

        /** @var Task[] */
        $taskEntities = $taskModels->map(function (TaskModel $taskModel) {
            return Task::recreate(
                $taskModel->id,
                $taskModel->title,
                $taskModel->description,
                $taskModel->assignee->id,
                $taskModel->assignee->name,
                $taskModel->priority
            );
        })->all();

        return $taskEntities;
    }

    public function findById(string $id): Task
    {
        $taskModel = TaskModel::with('assignee')->findOrFail($id);

        return Task::recreate(
            $taskModel->id,
            $taskModel->title,
            $taskModel->description,
            $taskModel->assignee->id,
            $taskModel->assignee->name,
            $taskModel->priority
        );
    }

    public function store(Task $task): void
    {
        TaskModel::create([
            'title' => $task->title,
            'description' => $task->description,
            'assignee_id' => $task->assignee->userId,
            'priority' => $task->priority->id,
        ]);
    }
}
