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
                $taskModel->assignee?->id,
                $taskModel->assignee?->name,
                $taskModel->priority,
                $taskModel->created_at,
                $taskModel->updated_at
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
            $taskModel->assignee?->id,
            $taskModel->assignee?->name,
            $taskModel->priority,
            $taskModel->created_at,
            $taskModel->updated_at
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

    public function update(Task $task): void
    {
        $taskModel = TaskModel::findOrFail($task->id);
        $taskModel->title = $task->title;
        $taskModel->description = $task->description;
        $taskModel->assignee_id = $task->assignee->userId;
        $taskModel->priority = $task->priority->id;
        $taskModel->save();
    }

    public function delete(string $id): void
    {
        TaskModel::destroy($id);
    }
}
