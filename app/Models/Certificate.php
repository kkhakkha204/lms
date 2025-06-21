<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'course_id',
        'enrollment_id',
        'certificate_number',
        'certificate_code',
        'title',
        'description',
        'final_score',
        'lessons_completed',
        'quizzes_completed',
        'average_quiz_score',
        'total_study_hours',
        'course_started_at',
        'course_completed_at',
        'instructor_name',
        'instructor_signature',
        'course_details',
        'certificate_template',
        'status',
        'issued_at',
        'expires_at',
        'download_count',
        'last_downloaded_at',
        'pdf_path',
        'pdf_hash',
    ];

    protected $casts = [
        'final_score' => 'decimal:2',
        'average_quiz_score' => 'decimal:2',
        'course_details' => 'array',
        'course_started_at' => 'date',
        'course_completed_at' => 'date',
        'issued_at' => 'datetime',
        'expires_at' => 'datetime',
        'last_downloaded_at' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeValid($query)
    {
        return $query->where('status', 'active')
            ->where(function ($q) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            });
    }

    /**
     * Accessors
     */
    public function getIsValidAttribute()
    {
        return $this->status === 'active' &&
            (is_null($this->expires_at) || $this->expires_at->isFuture());
    }

    public function getIsExpiredAttribute()
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function getFormattedIssuedDateAttribute()
    {
        return $this->issued_at->format('d/m/Y');
    }

    public function getFormattedCompletedDateAttribute()
    {
        return $this->course_completed_at->format('d/m/Y');
    }

    public function getPdfUrlAttribute()
    {
        return $this->pdf_path ? asset('storage/' . $this->pdf_path) : null;
    }

    public function getVerificationUrlAttribute()
    {
        return route('certificates.verify', $this->certificate_code);
    }

    public function getDownloadUrlAttribute()
    {
        return route('certificates.download', $this->certificate_code);
    }

    /**
     * Boot method để auto-generate certificate numbers
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($certificate) {
            if (empty($certificate->certificate_number)) {
                $certificate->certificate_number = static::generateCertificateNumber();
            }

            if (empty($certificate->certificate_code)) {
                $certificate->certificate_code = static::generateCertificateCode();
            }

            if (empty($certificate->issued_at)) {
                $certificate->issued_at = now();
            }
        });
    }

    /**
     * Generate unique certificate number
     */
    public static function generateCertificateNumber()
    {
        $year = date('Y');
        $lastCertificate = static::where('certificate_number', 'like', "LMS-{$year}-%")
            ->orderBy('certificate_number', 'desc')
            ->first();

        if ($lastCertificate) {
            $lastNumber = (int) substr($lastCertificate->certificate_number, -6);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return "LMS-{$year}-" . str_pad($newNumber, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Generate unique certificate verification code
     */
    public static function generateCertificateCode()
    {
        do {
            $code = 'CERT-' . strtoupper(substr(uniqid(), -8)) . strtoupper(substr(uniqid(), -3));
        } while (static::where('certificate_code', $code)->exists());

        return $code;
    }

    /**
     * Calculate study duration in hours
     */
    public function getStudyDurationAttribute()
    {
        if ($this->course_started_at && $this->course_completed_at) {
            $days = $this->course_started_at->diffInDays($this->course_completed_at);
            return $days > 0 ? $days : 1; // At least 1 day
        }

        return $this->total_study_hours ?: $this->course_details['duration_hours'] ?? 0;
    }

    /**
     * Get certificate grade based on score
     */
    public function getGradeAttribute()
    {
        $score = $this->final_score;

        if ($score >= 95) return 'Xuất sắc';
        if ($score >= 85) return 'Giỏi';
        if ($score >= 75) return 'Khá';
        if ($score >= 65) return 'Trung bình';

        return 'Đạt';
    }

    /**
     * Increment download count
     */
    public function incrementDownload()
    {
        $this->increment('download_count');
        $this->update(['last_downloaded_at' => now()]);
    }

    /**
     * Revoke certificate
     */
    public function revoke($reason = null)
    {
        $this->update([
            'status' => 'revoked',
            'description' => $reason ? "Revoked: {$reason}" : 'Certificate revoked'
        ]);
    }

    /**
     * Check if certificate can be issued for enrollment
     */
    public static function canIssueFor(Enrollment $enrollment)
    {
        // Check if already has certificate
        if (static::where('enrollment_id', $enrollment->id)->exists()) {
            return false;
        }

        // Check if course is completed
        return $enrollment->progress_percentage >= 100 &&
            $enrollment->status === 'active';
    }
}
