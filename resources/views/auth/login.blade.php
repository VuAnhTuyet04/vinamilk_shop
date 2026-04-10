@extends('layouts.client')

@section('content')
<div style="max-width: 400px; margin: 50px auto; padding: 30px; background: #fff; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
    <h2 style="text-align: center; color: #008d81; margin-bottom: 20px;">ĐĂNG NHẬP</h2>

    @if($errors->any())
        <div style="color: red; margin-bottom: 15px;">{{ $errors->first() }}</div>
    @endif

    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div style="margin-bottom: 15px;">
            <label>Email:</label>
            <input type="email" name="email" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;" required>
        </div>

            <div style="position: relative; margin-bottom: 15px;">
            <label>Mật khẩu:</label>
            <input type="password" id="password_input" name="password" class="form-control" placeholder="Nhập mật khẩu">
            <button type="button" id="btn_show_pass" style="position: absolute; right: 5px; top: 32px; border: none; background: none; cursor: pointer;">
                👁️
            </button>
        </div>

        <button type="submit" style="width: 100%; padding: 12px; background: #008d81; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">
            ĐĂNG NHẬP
        </button>

        <p style="text-align: center; margin-top: 15px;">
            Chưa có tài khoản? <a href="{{ route('register') }}" style="color: #ee4d2d; text-decoration: none;">Đăng ký ngay</a>
        </p>
    </form>
</div>
<script>
    document.getElementById('btn_show_pass').addEventListener('click', function() {
        const passwordField = document.getElementById('password_input');
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
        
        // Đổi icon con mắt
        this.textContent = type === 'password' ? '👁️' : '🙈';
    });
</script>
@endsection