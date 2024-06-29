<?php

declare(strict_types=1);

namespace App\Domains\Task\Repositories;

use App\Domains\Task\Entities\Assignee;
use App\Domains\Task\Entities\Task;
use App\Domains\Task\ValueObjects\Priority;
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
            return new Task(
                $taskModel->title,
                $taskModel->description,
                new Assignee($taskModel->assignee->id, $taskModel->assignee->name),
                new Priority($taskModel->priority),
            );
        })->all();

        return $taskEntities;
    }
}
