<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');

            // Enrollment Info
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->enum('status', ['active', 'completed', 'expired', 'cancelled'])->default('active');
            $table->timestamp('enrolled_at');
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            // Progress Tracking
            $table->integer('progress_percentage')->default(0);
            $table->integer('lessons_completed')->default(0);
            $table->integer('quizzes_completed')->default(0);
            $table->decimal('average_quiz_score', 5, 2)->default(0);

            // Timestamps
            $table->timestamps();

            $table->unique(['student_id', 'course_id']);
            $table->index(['student_id', 'status']);
            $table->index(['course_id', 'status']);
            $table->index('enrolled_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('enrollments');
    }
};
