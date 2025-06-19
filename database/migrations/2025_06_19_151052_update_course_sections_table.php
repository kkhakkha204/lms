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
        Schema::table('course_sections', function (Blueprint $table) {
            // Thêm soft deletes nếu chưa có
            if (!Schema::hasColumn('course_sections', 'deleted_at')) {
                $table->softDeletes();
            }

            // Thêm index cho performance
            if (!Schema::hasIndex('course_sections', 'course_sections_course_id_sort_order_index')) {
                $table->index(['course_id', 'sort_order']);
            }

            if (!Schema::hasIndex('course_sections', 'course_sections_course_id_is_active_index')) {
                $table->index(['course_id', 'is_active']);
            }

            // Đảm bảo sort_order có default value
            $table->integer('sort_order')->default(1)->change();

            // Đảm bảo is_active có default value
            $table->boolean('is_active')->default(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_sections', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropIndex(['course_id', 'sort_order']);
            $table->dropIndex(['course_id', 'is_active']);
        });
    }
};
