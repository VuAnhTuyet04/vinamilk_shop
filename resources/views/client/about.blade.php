@extends('layouts.client')

@section('content')
<div style="background: #fff; padding: 40px 20px; max-width: 1100px; margin: 20px auto; border-radius: 8px; box-shadow: 0 2px 15px rgba(0,0,0,0.05);">
    
    <div style="text-align: center; margin-bottom: 40px;">
        <h1 style="color: #0056b3; font-size: 32px; text-transform: uppercase; margin-bottom: 10px;">Chào mừng bạn đến với Vinamilk Shop</h1>
        <div style="width: 80px; height: 4px; background: #ee4d2d; margin: 0 auto;"></div>
    </div>

    <div style="display: flex; gap: 40px; align-items: center; margin-bottom: 50px;">
        <div style="flex: 1;">
            <img src="{{asset('images/about-banner.jpg')}}" alt="Vinamilk Shop" style="width: 100%; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        </div>
        <div style="flex: 1.2;">
            <h2 style="color: #008d81; margin-bottom: 15px;">Câu chuyện của chúng tôi</h2>
            <p style="line-height: 1.8; color: #555; text-align: justify;">
                Với hơn 45 năm hình thành và phát triển, **Vinamilk Shop** tự hào là địa chỉ tin cậy cung cấp các sản phẩm dinh dưỡng hàng đầu Việt Nam. Chúng tôi không chỉ bán sữa, chúng tôi mang đến giải pháp sức khỏe cho mọi thế hệ trong gia đình bạn.
            </p>
            <p style="line-height: 1.8; color: #555; text-align: justify;">
                Mỗi sản phẩm tại shop đều được bảo quản trong điều kiện tiêu chuẩn khắt khe nhất, đảm bảo giữ trọn vẹn hương vị thiên nhiên và giá trị dinh dưỡng khi đến tay khách hàng.
            </p>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 25px; text-align: center; margin-top: 50px;">
        <div style="padding: 20px; border: 1px dashed #ddd; border-radius: 8px;">
            <h3 style="color: #ee4d2d;">🛡️ Cam kết chất lượng</h3>
            <p style="font-size: 14px; color: #666;">Sản phẩm chính hãng 100% từ nhà máy Vinamilk, kiểm định nghiêm ngặt.</p>
        </div>
        <div style="padding: 20px; border: 1px dashed #ddd; border-radius: 8px;">
            <h3 style="color: #ee4d2d;">🚚 Giao hàng nhanh</h3>
            <p style="font-size: 14px; color: #666;">Hệ thống logistic tối ưu giúp đơn hàng đến tay bạn chỉ trong 24h - 48h.</p>
        </div>
        <div style="padding: 20px; border: 1px dashed #ddd; border-radius: 8px;">
            <h3 style="color: #ee4d2d;">❤️ Phục vụ tận tâm</h3>
            <p style="font-size: 14px; color: #666;">Đội ngũ tư vấn viên luôn sẵn sàng giải đáp mọi thắc mắc về dinh dưỡng.</p>
        </div>
    </div>

    <div style="margin-top: 50px; background: #f9f9f9; padding: 30px; border-radius: 8px; text-align: center;">
        <h2 style="color: #0056b3;">Thông tin liên hệ</h2>
        <p style="margin: 10px 0;">📍 Địa chỉ: Đường Trịnh Văn Bô, Phường phương canh, TP. Hà Nội</p>
        <p style="margin: 10px 0;">📞 Hotline: 1900 636 979</p>
        <p style="margin: 10px 0;">📧 Email: atshop@vinamilk.com.vn</p>
    </div>
</div>
@endsection