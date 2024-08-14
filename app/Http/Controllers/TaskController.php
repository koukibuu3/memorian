<?php

namespace App\Http\Controllers;

use App\Domains\Task\Entities\Task;
use App\Domains\Task\Repositories\AssigneeRepositoryInterface;
use App\Domains\Task\Repositories\PriorityRepositoryInterface;
use App\Domains\Task\Repositories\TaskRepositoryInterface;
use App\Http\Requests\StoreTaskRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

final class TaskController
{
    public function __construct(
        private AssigneeRepositoryInterface $assigneeRepository,
        private TaskRepositoryInterface $taskRepository,
        private PriorityRepositoryInterface $priorityRepository,
    ) {
    }

    /** 一覧取得 */
    public function index()
    {
        return View::make('tasks.index', [
            'tasks' => $this->taskRepository->findAll(),
        ]);
    }

    /** 詳細取得 */
    public function show(string $id)
    {
        return View::make('tasks.detail', [
            'task' => $this->taskRepository->findById($id),
            'priorities' => $this->priorityRepository->findAll(),
            'assignees' => $this->assigneeRepository->findAll(),
        ]);
    }

    /** 登録 */
    // public function store(StoreTaskRequest $request): JsonResponse
    // {
    //     $postParams = $request->validated();
    //     try {
    //         $task = Task::create(
    //             $postParams['title'],
    //             $postParams['description'],
    //             $postParams['assignee_id'],
    //             $postParams['assignee_name'],
    //             $postParams['priority']
    //         );
    //         $this->taskRepository->store($task);
    //     } catch (Exception $e) {
    //         return response()->json(['message' => "Failed to create task. {$e->getMessage()}"], 500);
    //     }

    //     return response()->json($task, 201);
    // }

    /** 更新 */
    public function update(Request $request, string $id)
    {
        $postParams = $request->post();
        try {
            $task = Task::recreate(
                id: $id,
                title: $postParams['title'],
                description: $postParams['description'],
                userId: $postParams['assignee_id'],
                userName: 'None User',
                priority: $postParams['priority']
            );
            $this->taskRepository->update($task);
        } catch (Exception $e) {
            return redirect()->route('tasks.show', ['id' => $id])->with('error', "Failed to update task. {$e->getMessage()}");
        }

        return redirect()->route('tasks.show', ['id' => $id])->with('success', 'Task updated.');
    }

    /** 削除 */
    // public function destroy(string $id): JsonResponse
    // {
    //     try {
    //         $this->taskRepository->delete($id);
    //     } catch (Exception $e) {
    //         return response()->json(['message' => "Failed to delete task. {$e->getMessage()}"], 500);
    //     }

    //     return response()->json(['message' => 'Task deleted.'], 204);
    // }
}
