<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
 public function handle(Request $request, Closure $next)
{
    // Kiểm tra nếu đã đăng nhập và email là admin (hoặc dựa trên cột role của bạn)
    if (auth()->check() && (auth()->user()->email == 'admin@vinamilk.com' || auth()->user()->email == 'admin@gmail.com')) {
        return $next($request);
    }

    return redirect('/')->with('error', 'Bạn không có quyền truy cập trang Admin!');
}
}
