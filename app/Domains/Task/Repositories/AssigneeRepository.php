<?php

declare(strict_types=1);

namespace App\Domains\Task\Repositories;

use App\Domains\Task\Entities\Assignee;
use App\Infrastructures\Models\User;

final class AssigneeRepository implements AssigneeRepositoryInterface
{
    public function findAll(): array
    {
        $users = User::all();

        return $users->map(function ($user) {
            return new Assignee($user->id, $user->name);
        })->all();
    }
}
