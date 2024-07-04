<?php

declare(strict_types=1);

namespace App\Domains\Task\Entities;

use App\Domains\Task\ValueObjects\Priority;
use Illuminate\Support\Str;

final class Task
{
    public function __construct(
        public string $id,
        public string $title,
        public string $description,
        public Assignee $assignee,
        public Priority $priority,
    ) {
    }

    public static function create(string $title, string $description, int $userId, string $userName, int $priority): Task
    {
        return new Task(
            id: (string) Str::ulid(),
            title: $title,
            description: $description,
            assignee: new Assignee($userId, $userName),
            priority: new Priority($priority),
        );
    }
}
