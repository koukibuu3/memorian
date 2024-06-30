<?php

namespace App\Http\Controllers\Api;

use App\Domains\Task\Entities\Task;
use App\Domains\Task\Repositories\TaskRepositoryInterface;
use App\Http\Requests\StoreTaskRequest;
use Exception;
use Illuminate\Http\JsonResponse;

final class TaskController
{
    public function __construct(private TaskRepositoryInterface $taskRepository)
    {
    }

    /**
     * 一覧取得
     */
    public function index(): JsonResponse
    {
        return response()->json($this->taskRepository->findAll());
    }

    /**
     * 登録
     */
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
}
