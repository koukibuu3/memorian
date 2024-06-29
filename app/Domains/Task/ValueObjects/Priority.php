<?php

declare(strict_types=1);

namespace App\Domains\Task\ValueObjects;

use InvalidArgumentException;

final class Priority
{
    private const LABELS = [
        1 => 'lowest',
        2 => 'low',
        3 => 'middle',
        4 => 'high',
        5 => 'highest',
    ];

    public readonly string $label;

    public function __construct(int $id)
    {
        if ($id < 1 || $id > 5) {
            throw new InvalidArgumentException('Priority must be between 1 and 5');
        }

        $this->label = self::LABELS[$id];
    }
}
