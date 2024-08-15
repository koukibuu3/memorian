<?php

declare(strict_types=1);

namespace App\Infrastructures\Models;

use Database\Factories\TaskFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * @property string $id
 * @property string $title
 * @property string $description
 * @property int $assignee_id
 * @property User $assignee
 * @property int $priority
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Collection<Task> $children
 * @property Collection<Task> $parents
 */
class Task extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'title',
        'description',
        'assignee_id',
        'priority',
    ];

    protected static function newFactory(): TaskFactory
    {
        return TaskFactory::new();
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function children(): BelongsToMany
    {
        return $this->belongsToMany(Task::class, 'task_relations', 'parent_task_id', 'child_task_id');
    }

    public function parents(): BelongsToMany
    {
        return $this->belongsToMany(Task::class, 'task_relations', 'child_task_id', 'parent_task_id');
    }
}
