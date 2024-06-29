<?php

declare(strict_types=1);

namespace App\Domains\Task\Repositories;

use App\Domains\Task\Entities\Task;

interface TaskRepositoryInterface
{
    /**
     * @return Task[]
     */
    public function findAll(): array;
}
