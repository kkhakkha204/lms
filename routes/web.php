<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\CourseSectionController;
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\MaterialController;
use App\Http\Controllers\Admin\QuizController;
use App\Http\Controllers\Admin\QuizQuestionController;
use App\Http\Controllers\Admin\StatisticsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

// Các route xác thực
Route::middleware('guest')->group(function () {
    // Đăng ký
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Đăng nhập
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Quên mật khẩu
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');

    // Đặt lại mật khẩu
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.store');
});

// Đăng xuất (yêu cầu đã đăng nhập)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/', function () {
    return view('home');
})->name('home');

// Route cho admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/statistics', [StatisticsController::class, 'index'])->name('admin.statistics');

    // Route cho Categories Dashboard
    Route::get('/admin/categories', [CategoryController::class, 'index'])->name('admin.categories.index');
    Route::post('/admin/categories', [CategoryController::class, 'store'])->name('admin.categories.store');
    Route::put('/admin/categories/{category}', [CategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('/admin/categories/{category}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');

    // Additional category routes
    Route::post('/admin/categories/bulk-delete', [CategoryController::class, 'bulkDelete'])->name('admin.categories.bulk-delete');
    Route::post('/admin/categories/update-sort-order', [CategoryController::class, 'updateSortOrder'])->name('admin.categories.update-sort-order');
    Route::post('/admin/categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('admin.categories.toggle-status');

    // Route cho Courses Dashboard
    Route::get('/admin/courses', [CourseController::class, 'index'])->name('admin.courses.index');
    Route::get('/admin/courses/create', [CourseController::class, 'create'])->name('admin.courses.create');
    Route::post('/admin/courses', [CourseController::class, 'store'])->name('admin.courses.store');
    Route::get('/admin/courses/{course}/edit', [CourseController::class, 'edit'])->name('admin.courses.edit');
    Route::put('/admin/courses/{course}', [CourseController::class, 'update'])->name('admin.courses.update');
    Route::delete('/admin/courses/{course}', [CourseController::class, 'destroy'])->name('admin.courses.destroy');
    Route::patch('/admin/courses/{course}/toggle-publish', [CourseController::class, 'togglePublish'])->name('admin.courses.toggle-publish');
    Route::post('/courses/generate-slug', [CourseController::class, 'generateSlug'])->name('admin.courses.generate-slug');
    Route::post('/admin/courses/{course}/sections/reorder', [CourseController::class, 'updateSectionOrder'])->name('admin.courses.sections.reorder');
    Route::post('/admin/courses/{course}/sections/{section}/content/reorder', [CourseController::class, 'updateContentOrder'])->name('admin.courses.sections.content.reorder');

    // Route cho Course Sections
    Route::get('/admin/courses/{course}/sections', [CourseSectionController::class, 'index'])->name('admin.courses.sections.index');
    Route::get('/admin/courses/{course}/sections/create', [CourseSectionController::class, 'create'])->name('admin.courses.sections.create');
    Route::post('/admin/courses/{course}/sections', [CourseSectionController::class, 'store'])->name('admin.courses.sections.store');
    Route::get('/admin/courses/{course}/sections/{section}/edit', [CourseSectionController::class, 'edit'])->name('admin.courses.sections.edit');
    Route::put('/admin/courses/{course}/sections/{section}', [CourseSectionController::class, 'update'])->name('admin.courses.sections.update');
    Route::delete('/admin/courses/{course}/sections/{section}', [CourseSectionController::class, 'destroy'])->name('admin.courses.sections.destroy');
    Route::get('/admin/courses/{course}/sections/{section}/content', [CourseController::class, 'getSectionContent'])->name('admin.courses.sections.content');

    // Route cho Lessons
    Route::get('/admin/courses/{course}/sections/{section}/lessons', [LessonController::class, 'index'])->name('admin.courses.sections.lessons.index');
    Route::get('/admin/courses/{course}/sections/{section}/lessons/create', [LessonController::class, 'create'])->name('admin.courses.sections.lessons.create');
    Route::post('/admin/courses/{course}/sections/{section}/lessons', [LessonController::class, 'store'])->name('admin.courses.sections.lessons.store');
    Route::get('/admin/courses/{course}/sections/{section}/lessons/{lesson}/edit', [LessonController::class, 'edit'])->name('admin.courses.sections.lessons.edit');
    Route::put('/admin/courses/{course}/sections/{section}/lessons/{lesson}', [LessonController::class, 'update'])->name('admin.courses.sections.lessons.update');
    Route::delete('/admin/courses/{course}/sections/{section}/lessons/{lesson}', [LessonController::class, 'destroy'])->name('admin.courses.sections.lessons.destroy');
    Route::get('/admin/courses/{course}/sections/{section}/lessons/{lesson}/pdf', [LessonController::class, 'generatePdf'])->name('admin.courses.sections.lessons.pdf');
    Route::delete('/admin/materials/{material}', [MaterialController::class, 'destroy'])->name('admin.materials.destroy');


    // Route cho Quizzes
    Route::get('/admin/courses/{course}/sections/{section}/quizzes', [QuizController::class, 'index'])->name('admin.courses.sections.quizzes.index');
    Route::get('/admin/courses/{course}/sections/{section}/quizzes/create', [QuizController::class, 'create'])->name('admin.courses.sections.quizzes.create');
    Route::post('/admin/courses/{course}/sections/{section}/quizzes', [QuizController::class, 'store'])->name('admin.courses.sections.quizzes.store');
    Route::get('/admin/courses/{course}/sections/{section}/quizzes/{quiz}/edit', [QuizController::class, 'edit'])->name('admin.courses.sections.quizzes.edit');
    Route::put('/admin/courses/{course}/sections/{section}/quizzes/{quiz}', [QuizController::class, 'update'])->name('admin.courses.sections.quizzes.update');
    Route::delete('/admin/courses/{course}/sections/{section}/quizzes/{quiz}', [QuizController::class, 'destroy'])->name('admin.courses.sections.quizzes.destroy');
    Route::post('/admin/courses/{course}/sections/{section}/quizzes/{quiz}/sort-questions', [QuizController::class, 'sortQuestions'])->name('admin.courses.sections.quizzes.sort-questions');


    // Route cho Quiz Questions
    Route::get('/admin/courses/{course}/sections/{section}/quizzes/{quiz}/questions', [QuizQuestionController::class, 'index'])->name('admin.courses.sections.quizzes.questions.index');
    Route::get('/admin/courses/{course}/sections/{section}/quizzes/{quiz}/questions/create', [QuizQuestionController::class, 'create'])->name('admin.courses.sections.quizzes.questions.create');
    Route::post('/admin/courses/{course}/sections/{section}/quizzes/{quiz}/questions', [QuizQuestionController::class, 'store'])->name('admin.courses.sections.quizzes.questions.store');
    Route::get('/admin/courses/{course}/sections/{section}/quizzes/{quiz}/questions/{question}/edit', [QuizQuestionController::class, 'edit'])->name('admin.courses.sections.quizzes.questions.edit');
    Route::put('/admin/courses/{course}/sections/{section}/quizzes/{quiz}/questions/{question}', [QuizQuestionController::class, 'update'])->name('admin.courses.sections.quizzes.questions.update');
    Route::delete('/admin/courses/{course}/sections/{section}/quizzes/{quiz}/questions/{question}', [QuizQuestionController::class, 'destroy'])->name('admin.courses.sections.quizzes.questions.destroy');
// Route cho sắp xếp lại thứ tự câu hỏi
    Route::post('/reorder', [QuizQuestionController::class, 'reorder'])
        ->name('admin.courses.sections.quizzes.questions.reorder');

    // Route cho nhân bản câu hỏi
    Route::post('/{question}/duplicate', [QuizQuestionController::class, 'duplicate'])
        ->name('admin.courses.sections.quizzes.questions.duplicate');

    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/{user}', [UserController::class, 'show'])->name('admin.users.show');
    Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::post('/admin/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('admin.users.toggle-status');
    Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/admin/users-export', [UserController::class, 'export'])->name('admin.users.export');
});

Route::prefix('student')->middleware(['auth'])->group(function () {
    Route::get('/courses', [StudentController::class, 'index'])->name('student.courses.index');
    Route::get('/courses/{course}', [StudentController::class, 'show'])->name('student.courses.show');
    Route::post('/courses/{course}/enroll', [StudentController::class, 'enroll'])->name('student.courses.enroll');
    Route::get('/courses/{course}/payment', [StudentController::class, 'showPaymentForm'])->name('student.courses.payment.form');
    Route::post('/courses/{course}/payment', [StudentController::class, 'processPayment'])->name('student.courses.payment');
    Route::get('/courses/{course}/payment/success', [StudentController::class, 'paymentSuccess'])->name('student.courses.payment.success');
    Route::get('/courses/{course}/learn', [StudentController::class, 'learn'])->name('student.courses.learn');
    Route::post('/courses/{course}/progress/lesson/{lesson}', [StudentController::class, 'updateLessonProgress'])->name('student.progress.lesson');
    Route::post('/courses/{course}/progress/quiz/{quiz}', [StudentController::class, 'submitQuiz'])->name('student.progress.quiz');
});
