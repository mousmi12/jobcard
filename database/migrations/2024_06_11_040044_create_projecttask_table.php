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
        Schema::create('projecttask', function (Blueprint $table) {
            $table->id();
            $table->foreignId('projectid')->constrained('project')->onDelete('cascade');
            $table->foreignId('taskid')->constrained('task')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projecttask');
    }
};
