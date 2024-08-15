<?php

declare(strict_types=1);

namespace App\Infrastructures\Models;

use Database\Factories\TaskRelationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskRelation extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_task_id',
        'child_task_id',
    ];

    protected static function newFactory()
    {
        return TaskRelationFactory::new();
    }
}
