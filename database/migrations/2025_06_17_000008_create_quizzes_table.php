<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('section_id')->constrained('course_sections')->onDelete('cascade');

            // Basic Info
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('instructions')->nullable();

            // Quiz Settings
            $table->integer('time_limit')->nullable(); // Minutes
            $table->integer('max_attempts')->default(1);
            $table->decimal('passing_score', 5, 2)->default(70); // Percentage
            $table->boolean('show_results')->default(true);
            $table->boolean('shuffle_questions')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);

            $table->timestamps();

            $table->index(['section_id', 'sort_order']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('quizzes');
    }
};
