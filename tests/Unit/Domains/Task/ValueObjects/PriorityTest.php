<?php

declare(strict_types=1);

namespace Tests\Unit\Domains\Task\ValueObjects;

use App\Domains\Task\ValueObjects\Priority;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[Group('domains.task.value_objects')]
final class PriorityTest extends TestCase
{
    #[Test]
    public function 優先度が不正な場合は例外が発生する()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Priority must be between 1 and 5');

        new Priority(0);
    }
}
