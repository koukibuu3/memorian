<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('task_relations', function (Blueprint $table) {
            $table->id();
            $table->foreignUlid('parent_task_id')->references('id')->on('tasks')->comment('親タスクID');
            $table->foreignUlid('child_task_id')->references('id')->on('tasks')->comment('子タスクID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_relations');
    }
};
