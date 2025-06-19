<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('section_id')->constrained('course_sections')->onDelete('cascade');

            // Basic Info
            $table->string('title');
            $table->string('slug');
            $table->text('content')->nullable(); // Lesson text content
            $table->text('summary')->nullable();

            // Media
            $table->string('video_url')->nullable();
            $table->string('video_duration')->nullable(); // Format: HH:MM:SS
            $table->integer('video_size')->nullable(); // Size in MB

            // Settings
            $table->enum('type', ['video', 'text', 'mixed'])->default('video');
            $table->boolean('is_preview')->default(false); // Free preview lesson
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);

            $table->timestamps();

            $table->unique(['course_id', 'slug']);
            $table->index(['section_id', 'sort_order']);
            $table->index(['course_id', 'is_preview']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('lessons');
    }
};
