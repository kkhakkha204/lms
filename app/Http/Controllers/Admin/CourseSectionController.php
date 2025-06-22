<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseSection;
use Illuminate\Http\Request;

class CourseSectionController extends Controller
{
    public function create(Course $course)
    {
        return view('admin.courses.sections.create', compact('course'));
    }

    public function store(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Tự động gán thứ tự sau section cuối cùng
        $maxSortOrder = $course->sections()->max('sort_order') ?? 0;
        $validated['sort_order'] = $maxSortOrder + 1;

        $course->sections()->create($validated);

        return redirect()
            ->route('admin.courses.edit', $course)
            ->with('success', 'Mục đã được tạo thành công.')
            ->with('active_tab', 'curriculum');
    }

    public function edit(Course $course, CourseSection $section)
    {
        return view('admin.courses.sections.edit', compact('course', 'section'));
    }

    public function update(Request $request, Course $course, CourseSection $section)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Giữ nguyên sort_order khi edit, không cho phép thay đổi
        $section->update($validated);

        return redirect()
            ->route('admin.courses.edit', $course)
            ->with('success', 'Mục đã được cập nhật thành công.')
            ->with('active_tab', 'curriculum');
    }

    public function destroy(Course $course, CourseSection $section)
    {
        $section->delete();
        return redirect()
            ->route('admin.courses.edit', $course)
            ->with('success', 'Mục đã được xóa thành công.')
            ->with('active_tab', 'curriculum');
    }
}
