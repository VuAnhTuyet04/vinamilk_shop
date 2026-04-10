<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Hiển thị trang đăng nhập
    public function showLogin() { return view('auth.login'); }

    // Xử lý đăng nhập
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // Kiểm tra role theo đúng DB của bạn (admin hoặc customer)
            if (Auth::user()->role == 'admin') {
                return redirect()->intended('/admin/dashboard');
            }
            return redirect()->intended('/');
        }

        return back()->withErrors(['email' => 'Email hoặc mật khẩu không đúng.']);
    }

    public function showRegister() {
    return view('auth.register'); 
}
    // Xử lý đăng ký
    public function register(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'phone' => 'required',
            'address' => 'required'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'role' => 'customer' // Mặc định là customer theo DB của bạn
        ]);

        return redirect()->route('login')->with('success', 'Đăng ký thành công!');
    }

    public function logout() {
        Auth::logout();
        return redirect('/');
    }
    public function profile() {
    $user = Auth::user();
    // Lấy đơn hàng từ bảng orders (đã xử lý lỗi thiếu cột updated_at trước đó)
    $orders = \App\Models\Order::where('user_id', $user->id)->orderBy('id', 'desc')->get();
    
    return view('client.profile', compact('user', 'orders'));
}
public function updateProfile(Request $request) {
    // Lấy ID người dùng hiện tại
    $userId = Auth::id();
    
    // Tìm model User chính xác từ DB
    $user = \App\Models\User::find($userId);

    $user->update([
        'name' => $request->name,
        'email' => $request->email,
    ]);

    return redirect()->back()->with('success', 'Cập nhật thông tin thành công!');
}
}
