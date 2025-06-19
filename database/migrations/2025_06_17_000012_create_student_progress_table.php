<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('student_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('lesson_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('quiz_id')->nullable()->constrained()->onDelete('cascade');

            // Progress Info
            $table->enum('type', ['lesson', 'quiz']);
            $table->enum('status', ['not_started', 'in_progress', 'completed'])->default('not_started');

            // Lesson Progress
            $table->integer('video_watched_seconds')->default(0);
            $table->boolean('lesson_completed')->default(false);

            // Quiz Progress
            $table->decimal('quiz_score', 5, 2)->nullable();
            $table->integer('quiz_attempts')->default(0);
            $table->boolean('quiz_passed')->default(false);
            $table->json('quiz_answers')->nullable(); // Store student answers

            // Timestamps
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->unique(['student_id', 'lesson_id'], 'unique_student_lesson');
            $table->unique(['student_id', 'quiz_id'], 'unique_student_quiz');
            $table->index(['student_id', 'course_id']);
            $table->index(['course_id', 'type']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_progress');
    }
};
