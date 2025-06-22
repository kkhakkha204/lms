<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\CustomResetPasswordNotification;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Billable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'bio',
        'avatar',
        'role',
        'is_active',
        'last_login_at',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'is_active' => 'boolean',
        'role' => 'string',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPasswordNotification($token));
    }

    /**
     * Get the user's full avatar URL
     *
     * @return string
     */
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            // Nếu avatar là URL đầy đủ thì trả về luôn
            if (str_starts_with($this->avatar, 'http')) {
                return $this->avatar;
            }

            // Check if file exists in storage
            $avatarPath = 'avatars/' . $this->avatar;

            if (\Storage::disk('public')->exists($avatarPath)) {
                return asset('storage/' . $avatarPath);
            }

            // If file doesn't exist, log and fall back to default
            \Log::warning('Avatar file not found', [
                'user_id' => $this->id,
                'avatar' => $this->avatar,
                'path' => $avatarPath,
                'full_path' => storage_path('app/public/' . $avatarPath)
            ]);
        }

        // Avatar mặc định sử dụng service online
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=3B82F6&color=fff&size=128';
    }

    /**
     * Check if user has a custom avatar
     *
     * @return bool
     */
    public function getHasCustomAvatarAttribute()
    {
        return !empty($this->avatar) && \Storage::disk('public')->exists('avatars/' . $this->avatar);
    }

    /**
     * Get avatar file size in bytes
     *
     * @return int|null
     */
    public function getAvatarSizeAttribute()
    {
        if ($this->avatar && \Storage::disk('public')->exists('avatars/' . $this->avatar)) {
            return \Storage::disk('public')->size('avatars/' . $this->avatar);
        }
        return null;
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'student_id');
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'instructor_id');
    }

    public function progress()
    {
        return $this->hasMany(StudentProgress::class, 'student_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'student_id');
    }

    public function reviews()
    {
        return $this->hasMany(CourseReview::class, 'student_id');
    }
    public function certificates()
    {
        return $this->hasMany(Certificate::class, 'student_id');
    }
}
