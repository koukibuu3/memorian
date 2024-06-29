<?php

declare(strict_types=1);

namespace App\Infrastructures\Models;

use Database\Factories\TaskFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $assignee_id
 * @property User $assignee
 * @property int $priority
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Task extends Model
{
    use HasFactory;

    protected static function newFactory(): TaskFactory
    {
        return TaskFactory::new();
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
