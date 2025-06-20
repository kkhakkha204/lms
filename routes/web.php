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
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\CourseReviewController;
use App\Http\Controllers\LearningController;
use App\Http\Controllers\PaymentController;
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

// Routes công khai cho course listing
Route::get('/courses', [StudentController::class, 'index'])->name('student.courses.index');
Route::get('/courses/{slug}', [StudentController::class, 'showCourse'])->name('student.courses.show');
Route::get('/category/{slug}', [StudentController::class, 'coursesByCategory'])->name('student.courses.category');

// Routes yêu cầu đăng nhập
Route::middleware(['auth'])->group(function () {
    // Dashboard học viên
    Route::get('/student/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');

    // Trang học tập
    Route::get('/student/learn/{courseSlug}/{lessonSlug?}', [StudentController::class, 'learn'])->name('student.learn');

    // Review routes
    Route::prefix('courses/{courseSlug}/review')->name('courses.review.')->group(function () {
        Route::get('/create', [CourseReviewController::class, 'create'])->name('create');
        Route::post('/', [CourseReviewController::class, 'store'])->name('store');
        Route::get('/edit', [CourseReviewController::class, 'edit'])->name('edit');
        Route::put('/', [CourseReviewController::class, 'update'])->name('update');
        Route::delete('/', [CourseReviewController::class, 'destroy'])->name('destroy');
    });

    // AJAX routes cho reviews
    Route::prefix('api/courses/{courseSlug}')->name('api.courses.')->group(function () {
        Route::get('/reviews', [CourseReviewController::class, 'getReviews'])->name('reviews');
        Route::get('/can-review', [CourseReviewController::class, 'canReview'])->name('can-review');
        Route::get('/rating-breakdown', [CourseReviewController::class, 'getRatingBreakdown'])->name('rating-breakdown');
    });

    // Checkout
    Route::get('/checkout/{courseSlug}', [PaymentController::class, 'checkout'])->name('payment.checkout');

    // Payment processing
    Route::post('/payment/create-intent', [PaymentController::class, 'createPaymentIntent'])->name('payment.create-intent');
    Route::post('/payment/confirm', [PaymentController::class, 'confirmPayment'])->name('payment.confirm');

    // Payment result pages
    Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
});
// Thêm vào web.php - Learning Routes
Route::middleware(['auth'])->group(function () {
    // Learning interface
    Route::prefix('learn')->group(function () {
        Route::get('/{courseSlug}', [LearningController::class, 'index'])->name('learning.index');
        Route::get('/{courseSlug}/lesson/{lessonSlug}', [LearningController::class, 'lesson'])->name('learning.lesson');
        Route::get('/{courseSlug}/quiz/{quizSlug}', [LearningController::class, 'quiz'])->name('learning.quiz');
        Route::get('/{courseSlug}/summary', [LearningController::class, 'summary'])->name('learning.summary');
        Route::post('/{courseSlug}/issue-certificate', [LearningController::class, 'issueCertificate'])->name('learning.issue-certificate');
        Route::get('/{courseSlug}/progress', [LearningController::class, 'getProgress'])->name('learning.progress');
    });

    // Material download - PHẢI ĐẶT NGOÀI prefix learn
    Route::get('/material/{materialId}/download', [LearningController::class, 'downloadMaterial'])->name('learning.download-material');

    // API routes for AJAX calls
    Route::prefix('api/learning')->group(function () {
        Route::post('/video-progress', [LearningController::class, 'updateVideoProgress']);
        Route::post('/submit-quiz', [LearningController::class, 'submitQuiz']);
    });
});

// Public certificate verification (không cần auth)
Route::get('/certificates/verify/{code?}', [CertificateController::class, 'verify'])->name('certificates.verify');
Route::post('/certificates/verify-ajax', [CertificateController::class, 'verifyAjax'])->name('certificates.verify-ajax');

// Public certificate download (có thể không cần auth để share)
Route::get('/certificates/download/{code}', [CertificateController::class, 'download'])->name('certificates.download');

// Student certificate routes (cần auth)
Route::middleware(['auth'])->group(function () {
    Route::get('/my-certificates', [CertificateController::class, 'index'])->name('certificates.index');
    Route::get('/certificates/{code}', [CertificateController::class, 'show'])->name('certificates.show');
    Route::post('/certificates/{code}/regenerate', [CertificateController::class, 'regenerate'])->name('certificates.regenerate');
});

// Admin certificate routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/certificates', [CertificateController::class, 'adminIndex'])->name('admin.certificates.index');
    Route::get('/certificates/stats', [CertificateController::class, 'stats'])->name('admin.certificates.stats');
    Route::post('/certificates/issue', [CertificateController::class, 'issue'])->name('admin.certificates.issue');
    Route::post('/certificates/bulk-issue', [CertificateController::class, 'bulkIssue'])->name('admin.certificates.bulk-issue');
    Route::patch('/certificates/{id}/revoke', [CertificateController::class, 'revoke'])->name('admin.certificates.revoke');
});




