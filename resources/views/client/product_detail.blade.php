@extends('layouts.client')

@section('content')
<style>
    .product-detail-container { display: flex; background: #fff; padding: 20px; gap: 40px; margin-top: 20px; border-radius: 3px; box-shadow: 0 1px 1px rgba(0,0,0,.05); }
    .product-left { flex: 1; }
    .product-right { flex: 1.5; display: flex; flex-direction: column; }
    .main-img { width: 100%; border: 1px solid #eee; object-fit: contain; max-height: 450px; }
    .detail-name { font-size: 24px; font-weight: 500; margin-bottom: 15px; }
    .detail-price-box { background: #fafafa; padding: 15px; margin-bottom: 10px; }
    .detail-price { font-size: 26px; color: #ee4d2d; font-weight: 500; }
    .detail-old-price { text-decoration: line-through; color: #929292; margin-right: 10px; font-size: 16px; }

    /* Trạng thái kho hàng */
    .stock-status { margin: 10px 0; font-size: 14px; }
    .status-available { color: #28a745; font-weight: bold; }
    .status-out { color: #dc3545; font-weight: bold; }

    .buy-group { display: flex; gap: 12px; margin-top: 20px; padding-top: 15px; border-top: 1px dashed #eee; align-items: center; }
    .btn-add-cart-small { background: #ffeee8; border: 1px solid #ee4d2d; color: #ee4d2d; padding: 10px 20px; cursor: pointer; font-size: 14px; border-radius: 2px; text-decoration: none; }
    .btn-buy-now-small { background: #ee4d2d; color: #fff; border: none; padding: 10px 30px; cursor: pointer; font-size: 14px; border-radius: 2px; text-decoration: none; }
    
    /* Nút bị vô hiệu hóa khi hết hàng */
    .btn-disabled { background: #f5f5f5 !important; color: #ccc !important; border: 1px solid #ddd !important; cursor: not-allowed !important; pointer-events: none; }

    /* Sản phẩm liên quan */
    .related-title { font-size: 18px; font-weight: 500; color: #555; margin: 40px 0 20px 0; text-transform: uppercase; }
    .related-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 40px; }
    .related-item { background: #fff; padding: 10px; transition: 0.3s; border: 1px solid transparent; text-align: center; text-decoration: none; border: 1px solid #eee; }
    .related-item:hover { border: 1px solid #ee4d2d; box-shadow: 0 1px 20px rgba(0,0,0,.05); }
    .related-img { width: 100%; height: 180px; object-fit: contain; }
    .related-name { font-size: 13px; color: #333; margin: 10px 0 5px 0; height: 38px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; }
    .related-price { color: #ee4d2d; font-size: 15px; font-weight: 500; }
    .related-btn-detail {
        display: block;
        margin-top: 10px;
        padding: 6px 0;
        background: #008d81; /* Màu xanh giống thanh tiêu đề mô tả của bạn */
        color: #fff !important;
        text-decoration: none;
        font-size: 12px;
        border-radius: 2px;
        transition: 0.3s;
    }
    .related-btn-detail:hover {
        background: #005a52;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .related-btn-detail {
        display: block;
        margin-top: 10px;
        padding: 6px 0;
        background: #008d81; /* Màu xanh giống thanh tiêu đề mô tả của bạn */
        color: #fff !important;
        text-decoration: none;
        font-size: 12px;
        border-radius: 2px;
        transition: 0.3s;
    }
    .related-btn-detail:hover {
        background: #005a52;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
</style>

<div class="product-detail-container">
    <div class="product-left">
        <img src="{{ asset('images/' . $product->thumbnail) }}" alt="{{ $product->name }}" class="main-img">
    </div>

    <div class="product-right">
        <h1 class="detail-name">{{ $product->name }}</h1>
        
        <div class="detail-price-box">
            @if($product->discount_price > 0)
                <span class="detail-old-price">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                <span class="detail-price">{{ number_format($product->discount_price, 0, ',', '.') }}đ</span>
            @else
                <span class="detail-price">{{ number_format($product->price, 0, ',', '.') }}đ</span>
            @endif
        </div>

        {{-- KIỂM TRA BIẾN stock_quantity TỪ DATABASE CỦA BẠN --}}
        <div class="stock-status">
            Trạng thái: 
            @if($product->stock_quantity > 0)
                <span class="status-available">Còn hàng ({{ $product->stock_quantity }} {{ $product->unit }})</span>
            @else
                <span class="status-out">Tạm hết hàng</span>
            @endif
        </div>

        <div class="product-description" style="margin-top: 10px;">
            <h3 style="font-size: 16px; font-weight: bold; color: #333; border-bottom: 2px solid #008d81; display: inline-block; padding-bottom: 5px; margin-bottom: 10px;">MÔ TẢ SẢN PHẨM</h3>
            <div style="font-size: 14px; color: #444; line-height: 1.6;">
                {!! $product->content ?? $product->summary ?? '<p style="color: #999; font-style: italic;">Chưa có mô tả chi tiết.</p>' !!}
            </div>
        </div>

        <div class="buy-group">
            {{-- CHỈ CHO PHÉP MUA KHI stock_quantity > 0 --}}
            @if($product->stock_quantity > 0)
                @guest
                    <a href="{{ route('login') }}" onclick="alert('Vui lòng đăng nhập!')" class="btn-add-cart-small">Thêm vào giỏ</a>
                    <a href="{{ route('login') }}" onclick="alert('Vui lòng đăng nhập!')" class="btn-buy-now-small">Mua Ngay</a>
                @else
                    <a href="{{ route('client.add_cart', $product->id) }}" class="btn-add-cart-small">Thêm vào giỏ</a>
                    <a href="{{ route('client.add_cart', $product->id) }}" class="btn-buy-now-small">Mua Ngay</a>
                @endguest
            @else
                {{-- HIỂN THỊ NÚT KHÓA KHI HẾT HÀNG --}}
                <button class="btn-add-cart-small btn-disabled">Thêm vào giỏ</button>
                <button class="btn-buy-now-small btn-disabled">Hết hàng</button>
            @endif
        </div>
    </div>
</div>
@if(isset($relatedProducts) && $relatedProducts->count() > 0)
    <h2 class="related-title">Sản phẩm liên quan</h2>
    <div class="related-grid">
        @foreach($relatedProducts as $item)
            <div class="related-item">
                <a href="{{ route('client.product_detail', $item->slug) }}" style="text-decoration: none;">
                    <img src="{{ asset('images/' . $item->thumbnail) }}" alt="{{ $item->name }}" class="related-img">
                    <div class="related-name">{{ $item->name }}</div>
                    <div class="related-price">
                        {{ number_format($item->discount_price > 0 ? $item->discount_price : $item->price, 0, ',', '.') }}đ
                    </div>
                </a>
                {{-- Nút xem chi tiết thêm mới ở đây --}}
                <a href="{{ route('client.product_detail', $item->slug) }}" class="related-btn-detail">
                    Xem chi tiết
                </a>
            </div>
        @endforeach
    </div>
@endif
@endsection