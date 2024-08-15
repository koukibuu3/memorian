<?php

declare(strict_types=1);

namespace App\Domains\Task\Entities;

use App\Domains\Task\ValueObjects\Priority;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

final class SubTask
{
    public function __construct(
        public string $id,
        public string $title,
        public string $description,
        public ?Assignee $assignee,
        public Priority $priority,
        public ?Carbon $createdAt = null,
        public ?Carbon $updatedAt = null,
    ) {
    }

    public static function create(
        string $title,
        string $description,
        ?int $userId,
        string $userName,
        int $priority,
    ): SubTask {
        return new SubTask(
            id: (string) Str::ulid(),
            title: $title,
            description: $description,
            assignee: $userId && $userName ? new Assignee($userId, $userName) : null,
            priority: new Priority($priority),
        );
    }

    public static function recreate(
        string $id,
        string $title,
        string $description,
        ?int $userId,
        ?string $userName,
        int $priority,
        ?Carbon $createAt = null,
        ?Carbon $updatedAt = null,
    ): SubTask {
        return new SubTask(
            id: $id,
            title: $title,
            description: $description,
            assignee: $userId && $userName ? new Assignee($userId, $userName) : null,
            priority: new Priority($priority),
            createdAt: $createAt,
            updatedAt: $updatedAt,
        );
    }
}
