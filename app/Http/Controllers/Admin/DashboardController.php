<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
   public function index(Request $request) {
    $dateFrom = $request->input('date_from');
    $dateTo = $request->input('date_to');

    // Khởi tạo query cho bảng Order
    $queryOrder = \App\Models\Order::query();
    $queryUser = \App\Models\User::where('role', 'customer');

    // Lọc theo ngày nếu có chọn
    if ($dateFrom && $dateTo) {
        $start = \Carbon\Carbon::parse($dateFrom)->startOfDay();
        $end = \Carbon\Carbon::parse($dateTo)->endOfDay();
        $queryOrder->whereBetween('created_at', [$start, $end]);
        $queryUser->whereBetween('created_at', [$start, $end]);
    }

    // CHỈ TÍNH DOANH THU CỦA ĐƠN HÀNG "COMPLETE"
    $totalRevenue = $queryOrder->where('status', 'completed')->sum('total_amount');

    $totalCustomers = $queryUser->count();
    $totalProducts = \App\Models\Product::count();

    $bestSellers = \App\Models\Product::take(4)->get()->map(function($p) {
        $p->total_sold = rand(10, 100); 
        return $p;
    });

    return view('admin.dashboard', compact('totalRevenue', 'totalCustomers', 'totalProducts', 'bestSellers'));
}
}