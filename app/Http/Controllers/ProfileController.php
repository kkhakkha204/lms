<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function show(Request $request)
    {
        $user = Auth::user();

        // Lấy thống kê của user
        $stats = [
            'total_enrollments' => $user->enrollments()->count(),
            'completed_courses' => $user->enrollments()->where('progress_percentage', 100)->count(),
            'total_certificates' => $user->certificates()->where('status', 'active')->count(),
            'total_reviews' => $user->reviews()->count(),
        ];

        return view('profile.show', compact('user', 'stats'));
    }

    /**
     * Show the form for editing the user's profile.
     */
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Kiểm tra nếu đang update password
        if ($request->has('current_password')) {
            return $this->updatePassword($request);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar && Storage::disk('public')->exists('avatars/' . $user->avatar)) {
                Storage::disk('public')->delete('avatars/' . $user->avatar);
            }

            // Create avatars directory if not exists
            if (!Storage::disk('public')->exists('avatars')) {
                Storage::disk('public')->makeDirectory('avatars');
            }

            $avatarName = time() . '_' . $user->id . '.' . $request->avatar->extension();

            // Store file in public/avatars directory
            $path = $request->avatar->storeAs('avatars', $avatarName, 'public');

            // Only store filename, not full path
            $validated['avatar'] = $avatarName;

            // Debug log
            \Log::info('Avatar uploaded', [
                'user_id' => $user->id,
                'filename' => $avatarName,
                'path' => $path,
                'full_path' => storage_path('app/public/avatars/' . $avatarName),
                'exists' => file_exists(storage_path('app/public/avatars/' . $avatarName))
            ]);
        }

        // Update user
        $user->fill($validated);

        // Reset email verification if email changed
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Hồ sơ đã được cập nhật thành công.');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('profile.edit')->with('success', 'Mật khẩu đã được thay đổi thành công.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = Auth::user();

        // Delete avatar file
        if ($user->avatar && Storage::disk('public')->exists('avatars/' . $user->avatar)) {
            Storage::disk('public')->delete('avatars/' . $user->avatar);
        }

        Auth::logout();

        // Soft delete user (nếu có soft delete) hoặc hard delete
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Tài khoản đã được xóa thành công.');
    }

    /**
     * Upload and update avatar via AJAX
     */
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $user = Auth::user();

        // Delete old avatar if exists
        if ($user->avatar && Storage::disk('public')->exists('avatars/' . $user->avatar)) {
            Storage::disk('public')->delete('avatars/' . $user->avatar);
        }

        // Create avatars directory if not exists
        if (!Storage::disk('public')->exists('avatars')) {
            Storage::disk('public')->makeDirectory('avatars');
        }

        // Store new avatar
        $avatarName = time() . '_' . $user->id . '.' . $request->avatar->extension();
        $path = $request->avatar->storeAs('avatars', $avatarName, 'public');

        // Update user
        $user->update(['avatar' => $avatarName]);

        // Get fresh user data with new avatar URL
        $user = $user->fresh();

        \Log::info('Avatar updated via AJAX', [
            'user_id' => $user->id,
            'filename' => $avatarName,
            'avatar_url' => $user->avatar_url,
            'file_exists' => Storage::disk('public')->exists('avatars/' . $avatarName)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Avatar đã được cập nhật thành công.',
            'avatar_url' => $user->avatar_url,
            'filename' => $avatarName
        ]);
    }

    /**
     * Remove user's avatar
     */
    public function removeAvatar(Request $request)
    {
        $user = Auth::user();

        // Delete avatar file
        if ($user->avatar && Storage::disk('public')->exists('avatars/' . $user->avatar)) {
            Storage::disk('public')->delete('avatars/' . $user->avatar);
        }

        // Remove avatar from database
        $user->update(['avatar' => null]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Avatar đã được xóa thành công.',
                'avatar_url' => $user->fresh()->avatar_url
            ]);
        }

        return redirect()->route('profile.edit')->with('success', 'Avatar đã được xóa thành công.');
    }

    /**
     * Get user profile data for API
     */
    public function getProfile()
    {
        $user = Auth::user();

        return response()->json([
            'user' => $user->only(['id', 'name', 'email', 'phone', 'bio', 'avatar']),
            'avatar_url' => $user->avatar_url,
            'stats' => [
                'total_enrollments' => $user->enrollments()->count(),
                'completed_courses' => $user->enrollments()->where('progress_percentage', 100)->count(),
                'total_certificates' => $user->certificates()->where('status', 'active')->count(),
                'total_reviews' => $user->reviews()->count(),
                'member_since' => $user->created_at->format('M Y'),
            ]
        ]);
    }
}
