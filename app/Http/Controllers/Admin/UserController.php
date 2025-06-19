<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of users with search and filtering
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Tìm kiếm theo tên hoặc email
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        // Lọc theo vai trò
        if ($request->filled('role')) {
            $query->where('role', $request->get('role'));
        }

        // Lọc theo trạng thái
        if ($request->filled('status')) {
            $is_active = $request->get('status') === 'active' ? 1 : 0;
            $query->where('is_active', $is_active);
        }

        // Sắp xếp theo thời gian tạo mới nhất
        $users = $query->orderBy('created_at', 'desc')->paginate(20);

        // Thống kê người dùng
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('is_active', true)->count(),
            'inactive_users' => User::where('is_active', false)->count(),
            'admin_users' => User::where('role', 'admin')->count(),
            'student_users' => User::where('role', 'student')->count(),
            'verified_users' => User::whereNotNull('email_verified_at')->count(),
            'unverified_users' => User::whereNull('email_verified_at')->count(),
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    /**
     * Show user details
     */
    public function show(User $user)
    {
        // Load relationships để hiển thị thêm thông tin
        $user->load(['enrollments.course', 'payments', 'reviews']);

        $userStats = [
            'total_courses' => $user->enrollments->count(),
            'total_payments' => $user->payments->sum('amount'),
            'total_reviews' => $user->reviews->count(),
            'avg_rating' => $user->reviews->avg('rating'),
        ];

        return view('admin.users.show', compact('user', 'userStats'));
    }

    /**
     * Toggle user active status
     */
    public function toggleStatus(User $user)
    {
        try {
            // Không cho phép tự khóa tài khoản của mình
            if ($user->id === auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn không thể khóa tài khoản của chính mình!'
                ]);
            }

            $user->is_active = !$user->is_active;
            $user->save();

            $status = $user->is_active ? 'mở khóa' : 'khóa';

            return response()->json([
                'success' => true,
                'message' => "Đã {$status} tài khoản thành công!",
                'new_status' => $user->is_active
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra, vui lòng thử lại!'
            ]);
        }
    }

    /**
     * Delete user
     */
    public function destroy(User $user)
    {
        try {
            // Không cho phép xóa tài khoản của mình
            if ($user->id === auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn không thể xóa tài khoản của chính mình!'
                ]);
            }

            // Kiểm tra xem user có dữ liệu liên quan không
            $hasRelatedData = $user->enrollments()->exists() ||
                $user->payments()->exists() ||
                $user->reviews()->exists();

            if ($hasRelatedData) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể xóa người dùng này vì có dữ liệu liên quan (khóa học đã đăng ký, thanh toán, đánh giá)!'
                ]);
            }

            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'Đã xóa người dùng thành công!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra, vui lòng thử lại!'
            ]);
        }
    }

    /**
     * Show edit form
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update user
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:1000',
            'role' => 'required|in:admin,student',
            'is_active' => 'boolean',
            'password' => 'nullable|min:8|confirmed',
        ]);

        try {
            $data = $request->only(['name', 'email', 'phone', 'bio', 'role']);
            $data['is_active'] = $request->has('is_active');

            // Chỉ cập nhật mật khẩu nếu có nhập
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);

            return redirect()->route('admin.users.index')
                ->with('success', 'Cập nhật thông tin người dùng thành công!');

        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại!')
                ->withInput();
        }
    }

    /**
     * Export users data
     */
    public function export(Request $request)
    {
        $query = User::query();

        // Áp dụng các bộ lọc tương tự như index
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->get('role'));
        }

        if ($request->filled('status')) {
            $is_active = $request->get('status') === 'active' ? 1 : 0;
            $query->where('is_active', $is_active);
        }

        $users = $query->orderBy('created_at', 'desc')->get();

        $filename = 'users_export_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($users) {
            $file = fopen('php://output', 'w');

            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Header
            fputcsv($file, [
                'ID', 'Tên', 'Email', 'Vai trò', 'Số điện thoại',
                'Trạng thái', 'Xác thực email', 'Ngày tạo', 'Đăng nhập lần cuối'
            ]);

            // Data
            foreach ($users as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->role === 'admin' ? 'Quản trị viên' : 'Học viên',
                    $user->phone ?? 'Không có',
                    $user->is_active ? 'Hoạt động' : 'Bị khóa',
                    $user->email_verified_at ? 'Đã xác thực' : 'Chưa xác thực',
                    $user->created_at->format('d/m/Y H:i'),
                    $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : 'Chưa đăng nhập'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
