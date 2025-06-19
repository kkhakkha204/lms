<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('course_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');

            // Review Content
            $table->integer('rating'); // 1-5 stars
            $table->text('review')->nullable();
            $table->boolean('is_approved')->default(false);

            $table->timestamps();

            $table->unique(['student_id', 'course_id']);
            $table->index(['course_id', 'is_approved']);
            $table->index(['course_id', 'rating']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('course_reviews');
    }
};
