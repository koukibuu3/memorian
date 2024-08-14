<?php

declare(strict_types=1);

namespace App\Domains\Task\Repositories;

use App\Domains\Task\Entities\Assignee;

interface AssigneeRepositoryInterface
{
    /**
     * @return Assignee[]
     */
    public function findAll(): array;
}
