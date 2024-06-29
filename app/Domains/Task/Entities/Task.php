<?php

declare(strict_types=1);

namespace App\Domains\Task\Entities;

use App\Domains\Task\ValueObjects\Priority;

final class Task
{
    public function __construct(
        public string $title,
        public string $description,
        public Assignee $assignee,
        public Priority $priority,
    ) {
    }
}
