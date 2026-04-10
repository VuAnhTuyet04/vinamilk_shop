<?php

namespace App\Http\Controllers\Client;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Order; // Đảm bảo bạn đã chạy lệnh: php artisan make:model Order
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = Session::get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            // Kiểm tra giá: nếu có giá giảm thì lấy giá giảm, không thì lấy giá gốc
            $price = ($product->discount_price > 0) ? $product->discount_price : $product->price;
            
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $price,
                "thumbnail" => $product->thumbnail
            ];
        }

        Session::put('cart', $cart);
        return redirect()->route('client.cart')->with('success', 'Đã thêm vào giỏ hàng!');
    }

    public function index()
    {
        $cart = Session::get('cart', []);
        return view('client.cart', compact('cart'));
    }

    public function remove($id)
    {
        $cart = Session::get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Đã xóa sản phẩm!');
    }

    public function update(Request $request)
    {
        if ($request->id && $request->quantity) {
            $cart = Session::get('cart');
            if (isset($cart[$request->id])) {
                $cart[$request->id]["quantity"] = $request->quantity;
                Session::put('cart', $cart);
                return redirect()->back()->with('success', 'Đã cập nhật giỏ hàng!');
            }
        }
    }
// 1. Hàm hiển thị trang Checkout
public function showCheckout() {
    $cart = session()->get('cart', []);
    if(empty($cart)) return redirect()->route('client.cart');
    return view('client.checkout', compact('cart'));
}

public function checkout(Request $request) {
    // 1. Lấy giỏ hàng
    $cart = session()->get('cart', []);
    if(empty($cart)) {
        return redirect()->route('client.cart')->with('error', 'Giỏ hàng trống!');
    }

    // 2. Tính tổng tiền đơn hàng
    $total = 0;
    foreach ($cart as $item) { 
        $total += $item['price'] * $item['quantity']; 
    }

    // 3. Lưu vào Database (Bảng orders)
    // Việc tạo bản ghi ở đây sẽ giúp Dashboard sum('total_amount') nhảy số ngay lập tức
    \App\Models\Order::create([
        'user_id'          => \Illuminate\Support\Facades\Auth::id(),
        'total_amount'     => $total, // Cột này cực kỳ quan trọng để tính doanh thu
        'status'           => 'pending', // Đặt là completed để Dashboard tính là doanh thu thực
        'note'             => $request->note,
        'shipping_address' => $request->address,
        'created_at'       => now(), 
    ]);

    // 4. Xóa giỏ hàng và chuyển hướng
    session()->forget('cart');
    
    return redirect()->route('client.home')->with('success', 'Đặt hàng thành công! Doanh thu đã được cập nhật.');
}
public function cancelOrder($id) {
    // Tìm đơn hàng khớp với ID và đúng của người dùng đang đăng nhập
    $order = \App\Models\Order::where('id', $id)
                ->where('user_id', Auth::id()) 
                ->where('status', 'pending')
                ->first();

    if ($order) {
        $order->status = 'cancelled';
        $order->save(); // Dùng save() sẽ an toàn hơn nếu fillable chưa chuẩn
        return redirect()->back()->with('success', 'Đã hủy đơn hàng thành công!');
    }

    return redirect()->back()->with('error', 'Không tìm thấy đơn hàng hoặc không thể hủy!');
}
}