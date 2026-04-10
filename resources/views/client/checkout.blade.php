@extends('layouts.client')

@section('content')
<div class="product-detail-container" style="display: block; max-width: 600px; margin: 20px auto; background: #fff; padding: 20px; border-radius: 8px;">
    <h2 style="color: #008d81; border-bottom: 2px solid #eee; padding-bottom: 10px;">THÔNG TIN GIAO HÀNG</h2>
    
    {{-- 1. Sửa action trỏ về route xử lý đặt hàng --}}
    <form action="{{ route('client.process_order') }}" method="POST">
        @csrf
        
        <div style="margin-bottom: 15px;">
            <label>Họ tên khách hàng:</label><br>
            <input type="text" name="name" value="{{ Auth::user()->name }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label>Số điện thoại:</label><br>
            <input type="text" name="phone" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label>Địa chỉ nhận hàng cụ thể:</label><br>
            {{-- 2. Đảm bảo name="address" để Controller nhận được --}}
            <textarea name="address" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; height: 80px;"></textarea>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Ghi chú đơn hàng (nếu có):</label><br>
            <textarea name="note" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; height: 50px;"></textarea>
        </div>

        {{-- 3. Nút xác nhận gửi form --}}
        <button type="submit" class="btn-buy-now-small" style="width: 100%; padding: 12px; font-weight: bold; background: #ee4d2d; color: #fff; border: none; cursor: pointer; border-radius: 4px;">
            XÁC NHẬN ĐẶT HÀNG
        </button>
    </form>
</div>
@endsection