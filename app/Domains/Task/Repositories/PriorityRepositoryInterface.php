<?php

declare(strict_types=1);

namespace App\Domains\Task\Repositories;

use App\Domains\Task\ValueObjects\Priority;

interface PriorityRepositoryInterface
{
    /**
     * @return Priority[]
     */
    public function findAll(): array;
}
