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
        Schema::table('lessons', function (Blueprint $table) {
            // Change content column from TEXT to LONGTEXT to store rich HTML content
            $table->longText('content')->nullable()->change();

            // Add some performance indexes
            $table->index(['course_id', 'section_id', 'sort_order'], 'lessons_course_section_order_idx');
            $table->index(['is_active', 'is_preview'], 'lessons_status_preview_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            // Revert back to text type
            $table->text('content')->nullable()->change();

            // Drop the indexes
            $table->dropIndex('lessons_course_section_order_idx');
            $table->dropIndex('lessons_status_preview_idx');
        });
    }
};
