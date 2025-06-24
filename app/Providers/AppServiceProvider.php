<?php

namespace App\Providers;

use App\Services\ChatBotService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\CourseReview;
use App\Observers\CourseReviewObserver;
use App\Policies\CourseReviewPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->singleton(ChatBotService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register model observers
        CourseReview::observe(CourseReviewObserver::class);

        // Register policies
        Gate::policy(CourseReview::class, CourseReviewPolicy::class);

        // Additional gates for course review functionality
        Gate::define('review-course', function ($user, $course) {
            return app(CourseReviewPolicy::class)->create($user, $course);
        });

        Gate::define('moderate-reviews', function ($user) {
            return app(CourseReviewPolicy::class)->moderate($user);
        });
    }
}
