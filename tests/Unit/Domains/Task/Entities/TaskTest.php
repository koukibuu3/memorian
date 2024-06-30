<?php

declare(strict_types=1);

namespace Tests\Unit\Domains\Task\Entities;

use App\Domains\Task\Entities\Task;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[Group('domains.task.entities')]
final class TaskTest extends TestCase
{
    #[Test]
    public function 一意なulidを持ったタスクを生成できる()
    {
        $task = Task::create('title', 'description', 1, 'user', 1);
        $this->assertMatchesRegularExpression('/^[0-9A-Z]{26}$/', $task->id);
    }

    #[Test]
    public function タスクを再生成できる()
    {
        $task = Task::recreate('ulid', 'title', 'description', 1, 'user', 1);
        $this->assertSame('ulid', $task->id);
        $this->assertSame('title', $task->title);
        $this->assertSame('description', $task->description);
        $this->assertSame(1, $task->assignee->userId);
        $this->assertSame('user', $task->assignee->name);
        $this->assertSame(1, $task->priority->id);
    }
}
