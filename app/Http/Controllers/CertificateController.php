<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Services\CertificateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    protected $certificateService;

    public function __construct(CertificateService $certificateService)
    {
        $this->certificateService = $certificateService;
    }

    /**
     * Student certificates dashboard
     */
    public function index()
    {
        $certificates = Certificate::where('student_id', Auth::id())
            ->with(['course', 'course.instructor'])
            ->orderBy('issued_at', 'desc')
            ->paginate(10);

        // Debug: Check if certificates exist
        \Log::info('Certificates count: ' . $certificates->count());
        \Log::info('User ID: ' . Auth::id());

        return view('student.certificates.index', compact('certificates'));
    }

    /**
     * Show specific certificate
     */
    public function show($code)
    {
        $certificate = Certificate::where('certificate_code', $code)
            ->with(['student', 'course', 'course.instructor'])
            ->firstOrFail();

        // Check if user owns this certificate or is admin
        if (Auth::id() !== $certificate->student_id && !Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized access to certificate');
        }

        return view('student.certificates.show', compact('certificate'));
    }

    /**
     * Download certificate PDF
     */
    public function download($code)
    {
        $certificate = $this->certificateService->downloadCertificate($code);

        if (!$certificate) {
            abort(404, 'Certificate not found or invalid');
        }

        // Check if user owns this certificate or is admin
        if (Auth::check() && Auth::id() !== $certificate->student_id && !Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized access to certificate');
        }

        $filename = $this->certificateService->generateCertificateFilename($certificate);

        return Storage::disk('public')->download($certificate->pdf_path, $filename);
    }

    /**
     * Public certificate verification
     */
    public function verify($code = null)
    {
        $certificate = null;
        $verified = false;

        if ($code) {
            $certificate = $this->certificateService->verifyCertificate($code);
            $verified = $certificate !== null;
        }

        return view('certificates.verify', compact('certificate', 'verified', 'code'));
    }

    /**
     * AJAX certificate verification
     */
    public function verifyAjax(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50'
        ]);

        $certificate = $this->certificateService->verifyCertificate($request->code);

        if ($certificate) {
            return response()->json([
                'verified' => true,
                'certificate' => [
                    'certificate_number' => $certificate->certificate_number,
                    'student_name' => $certificate->student->name,
                    'course_title' => $certificate->course->title,
                    'instructor_name' => $certificate->instructor_name,
                    'issued_date' => $certificate->formatted_issued_date,
                    'completed_date' => $certificate->formatted_completed_date,
                    'final_score' => $certificate->final_score,
                    'grade' => $certificate->grade,
                    'status' => $certificate->status,
                ]
            ]);
        }

        return response()->json([
            'verified' => false,
            'message' => 'Certificate not found or invalid'
        ]);
    }

    /**
     * Regenerate certificate PDF
     */
    public function regenerate($code)
    {
        $certificate = Certificate::where('certificate_code', $code)
            ->firstOrFail();

        // Check permissions
        if (Auth::id() !== $certificate->student_id && !Auth::user()->hasRole('admin')) {
            abort(403);
        }

        $this->certificateService->generateCertificatePDF($certificate);

        return redirect()->back()->with('success', 'Certificate regenerated successfully');
    }

    /**
     * Manual certificate issuance (Admin only)
     */
    public function issue(Request $request)
    {
        $this->authorize('admin');

        $request->validate([
            'enrollment_id' => 'required|exists:enrollments,id'
        ]);

        $enrollment = Enrollment::findOrFail($request->enrollment_id);

        if (!Certificate::canIssueFor($enrollment)) {
            return back()->with('error', 'Certificate cannot be issued for this enrollment');
        }

        $certificate = $this->certificateService->autoIssueCertificate($enrollment);

        return back()->with('success', 'Certificate issued successfully: ' . $certificate->certificate_number);
    }

    /**
     * Revoke certificate (Admin only)
     */
    public function revoke(Request $request, $id)
    {
        $this->authorize('admin');

        $request->validate([
            'reason' => 'nullable|string|max:255'
        ]);

        $certificate = Certificate::findOrFail($id);
        $certificate->revoke($request->reason);

        return back()->with('success', 'Certificate revoked successfully');
    }

    /**
     * Bulk issue certificates (Admin only)
     */
    public function bulkIssue()
    {
        $this->authorize('admin');

        $issued = $this->certificateService->bulkIssueCertificates();

        return back()->with('success', "Successfully issued {$issued} certificates");
    }

    /**
     * Certificate statistics (Admin only)
     */
    public function stats()
    {
        $this->authorize('admin');

        $stats = $this->certificateService->getCertificateStats();

        return view('admin.certificates.stats', compact('stats'));
    }

    /**
     * Admin certificates list
     */
    public function adminIndex(Request $request)
    {
        $this->authorize('admin');

        $query = Certificate::with(['student', 'course']);

        // Search filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('certificate_number', 'like', "%{$search}%")
                    ->orWhere('certificate_code', 'like', "%{$search}%")
                    ->orWhereHas('student', function($sq) use ($search) {
                        $sq->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('course', function($cq) use ($search) {
                        $cq->where('title', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        $certificates = $query->orderBy('issued_at', 'desc')->paginate(20);

        return view('admin.certificates.index', compact('certificates'));
    }
}
