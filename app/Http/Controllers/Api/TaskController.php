<?php

namespace App\Http\Controllers\Api;

use App\Domains\Task\Repositories\TaskRepositoryInterface;
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
}
