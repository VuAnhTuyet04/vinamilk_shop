@extends('layouts.client')
@section('content')
<div class="container-custom" style="max-width: 1400px; margin: 40px auto; padding: 0 15px;">
    <div style="display: flex; gap: 50px;">
        <div style="flex: 1;">
            <h2 style="color: #0056b3; border-bottom: 2px solid #0056b3; padding-bottom: 10px;">THÔNG TIN LIÊN HỆ</h2>
            <p><i class="bi bi-geo-alt-fill"></i> <strong>Địa chỉ:</strong> Số 10 Tân Trào, P. Tân Phú, Q. 7, TP. HCM</p>
            <p><i class="bi bi-telephone-fill"></i> <strong>Điện thoại:</strong> 028 5415 5555</p>
            <p><i class="bi bi-envelope-fill"></i> <strong>Email:</strong> vinamilk@vinamilk.com.vn</p>
            <div style="margin-top: 20px;">
                <iframe src="https://www.google.com/maps/embed?..." width="100%" height="350" style="border:0; border-radius: 8px;" allowfullscreen=""></iframe>
            </div>
        </div>

        <div style="flex: 1; background: #f9f9f9; padding: 30px; border-radius: 8px;">
            <h2 style="font-size: 20px; margin-bottom: 20px;">GỬI TIN NHẮN CHO CHÚNG TÔI</h2>
            <form action="{{ route('client.contact.send') }}" method="POST">
                @csrf
                <input type="text" name="name" placeholder="Họ và tên" style="width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #ddd;">
                <input type="email" name="email" placeholder="Email của bạn" style="width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #ddd;">
                <textarea name="message" rows="5" placeholder="Nội dung tin nhắn" style="width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #ddd;"></textarea>
                <button type="submit" style="background: #0056b3; color: white; padding: 12px 30px; border: none; cursor: pointer; font-weight: bold;">GỬI ĐI</button>
            </form>
        </div>
    </div>
</div>
@endsection