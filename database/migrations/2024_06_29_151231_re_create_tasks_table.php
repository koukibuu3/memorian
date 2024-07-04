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
        Schema::dropIfExists('tasks');
        Schema::create('tasks', function (Blueprint $table) {
            $table->ulid('id')->primary()->comment('ULID');
            $table->string('title')->comment('タイトル');
            $table->string('description')->nullable()->comment('詳細');
            $table->foreignId('assignee_id')->nullable()->comment('担当者')->constrained('users');
            $table->tinyInteger('priority')->default(3)->comment('優先度');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('タイトル');
            $table->string('description')->nullable()->comment('詳細');
            $table->foreignId('assignee_id')->nullable()->comment('担当者')->constrained('users');
            $table->tinyInteger('priority')->default(3)->comment('優先度');
            $table->timestamps();
        });
    }
};
