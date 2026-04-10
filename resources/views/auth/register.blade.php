@extends('layouts.client')

@section('content')
<div style="max-width: 500px; margin: 50px auto; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
    <h2 style="text-align: center; color: #ee4d2d;">ĐĂNG KÝ TÀI KHOẢN</h2>
    
    <form action="{{ route('register') }}" method="POST">
        @csrf
        
        <div style="margin-bottom: 15px;">
            <label>Họ và tên:</label>
            <input type="text" name="name" class="form-control" style="width: 100%; padding: 8px;" required>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" style="width: 100%; padding: 8px;" required>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Số điện thoại:</label>
            <input type="text" name="phone" class="form-control" style="width: 100%; padding: 8px;" required>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Địa chỉ:</label>
            <textarea name="address" class="form-control" style="width: 100%; padding: 8px;" required></textarea>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Mật khẩu:</label>
            <input type="password" name="password" class="form-control" style="width: 100%; padding: 8px;" required>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Xác nhận mật khẩu:</label>
            <input type="password" name="password_confirmation" class="form-control" style="width: 100%; padding: 8px;" required>
        </div>

        <button type="submit" style="width: 100%; padding: 10px; background: #ee4d2d; color: #fff; border: none; cursor: pointer; font-weight: bold;">
            ĐĂNG KÝ NGAY
        </button>
        
        <p style="text-align: center; margin-top: 15px;">
            Đã có tài khoản? <a href="{{ route('login') }}" style="color: #008d81;">Đăng nhập</a>
        </p>
    </form>
</div>
@endsection