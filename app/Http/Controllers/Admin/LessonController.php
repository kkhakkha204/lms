<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseSection;
use App\Models\Lesson;
use App\Models\Quiz;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LessonController extends Controller
{
    public function create(Course $course, CourseSection $section)
    {
        return view('admin.courses.lessons.create', compact('course', 'section'));
    }

    public function store(Request $request, Course $course, CourseSection $section)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string', // Allow HTML content from TinyMCE
            'summary' => 'nullable|string|max:1000',
            'video_url' => 'nullable|url',
            'video_duration' => 'nullable|string|max:20',
            'video_size' => 'nullable|integer|min:0',
            'is_preview' => 'boolean',
            'materials.*' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        // Sanitize and clean HTML content
        $validated['content'] = $this->sanitizeHtmlContent($validated['content'] ?? '');

        // Tự động generate slug từ title
        $validated['slug'] = $this->generateUniqueSlug($validated['title']);

        // Tự động xác định type dựa trên nội dung
        $validated['type'] = $this->determineType($validated);

        // Tự động gán sort_order
        $validated['sort_order'] = $this->getNextSortOrder($section);

        $lesson = $section->lessons()->create(array_merge($validated, ['course_id' => $course->id]));

        // Handle file uploads
        if ($request->hasFile('materials')) {
            $this->handleMaterialUploads($request->file('materials'), $lesson);
        }

        return redirect()->route('admin.courses.edit', $course)
            ->with('success', 'Bài học đã được tạo.')
            ->with('active_tab', 'curriculum');
    }

    public function edit(Course $course, CourseSection $section, Lesson $lesson)
    {
        return view('admin.courses.lessons.edit', compact('course', 'section', 'lesson'));
    }

    public function update(Request $request, Course $course, CourseSection $section, Lesson $lesson)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string', // Allow HTML content from TinyMCE
            'summary' => 'nullable|string|max:1000',
            'video_url' => 'nullable|url',
            'video_duration' => 'nullable|string|max:20',
            'video_size' => 'nullable|integer|min:0',
            'is_preview' => 'boolean',
            'materials.*' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        // Sanitize and clean HTML content
        $validated['content'] = $this->sanitizeHtmlContent($validated['content'] ?? '');

        // Cập nhật slug nếu title thay đổi
        if ($validated['title'] !== $lesson->title) {
            $validated['slug'] = $this->generateUniqueSlug($validated['title'], $lesson->id);
        }

        // Tự động xác định type dựa trên nội dung
        $validated['type'] = $this->determineType($validated);

        $lesson->update($validated);

        // Handle new file uploads
        if ($request->hasFile('materials')) {
            $this->handleMaterialUploads($request->file('materials'), $lesson);
        }

        return redirect()->route('admin.courses.edit', $course)
            ->with('success', 'Bài học đã được cập nhật.')
            ->with('active_tab', 'curriculum');
    }

    public function show(Lesson $lesson)
    {
        // Load relationships for better performance
        $lesson->load(['course.sections.lessons', 'materials', 'section']);

        return view('lessons.show', compact('lesson'));
    }

    public function destroy(Course $course, CourseSection $section, Lesson $lesson)
    {
        // Delete all associated materials
        foreach ($lesson->materials as $material) {
            Storage::disk('public')->delete($material->file_path);
        }

        $lesson->delete();

        return redirect()->route('admin.courses.edit', $course)
            ->with('success', 'Bài học đã được xóa.')
            ->with('active_tab', 'curriculum');
    }

    public function generatePdf(Course $course, CourseSection $section, Lesson $lesson)
    {
        $pdf = Pdf::loadView('admin.courses.lessons.pdf', compact('lesson'));
        return $pdf->download('lesson_' . $lesson->slug . '.pdf');
    }

    /**
     * Sanitize HTML content from TinyMCE
     */
    private function sanitizeHtmlContent($content)
    {
        if (empty($content)) {
            return '';
        }

        // List of allowed HTML tags and attributes
        $allowedTags = [
            'p', 'br', 'strong', 'b', 'em', 'i', 'u', 's', 'strike',
            'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
            'ul', 'ol', 'li', 'dl', 'dt', 'dd',
            'blockquote', 'pre', 'code',
            'a', 'img',
            'table', 'thead', 'tbody', 'tr', 'th', 'td',
            'div', 'span',
            'hr'
        ];

        $allowedAttributes = [
            'href', 'title', 'alt', 'src', 'width', 'height',
            'class', 'id', 'style',
            'target', 'rel',
            'colspan', 'rowspan'
        ];

        // Basic HTML purification (you might want to use HTMLPurifier for production)
        $content = strip_tags($content, '<' . implode('><', $allowedTags) . '>');

        // Remove dangerous attributes and scripts
        $content = preg_replace('/\s*on\w+\s*=\s*["\'][^"\']*["\']/i', '', $content);
        $content = preg_replace('/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/mi', '', $content);
        $content = preg_replace('/<style\b[^<]*(?:(?!<\/style>)<[^<]*)*<\/style>/mi', '', $content);

        return $content;
    }

    /**
     * Handle material file uploads
     */
    private function handleMaterialUploads($files, $lesson)
    {
        foreach ($files as $file) {
            $path = $file->store('materials', 'public');
            $lesson->materials()->create([
                'title' => $file->getClientOriginalName(),
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_type' => $file->getClientOriginalExtension(),
                'file_size' => $file->getSize(),
            ]);
        }
    }

    /**
     * Generate unique slug from title
     */
    private function generateUniqueSlug($title, $excludeId = null)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        while (true) {
            $query = Lesson::where('slug', $slug);
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }

            if (!$query->exists()) {
                break;
            }

            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Determine lesson type based on content
     */
    private function determineType($data)
    {
        $hasVideo = !empty($data['video_url']);
        $hasContent = !empty($data['content']) && strlen(strip_tags($data['content'])) > 10;

        if ($hasVideo && $hasContent) {
            return 'mixed';
        } elseif ($hasVideo) {
            return 'video';
        } else {
            return 'text';
        }
    }

    /**
     * Get next sort order for section
     */
    private function getNextSortOrder($section)
    {
        $maxLessonOrder = $section->lessons()->max('sort_order') ?? 0;
        $maxQuizOrder = Quiz::where('section_id', $section->id)->max('sort_order') ?? 0;

        return max($maxLessonOrder, $maxQuizOrder) + 1;
    }
}
