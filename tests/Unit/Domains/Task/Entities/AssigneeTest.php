<?php

declare(strict_types=1);

namespace Tests\Unit\Domains\Task\Entities;

use App\Domains\Task\Entities\Assignee;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[Group('domains.task.entities')]
final class AssigneeTest extends TestCase
{
    #[Test]
    public function 名前が2文字未満の場合は例外が発生する()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Name must be at least 2 characters');

        new Assignee(1, 'a');
    }

    #[Test]
    public function 名前が24文字を超える場合は例外が発生する()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Name must not be longer than 24 characters');

        new Assignee(1, str_repeat('a', 25));
    }
}
