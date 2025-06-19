<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseSection;
use App\Models\Lesson;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'slug' => 'required|string|unique:lessons,slug',
            'content' => 'nullable|string',
            'summary' => 'nullable|string',
            'video_url' => 'nullable|url',
            'video_duration' => 'nullable|string',
            'video_size' => 'nullable|integer',
            'type' => 'required|in:video,text,mixed',
            'is_preview' => 'boolean',
            'sort_order' => 'required|integer|min:0',
            'materials.*' => 'nullable|file|mimes:pdf|max:10240',
        ]);

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

        return redirect()->route('admin.courses.edit', $course)->with('success', 'Bài học đã được tạo.');
    }

    public function edit(Course $course, CourseSection $section, Lesson $lesson)
    {
        return view('admin.courses.lessons.edit', compact('course', 'section', 'lesson'));
    }

    public function update(Request $request, Course $course, CourseSection $section, Lesson $lesson)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:lessons,slug,' . $lesson->id,
            'content' => 'nullable|string',
            'summary' => 'nullable|string',
            'video_url' => 'nullable|url',
            'video_duration' => 'nullable|string',
            'video_size' => 'nullable|integer',
            'type' => 'required|in:video,text,mixed',
            'is_preview' => 'boolean',
            'sort_order' => 'required|integer|min:0',
            'materials.*' => 'nullable|file|mimes:pdf|max:10240',
        ]);

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

        return redirect()->route('admin.courses.edit', $course)->with('success', 'Bài học đã được cập nhật.');
    }

    public function destroy(Course $course, CourseSection $section, Lesson $lesson)
    {
        foreach ($lesson->materials as $material) {
            Storage::disk('public')->delete($material->file_path);
        }
        $lesson->delete();
        return redirect()->route('admin.courses.edit', $course)->with('success', 'Bài học đã được xóa.');
    }

    public function generatePdf(Course $course, CourseSection $section, Lesson $lesson)
    {
        $pdf = Pdf::loadView('admin.courses.lessons.pdf', compact('lesson'));
        return $pdf->download('lesson_' . $lesson->slug . '.pdf');
    }
}
