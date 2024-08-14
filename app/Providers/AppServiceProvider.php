<?php

namespace App\Providers;

use App\Domains\Task\Repositories\AssigneeRepository;
use App\Domains\Task\Repositories\AssigneeRepositoryInterface;
use App\Domains\Task\Repositories\PriorityRepository;
use App\Domains\Task\Repositories\PriorityRepositoryInterface;
use App\Domains\Task\Repositories\TaskRepository;
use App\Domains\Task\Repositories\TaskRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
        $this->app->bind(PriorityRepositoryInterface::class, PriorityRepository::class);
        $this->app->bind(AssigneeRepositoryInterface::class, AssigneeRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
