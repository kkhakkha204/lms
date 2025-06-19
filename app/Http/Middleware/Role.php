<?php
// 56b3e667911984f28564ae224502585a
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Role
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check() || Auth::user()->role !== $role) {
            return redirect()->route('home')->with('error', 'Không có quyền truy cập.');
        }
        return $next($request);
    }
}
