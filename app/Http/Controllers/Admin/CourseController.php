<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\CourseSection;
use App\Models\Lesson;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with(['category', 'instructor'])
            ->withCount('enrollments')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->get();
        return view('admin.courses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:courses,slug',
            'description' => 'required|string|min:50',
            'short_description' => 'required|string|max:500',
            'price' => 'required|numeric|min:0|max:99999999',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'is_free' => 'boolean',
            'level' => 'required|in:beginner,intermediate,advanced',
            'language' => 'required|string|max:10',
            'duration_hours' => 'required|integer|min:1|max:1000',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'preview_video' => 'nullable|url',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'tags' => 'nullable|string',
        ]);

        // Auto-generate slug if empty
        if (empty($validated['slug'])) {
            $validated['slug'] = $this->generateUniqueSlug($validated['title']);
        }

        // Handle free course logic
        if ($request->boolean('is_free')) {
            $validated['price'] = 0;
            $validated['discount_price'] = null;
        }

        // Process thumbnail
        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $this->processThumbnail($request->file('thumbnail'));
        }

        // Process tags
        if (!empty($validated['tags'])) {
            $validated['tags'] = array_map('trim', explode(',', $validated['tags']));
        } else {
            $validated['tags'] = [];
        }

        // Auto-generate meta fields if empty
        if (empty($validated['meta_title'])) {
            $validated['meta_title'] = Str::limit($validated['title'], 60);
        }
        if (empty($validated['meta_description'])) {
            $validated['meta_description'] = Str::limit(strip_tags($validated['short_description']), 160);
        }

        $validated['instructor_id'] = auth()->id();
        $validated['status'] = 'draft';
        $validated['enrolled_count'] = 0;
        $validated['rating'] = 0;
        $validated['reviews_count'] = 0;
        $validated['views_count'] = 0;

        // Get primary category (first one)
        $validated['category_id'] = $validated['categories'][0];

        $course = Course::create($validated);

        // Attach multiple categories if you have a pivot table
        // $course->categories()->attach($validated['categories']);

        return redirect()
            ->route('admin.courses.edit', $course)
            ->with('success', 'Khóa học đã được tạo thành công. Bạn có thể tiếp tục chỉnh sửa hoặc thêm nội dung.');
    }

    public function edit(Course $course)
    {
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();
        return view('admin.courses.edit', compact('course', 'categories'));
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            'title' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                Rule::unique('courses', 'slug')->ignore($course->id)
            ],
            'description' => 'required|string|min:50',
            'short_description' => 'required|string|max:500',
            'price' => 'required|numeric|min:0|max:99999999',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'is_free' => 'boolean',
            'level' => 'required|in:beginner,intermediate,advanced',
            'language' => 'required|string|max:10',
            'duration_hours' => 'required|integer|min:1|max:1000',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'preview_video' => 'nullable|url',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'tags' => 'nullable|string',
        ]);

        // Auto-generate slug if empty
        if (empty($validated['slug'])) {
            $validated['slug'] = $this->generateUniqueSlug($validated['title'], $course->id);
        }

        // Handle free course logic
        if ($request->boolean('is_free')) {
            $validated['price'] = 0;
            $validated['discount_price'] = null;
        }

        // Process thumbnail if uploaded
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($course->thumbnail) {
                Storage::disk('public')->delete($course->thumbnail);
            }
            $validated['thumbnail'] = $this->processThumbnail($request->file('thumbnail'));
        }

        // Process tags
        if (!empty($validated['tags'])) {
            $validated['tags'] = array_map('trim', explode(',', $validated['tags']));
        } else {
            $validated['tags'] = [];
        }

        // Auto-generate meta fields if empty
        if (empty($validated['meta_title'])) {
            $validated['meta_title'] = Str::limit($validated['title'], 60);
        }
        if (empty($validated['meta_description'])) {
            $validated['meta_description'] = Str::limit(strip_tags($validated['short_description']), 160);
        }

        // Get primary category (first one)
        $validated['category_id'] = $validated['categories'][0];

        $course->update($validated);

        // Chuyển sang tab curriculum sau khi cập nhật
        return redirect()
            ->route('admin.courses.edit', $course)
            ->with('success', 'Khóa học đã được cập nhật thành công.')
            ->with('active_tab', 'curriculum');
    }

    public function destroy(Course $course)
    {
        // Check if course has enrollments
        if ($course->enrollments()->count() > 0) {
            return redirect()
                ->route('admin.courses.index')
                ->with('error', 'Không thể xóa khóa học đã có học viên đăng ký.');
        }

        // Delete thumbnail
        if ($course->thumbnail) {
            Storage::disk('public')->delete($course->thumbnail);
        }

        $course->delete();

        return redirect()
            ->route('admin.courses.index')
            ->with('success', 'Khóa học đã được xóa thành công.');
    }

    public function togglePublish(Course $course)
    {
        // Validate course before publishing
        if ($course->status === 'draft') {
            $errors = $this->validateCourseForPublishing($course);
            if (!empty($errors)) {
                return redirect()
                    ->route('admin.courses.edit', $course)
                    ->with('error', 'Không thể xuất bản khóa học: ' . implode(', ', $errors));
            }
        }

        $course->status = $course->status === 'published' ? 'draft' : 'published';
        $course->published_at = $course->status === 'published' ? now() : null;
        $course->save();

        $message = $course->status === 'published'
            ? 'Khóa học đã được xuất bản thành công.'
            : 'Khóa học đã được chuyển về trạng thái nháp.';

        return redirect()
            ->route('admin.courses.edit', $course)
            ->with('success', $message);
    }

    public function generateSlug(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'course_id' => 'nullable|integer|exists:courses,id'
        ]);

        $slug = $this->generateUniqueSlug($request->title, $request->course_id);

        return response()->json(['slug' => $slug]);
    }

    private function processThumbnail($file)
    {
        $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

        // Process image with Intervention Image
        $manager = new ImageManager(new Driver());
        $processedImage = $manager->read($file->getPathname());

        // Resize maintaining aspect ratio
        $processedImage->resize(800, 450, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        // Create thumbnail version
        $thumbnailImage = clone $processedImage;
        $thumbnailImage->resize(300, 200, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        // Save main image
        $storagePath = storage_path('app/public/courses/' . $filename);
        if (!file_exists(dirname($storagePath))) {
            mkdir(dirname($storagePath), 0755, true);
        }
        $processedImage->save($storagePath, 80);

        // Save thumbnail
        $thumbnailPath = storage_path('app/public/courses/thumbnails/' . $filename);
        if (!file_exists(dirname($thumbnailPath))) {
            mkdir(dirname($thumbnailPath), 0755, true);
        }
        $thumbnailImage->save($thumbnailPath, 80);

        return 'courses/' . $filename;
    }

    private function generateUniqueSlug($title, $ignoreId = null)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        while (true) {
            $query = Course::where('slug', $slug);
            if ($ignoreId) {
                $query->where('id', '!=', $ignoreId);
            }

            if (!$query->exists()) {
                break;
            }

            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    private function validateCourseForPublishing(Course $course)
    {
        $errors = [];

        if (!$course->thumbnail) {
            $errors[] = 'Chưa có hình ảnh đại diện';
        }

        if (!$course->description || strlen($course->description) < 50) {
            $errors[] = 'Mô tả quá ngắn (tối thiểu 50 ký tự)';
        }

        if (!$course->short_description) {
            $errors[] = 'Chưa có mô tả ngắn';
        }

        if ($course->sections()->count() === 0) {
            $errors[] = 'Chưa có nội dung bài học';
        }

        if (!$course->is_free && ($course->price <= 0)) {
            $errors[] = 'Khóa học trả phí phải có giá lớn hơn 0';
        }

        return $errors;
    }
    public function getSectionContent(Course $course, CourseSection $section)
    {
        $section->load(['lessons' => function($query) {
            $query->orderBy('sort_order');
        }, 'quizzes' => function($query) {
            $query->orderBy('sort_order');
        }]);

        $lessons = $section->lessons->map(function($lesson) use ($course, $section) {
            return [
                'id' => $lesson->id,
                'title' => $lesson->title,
                'type' => 'lesson',
                'duration_minutes' => $lesson->duration_minutes,
                'is_free' => $lesson->is_free,
                'sort_order' => $lesson->sort_order,
                'edit_url' => route('admin.courses.sections.lessons.edit', [$course, $section, $lesson]),
                'delete_url' => route('admin.courses.sections.lessons.destroy', [$course, $section, $lesson])
            ];
        });

        $quizzes = $section->quizzes->map(function($quiz) use ($course, $section) {
            return [
                'id' => $quiz->id,
                'title' => $quiz->title,
                'type' => 'quiz',
                'questions_count' => $quiz->questions()->count(),
                'time_limit' => $quiz->time_limit,
                'sort_order' => $quiz->sort_order,
                'edit_url' => route('admin.courses.sections.quizzes.edit', [$course, $section, $quiz]),
                'delete_url' => route('admin.courses.sections.quizzes.destroy', [$course, $section, $quiz])
            ];
        });

        // Merge and sort by sort_order
        $content = $lessons->concat($quizzes)->sortBy('sort_order')->values();

        return response()->json([
            'section' => [
                'id' => $section->id,
                'title' => $section->title,
                'description' => $section->description
            ],
            'content' => $content,
            'stats' => [
                'lessons_count' => $lessons->count(),
                'quizzes_count' => $quizzes->count(),
                'total_duration' => $lessons->sum('duration_minutes')
            ]
        ]);
    }
    public function updateSectionOrder(Course $course, Request $request)
    {
        $request->validate([
            'section_ids' => 'required|array',
            'section_ids.*' => 'exists:course_sections,id'
        ]);

        foreach ($request->section_ids as $index => $sectionId) {
            CourseSection::where('id', $sectionId)
                ->where('course_id', $course->id)
                ->update(['sort_order' => $index + 1]);
        }

        return response()->json(['success' => true, 'message' => 'Đã cập nhật thứ tự chương']);
    }

    public function updateContentOrder(Course $course, CourseSection $section, Request $request)
    {
        try {
            $request->validate([
                'items' => 'required|array',
                'items.*.id' => 'required|integer',
                'items.*.type' => 'required|in:lesson,quiz'
            ]);

            // Verify section belongs to course
            if ($section->course_id !== $course->id) {
                return response()->json(['success' => false, 'message' => 'Section không thuộc course này'], 400);
            }

            foreach ($request->items as $index => $item) {
                $sortOrder = $index + 1;

                if ($item['type'] === 'lesson') {
                    // Update lesson
                    \App\Models\Lesson::where('id', $item['id'])
                        ->where('section_id', $section->id)
                        ->update(['sort_order' => $sortOrder]);
                } else {
                    // Update quiz
                    \App\Models\Quiz::where('id', $item['id'])
                        ->where('section_id', $section->id)
                        ->update(['sort_order' => $sortOrder]);
                }
            }

            return response()->json(['success' => true, 'message' => 'Đã cập nhật thứ tự nội dung']);

        } catch (\Exception $e) {
            \Log::error('Error updating content order: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Có lỗi xảy ra: ' . $e->getMessage()], 500);
        }
    }
}
