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
            'content' => 'nullable|string',
            'summary' => 'nullable|string',
            'video_url' => 'nullable|url',
            'video_duration' => 'nullable|string',
            'video_size' => 'nullable|integer',
            'is_preview' => 'boolean',
            'materials.*' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        // Tự động generate slug từ title
        $validated['slug'] = $this->generateUniqueSlug($validated['title']);

        // Tự động xác định type dựa trên nội dung
        $validated['type'] = $this->determineType($validated);

        // Tự động gán sort_order
        $validated['sort_order'] = $this->getNextSortOrder($section);

        $lesson = $section->lessons()->create(array_merge($validated, ['course_id' => $course->id]));

        if ($request->hasFile('materials')) {
            foreach ($request->file('materials') as $file) {
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

        return redirect()->route('admin.courses.edit', $course)->with('success', 'Bài học đã được tạo.')->with('active_tab', 'curriculum');
    }

    public function edit(Course $course, CourseSection $section, Lesson $lesson)
    {
        return view('admin.courses.lessons.edit', compact('course', 'section', 'lesson'));
    }

    public function update(Request $request, Course $course, CourseSection $section, Lesson $lesson)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'summary' => 'nullable|string',
            'video_url' => 'nullable|url',
            'video_duration' => 'nullable|string',
            'video_size' => 'nullable|integer',
            'is_preview' => 'boolean',
            'materials.*' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        // Cập nhật slug nếu title thay đổi
        if ($validated['title'] !== $lesson->title) {
            $validated['slug'] = $this->generateUniqueSlug($validated['title'], $lesson->id);
        }

        // Tự động xác định type dựa trên nội dung
        $validated['type'] = $this->determineType($validated);

        $lesson->update($validated);

        if ($request->hasFile('materials')) {
            foreach ($request->file('materials') as $file) {
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

        return redirect()->route('admin.courses.edit', $course)->with('success', 'Bài học đã được cập nhật.')->with('active_tab', 'curriculum');
    }

    public function destroy(Course $course, CourseSection $section, Lesson $lesson)
    {
        foreach ($lesson->materials as $material) {
            Storage::disk('public')->delete($material->file_path);
        }
        $lesson->delete();
        return redirect()->route('admin.courses.edit', $course)->with('success', 'Bài học đã được xóa.')->with('active_tab', 'curriculum');
    }

    public function generatePdf(Course $course, CourseSection $section, Lesson $lesson)
    {
        $pdf = Pdf::loadView('admin.courses.lessons.pdf', compact('lesson'));
        return $pdf->download('lesson_' . $lesson->slug . '.pdf');
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
        $hasContent = !empty($data['content']);

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
