<?php

declare(strict_types=1);

namespace App\Domains\Task\Repositories;

use App\Domains\Task\ValueObjects\Priority;

final class PriorityRepository implements PriorityRepositoryInterface
{
    public function findAll(): array
    {
        return [
            new Priority(5),
            new Priority(4),
            new Priority(3),
            new Priority(2),
            new Priority(1),
        ];
    }
}
