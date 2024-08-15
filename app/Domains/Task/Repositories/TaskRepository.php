<?php

declare(strict_types=1);

namespace App\Domains\Task\Repositories;

use App\Domains\Task\Entities\Task;
use App\Infrastructures\Models\Task as TaskModel;
use App\Infrastructures\Models\TaskRelation as TaskRelationModel;

final class TaskRepository implements TaskRepositoryInterface
{
    /**
     * @return Task[]
     */
    public function findAll(): array
    {
        $taskModels = TaskModel::with('assignee')->orderBy('created_at', 'desc')->get();

        /** @var Task[] */
        $taskEntities = $taskModels->map(function (TaskModel $taskModel) {
            return Task::recreate(
                $taskModel->id,
                $taskModel->title,
                $taskModel->description,
                $taskModel->assignee?->id,
                $taskModel->assignee?->name,
                $taskModel->priority,
                null,
                [],
                $taskModel->created_at,
                $taskModel->updated_at
            );
        })->all();

        return $taskEntities;
    }

    public function findById(string $id): Task
    {
        /** @var TaskModel */
        $taskModel = TaskModel::with(['assignee', 'children', 'parents'])->findOrFail($id);

        return Task::recreate(
            $taskModel->id,
            $taskModel->title,
            $taskModel->description,
            $taskModel->assignee?->id,
            $taskModel->assignee?->name,
            $taskModel->priority,
            $taskModel->parents->isNotEmpty() ? Task::recreate(
                $taskModel->parents[0]->id,
                $taskModel->parents[0]->title,
                $taskModel->parents[0]->description,
                $taskModel->parents[0]->assignee?->id,
                $taskModel->parents[0]->assignee?->name,
                $taskModel->parents[0]->priority,
                null,
                [],
                $taskModel->parents[0]->created_at,
                $taskModel->parents[0]->updated_at
            ) : null,
            $taskModel->children->map(function (TaskModel $childTaskModel) {
                return Task::recreate(
                    $childTaskModel->id,
                    $childTaskModel->title,
                    $childTaskModel->description,
                    $childTaskModel->assignee?->id,
                    $childTaskModel->assignee?->name,
                    $childTaskModel->priority,
                    null,
                    [],
                    $childTaskModel->created_at,
                    $childTaskModel->updated_at
                );
            })->all(),
            $taskModel->created_at,
            $taskModel->updated_at
        );
    }

    public function store(Task $task): string
    {
        $taskModel = TaskModel::create([
            'title' => $task->title,
            'description' => $task->description,
            'assignee_id' => $task->assignee?->userId,
            'priority' => $task->priority->id,
        ]);

        return $taskModel->id;
    }

    public function update(Task $task): void
    {
        $taskModel = TaskModel::findOrFail($task->id);
        $taskModel->title = $task->title;
        $taskModel->description = $task->description;
        $taskModel->assignee_id = $task->assignee?->userId;
        $taskModel->priority = $task->priority->id;
        $taskModel->save();

        // task_relationsテーブルの更新処理
        $taskRelationModel = TaskRelationModel::where('child_task_id', $task->id)->first();
        if ($taskRelationModel) {
            $taskRelationModel->parent_task_id = $task->parent->id;
            $taskRelationModel->save();
        } else {
            $task->parent && TaskRelationModel::create([
                'parent_task_id' => $task->parent->id,
                'child_task_id' => $task->id,
            ]);
        }
    }

    public function delete(string $id): void
    {
        TaskModel::destroy($id);
    }
}
