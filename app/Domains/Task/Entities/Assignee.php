<?php

declare(strict_types=1);

namespace App\Domains\Task\Entities;

use InvalidArgumentException;

final class Assignee
{
    const NAME_MIN_LENGTH = 2;

    const NAME_MAX_LENGTH = 24;

    public function __construct(
        public int $userId,
        public string $name,
    ) {
        if (strlen($name) < self::NAME_MIN_LENGTH) {
            throw new InvalidArgumentException('Name must be at least '.self::NAME_MIN_LENGTH.' characters');
        }
        if (strlen($name) > self::NAME_MAX_LENGTH) {
            throw new InvalidArgumentException('Name must not be longer than '.self::NAME_MAX_LENGTH.' characters');
        }
    }
}
