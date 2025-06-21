<?php

namespace App\Services;

use App\Models\Certificate;
use App\Models\Enrollment;
use App\Models\StudentProgress;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\CertificateIssued;

class CertificateService
{
    /**
     * Auto-issue certificate when course is completed
     */
    public function autoIssueCertificate(Enrollment $enrollment)
    {
        // Check i-f can issue certificate
        if (!Certificate::canIssueFor($enrollment)) {
            return null;
        }

        // Calculate completion data
        $completionData = $this->calculateCompletionData($enrollment);

        // Create certificate
        $certificate = $this->createCertificate($enrollment, $completionData);

        // Generate PDF
        $this->generateCertificatePDF($certificate);

        // Send email notification
        $this->sendCertificateEmail($certificate);

        return $certificate;
    }

    /**
     * Calculate completion data for certificate
     */
    private function calculateCompletionData(Enrollment $enrollment)
    {
        $course = $enrollment->course;
        $studentId = $enrollment->student_id;

        // Get all progress records
        $progressRecords = StudentProgress::where('student_id', $studentId)
            ->where('course_id', $course->id)
            ->get();

        // Calculate lessons data
        $lessonsCompleted = $progressRecords->where('type', 'lesson')
            ->where('lesson_completed', true)
            ->count();

        // Calculate quiz data
        $quizRecords = $progressRecords->where('type', 'quiz');
        $quizzesCompleted = $quizRecords->where('quiz_passed', true)->count();
        $averageQuizScore = $quizRecords->where('quiz_passed', true)
            ->avg('quiz_score') ?: 0;

        // Calculate study time (estimate based on video watched time and course duration)
        $totalVideoTime = $progressRecords->sum('video_watched_seconds') / 3600; // Convert to hours
        $estimatedStudyTime = max($totalVideoTime, $course->duration_hours * 0.8); // At least 80% of course duration

        // Calculate final score (weighted average of quiz scores and completion rate)
        $completionRate = $enrollment->progress_percentage;
        $finalScore = ($averageQuizScore * 0.7) + ($completionRate * 0.3); // 70% quiz, 30% completion

        return [
            'final_score' => round($finalScore, 2),
            'lessons_completed' => $lessonsCompleted,
            'quizzes_completed' => $quizzesCompleted,
            'average_quiz_score' => round($averageQuizScore, 2),
            'total_study_hours' => round($estimatedStudyTime),
            'course_started_at' => $enrollment->enrolled_at->toDateString(),
            'course_completed_at' => $enrollment->completed_at->toDateString(),
        ];
    }

    /**
     * Create certificate record
     */
    private function createCertificate(Enrollment $enrollment, array $completionData)
    {
        $course = $enrollment->course;
        $student = $enrollment->student;

        return Certificate::create([
            'student_id' => $student->id,
            'course_id' => $course->id,
            'enrollment_id' => $enrollment->id,
            'title' => 'Certificate of Completion',
            'description' => "Chứng nhận hoàn thành khóa học: {$course->title}",
            'instructor_name' => $course->instructor->name,
            'course_details' => [
                'title' => $course->title,
                'instructor' => $course->instructor->name,
                'category' => $course->category->name,
                'level' => $course->level,
                'duration_hours' => $course->duration_hours,
                'total_lessons' => $course->total_lessons,
                'total_quizzes' => $course->total_quizzes,
            ],
            ...$completionData
        ]);
    }

