<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if(!Auth::check()){
            return redirect('/login')->with('error', 'Vui lòng đăng nhập để tiếp tục.');
        } $user = Auth::user();

        // Ví dụ: kiểm tra route prefix để đảm bảo quyền truy cập
        if ($user->role == User::ROLE_ADMIN && !$request->is('admin/*')) {
            return redirect('/admin/concept-category');
        }

        if ($user->role === User::ROLE_STAFF && !$request->is('staff/*')) {
            return redirect('/staff/work-schedule');
        }
        if ($user->role === User::ROLE_CLIENT && !$request->is('clients/*')) {
            return redirect('/clients/home');
        }
        return $next($request);
    }
}
