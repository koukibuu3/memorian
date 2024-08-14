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

    public function findById(string $id): Task;

    public function store(Task $task): string;

    public function update(Task $task): void;

    public function delete(string $id): void;
}