    /**
     * Generate certificate PDF
     */
    public function generateCertificatePDF(Certificate $certificate, $template = 'default')
    {
        // Load certificate data
        $certificate->load(['student', 'course', 'course.instructor', 'course.category']);

        // Choose template
        $templateView = $this->getCertificateTemplate($template);

        // Generate PDF
        $pdf = Pdf::loadView($templateView, [
            'certificate' => $certificate,
            'student' => $certificate->student,
            'course' => $certificate->course,
            'issuedDate' => $certificate->issued_at,
            'completedDate' => $certificate->course_completed_at,
        ]);

        // Configure PDF settings
        $pdf->setPaper('A4', 'landscape')
            ->setOptions([
                'dpi' => 150,
                'defaultFont' => 'DejaVu Sans',
                'isRemoteEnabled' => true,
                'isHtml5ParserEnabled' => true,
            ]);

        // Generate filename and path
        $filename = $this->generateCertificateFilename($certificate);
        $path = "certificates/{$certificate->id}/{$filename}";

        // Save PDF
        Storage::disk('public')->put($path, $pdf->output());

        // Generate file hash for integrity
        $hash = hash('sha256', $pdf->output());

        // Update certificate with PDF info
        $certificate->update([
            'pdf_path' => $path,
            'pdf_hash' => $hash,
            'certificate_template' => $template,
        ]);

        return $certificate;
    }

    /**
     * Get certificate template view
     */
    private function getCertificateTemplate($template)
    {
        $templates = [
            'default' => 'certificates.templates.default',
            'elegant' => 'certificates.templates.elegant',
            'modern' => 'certificates.templates.modern',
            'classic' => 'certificates.templates.classic',
        ];

        return $templates[$template] ?? $templates['default'];
    }

    /**
     * Generate certificate filename
     */
    public function generateCertificateFilename(Certificate $certificate)
    {
        $studentName = str_replace(' ', '_', $certificate->student->name);
        $courseName = str_replace(' ', '_', substr($certificate->course->title, 0, 30));
        $date = $certificate->issued_at->format('Y-m-d');

        return "Certificate_{$studentName}_{$courseName}_{$date}.pdf";
    }

    /**
     * Send certificate email
     */
    private function sendCertificateEmail(Certificate $certificate)
    {
        try {
            Mail::to($certificate->student->email)
                ->send(new CertificateIssued($certificate));
        } catch (\Exception $e) {
            \Log::error('Failed to send certificate email: ' . $e->getMessage());
        }
    }

    /**
     * Verify certificate by code
     */
    public function verifyCertificate($code)
    {
        return Certificate::where('certificate_code', $code)
            ->valid()
            ->with(['student', 'course'])
            ->first();
    }

    /**
     * Download certificate
     */
    public function downloadCertificate($code)
    {
        $certificate = $this->verifyCertificate($code);

        if (!$certificate) {
            return null;
        }

        // Regenerate PDF if not exists or corrupted
        if (!$certificate->pdf_path || !Storage::disk('public')->exists($certificate->pdf_path)) {
            $this->generateCertificatePDF($certificate);
        }

        // Verify PDF integrity
        if ($certificate->pdf_hash) {
            $currentHash = hash('sha256', Storage::disk('public')->get($certificate->pdf_path));
            if ($currentHash !== $certificate->pdf_hash) {
                // PDF corrupted, regenerate
                $this->generateCertificatePDF($certificate);
            }
        }

        // Increment download count
        $certificate->incrementDownload();

        return $certificate;
    }

    /**
     * Bulk issue certificates for completed enrollments
     */
    public function bulkIssueCertificates()
    {
        $completedEnrollments = Enrollment::where('progress_percentage', 100)
            ->where('status', 'active')
            ->whereDoesntHave('certificate')
            ->with(['course', 'student'])
            ->get();

        $issued = 0;
        foreach ($completedEnrollments as $enrollment) {
            try {
                $this->autoIssueCertificate($enrollment);
                $issued++;
            } catch (\Exception $e) {
                \Log::error("Failed to issue certificate for enrollment {$enrollment->id}: " . $e->getMessage());
            }
        }

        return $issued;
    }

    /**
     * Get certificate statistics
     */
    public function getCertificateStats()
    {
        return [
            'total_issued' => Certificate::count(),
            'active_certificates' => Certificate::active()->count(),
            'revoked_certificates' => Certificate::where('status', 'revoked')->count(),
            'expired_certificates' => Certificate::where('expires_at', '<', now())->count(),
            'total_downloads' => Certificate::sum('download_count'),
            'certificates_this_month' => Certificate::whereMonth('issued_at', now()->month)
                ->whereYear('issued_at', now()->year)
                ->count(),
        ];
    }
}
