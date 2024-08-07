<?php

namespace App\Http\Controllers\Api;

use App\Domains\Task\Entities\Task;
use App\Domains\Task\Repositories\TaskRepositoryInterface;
use App\Http\Requests\StoreTaskRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class TaskController
{
    public function __construct(private TaskRepositoryInterface $taskRepository)
    {
    }

    /** 一覧取得 */
    public function index(): JsonResponse
    {
        return response()->json($this->taskRepository->findAll());
    }

    /** 詳細取得 */
    public function show(string $id): JsonResponse
    {
        try {
            $task = $this->taskRepository->findById($id);
        } catch (Exception $e) {
            return response()->json(['message' => "Task not found. {$e->getMessage()}"], 404);
        }

        return response()->json($task);
    }

    /** 登録 */
    public function store(StoreTaskRequest $request): JsonResponse
    {
        $postParams = $request->validated();
        try {
            $task = Task::create(
                $postParams['title'],
                $postParams['description'],
                $postParams['assignee_id'],
                $postParams['assignee_name'],
                $postParams['priority']
            );
            $this->taskRepository->store($task);
        } catch (Exception $e) {
            return response()->json(['message' => "Failed to create task. {$e->getMessage()}"], 500);
        }

        return response()->json($task, 201);
    }

    /** 更新 */
    public function update(Request $request, string $id): JsonResponse
    {
        $postParams = $request->post();
        try {
            $task = Task::recreate(
                id: $id,
                title: $postParams['title'],
                description: $postParams['description'],
                userId: $postParams['assignee_id'],
                userName: $postParams['assignee_name'],
                priority: $postParams['priority']
            );
            $this->taskRepository->update($task);
        } catch (Exception $e) {
            return response()->json(['message' => "Failed to update task. {$e->getMessage()}"], 500);
        }

        return response()->json($task);
    }

    /** 削除 */
    public function destroy(string $id): JsonResponse
    {
        try {
            $this->taskRepository->delete($id);
        } catch (Exception $e) {
            return response()->json(['message' => "Failed to delete task. {$e->getMessage()}"], 500);
        }

        return response()->json(['message' => 'Task deleted.'], 204);
    }
}
