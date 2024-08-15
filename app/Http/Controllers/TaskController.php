<?php

namespace App\Http\Controllers;

use App\Domains\Task\Entities\Task;
use App\Domains\Task\Repositories\AssigneeRepositoryInterface;
use App\Domains\Task\Repositories\PriorityRepositoryInterface;
use App\Domains\Task\Repositories\TaskRepositoryInterface;
use Error;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
            'tasks' => $this->taskRepository->findAll(),
            'priorities' => $this->priorityRepository->findAll(),
            'assignees' => $this->assigneeRepository->findAll(),
        ]);
    }

    /** 新規作成 */
    public function create()
    {
        return View::make('tasks.create', [
            'priorities' => $this->priorityRepository->findAll(),
            'assignees' => $this->assigneeRepository->findAll(),
        ]);
    }

    /** 登録 */
    public function store(Request $request)
    {
        $postParams = $request->post();
        try {
            $task = Task::create(
                $postParams['title'],
                $postParams['description'],
                $postParams['assignee_id'],
                'None User',
                $postParams['priority']
            );
            $createdId = $this->taskRepository->store($task);
        } catch (Error $e) {
            Log::error($e->getMessage());

            return redirect()->route('tasks.create')->with('error', 'Failed to create task.');
        }

        return redirect()->route('tasks.show', ['id' => $createdId])->with('success', 'Task created.');
    }

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
                priority: $postParams['priority'],
                parent: $postParams['parent_id'] !== null ? Task::recreate(
                    id: $postParams['parent_id'],
                    title: '',
                    description: '',
                    userId: null,
                    userName: '',
                    priority: 3,
                ) : null,
            );
            $this->taskRepository->update($task);
        } catch (Exception $e) {
            throw $e;

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
