<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained()->onDelete('cascade');

            // Question Content
            $table->text('question');
            $table->enum('type', ['single_choice', 'multiple_choice', 'fill_blank', 'true_false']);
            $table->text('explanation')->nullable(); // Explanation for correct answer

            // Settings
            $table->decimal('points', 5, 2)->default(1); // Points for correct answer
            $table->boolean('is_required')->default(true);
            $table->integer('sort_order')->default(0);

            $table->timestamps();

            $table->index(['quiz_id', 'sort_order']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('quiz_questions');
    }
};
