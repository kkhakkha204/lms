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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('enrollment_id')->constrained()->onDelete('cascade');

            // Certificate Info
            $table->string('certificate_number')->unique(); // LMS-2025-000001
            $table->string('certificate_code')->unique(); // Verification code: CERT-ABC123XYZ
            $table->string('title'); // Certificate title (e.g., "Certificate of Completion")
            $table->text('description')->nullable(); // Additional description

            // Completion Data
            $table->decimal('final_score', 5, 2)->nullable(); // Overall score percentage
            $table->integer('lessons_completed'); // Number of lessons completed
            $table->integer('quizzes_completed'); // Number of quizzes completed
            $table->decimal('average_quiz_score', 5, 2)->nullable(); // Average quiz score
            $table->integer('total_study_hours')->default(0); // Total study time
            $table->date('course_started_at'); // When student started the course
            $table->date('course_completed_at'); // When course was completed

            // Certificate Details
            $table->string('instructor_name'); // Instructor name at time of completion
            $table->string('instructor_signature')->nullable(); // Path to signature image
            $table->json('course_details'); // Store course info (title, duration, etc.)
            $table->string('certificate_template')->default('default'); // Template used

            // Status & Verification
            $table->enum('status', ['active', 'revoked', 'expired'])->default('active');
            $table->timestamp('issued_at'); // When certificate was issued
            $table->timestamp('expires_at')->nullable(); // Certificate expiration (if any)
            $table->integer('download_count')->default(0); // Track downloads
            $table->timestamp('last_downloaded_at')->nullable();

            // PDF Storage
            $table->string('pdf_path')->nullable(); // Stored PDF file path
            $table->string('pdf_hash')->nullable(); // PDF file hash for integrity

            $table->timestamps();

            // Indexes
            $table->index(['student_id', 'course_id']);
            $table->index(['status', 'issued_at']);
            $table->index('certificate_number');
            $table->index('certificate_code');
            $table->unique(['student_id', 'course_id']); // One certificate per student per course
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};

// Chạy: php artisan make:migration create_certificates_table
