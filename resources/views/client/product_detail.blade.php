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

    .buy-group { display: flex; gap: 12px; margin-top: 20px; padding-top: 15px; border-top: 1px dashed #eee; align-items: center; }
    
    .btn-add-cart-small { 
        background: #ffeee8; 
        border: 1px solid #ee4d2d; 
        color: #ee4d2d; 
        padding: 10px 20px; 
        cursor: pointer; 
        font-size: 14px; 
        border-radius: 2px;
        text-decoration: none;
    }
    
    .btn-buy-now-small { 
        background: #ee4d2d; 
        color: #fff; 
        border: none; 
        padding: 10px 30px; 
        cursor: pointer; 
        font-size: 14px; 
        border-radius: 2px;
        text-decoration: none;
    }
    
    .btn-add-cart-small:hover { background: #fff5f1; }
    .btn-buy-now-small:hover { background: #d73211; }

    /* CSS bổ sung cho Sản phẩm liên quan */
    .related-title {
        font-size: 18px;
        font-weight: 500;
        color: #555;
        margin: 40px 0 20px 0;
        text-transform: uppercase;
    }
    .related-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
        margin-bottom: 40px;
    }
    .related-item {
        background: #fff;
        padding: 10px;
        transition: 0.3s;
        border: 1px solid transparent;
        text-align: center;
        text-decoration: none;
    }
    .related-item:hover {
        border: 1px solid #ee4d2d;
        box-shadow: 0 1px 20px rgba(0,0,0,.05);
    }
    .related-img {
        width: 100%;
        height: 180px;
        object-fit: contain;
    }
    .related-name {
        font-size: 13px;
        color: #333;
        margin: 10px 0 5px 0;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        height: 38px;
    }
    .related-price {
        color: #ee4d2d;
        font-size: 15px;
        font-weight: 500;
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

        <div class="product-description" style="margin-top: 10px;">
            <h3 style="font-size: 16px; font-weight: bold; color: #333; border-bottom: 2px solid #008d81; display: inline-block; padding-bottom: 5px; margin-bottom: 10px;">
                MÔ TẢ SẢN PHẨM
            </h3>
            
            <div style="font-size: 14px; color: #444; line-height: 1.6;">
                @if($product->content)
                    {!! $product->content !!}
                @elseif($product->summary)
                    {{ $product->summary }}
                @else
                    <p style="color: #999; font-style: italic;">Sản phẩm này hiện chưa có thông tin mô tả chi tiết.</p>
                @endif
            </div>
        </div>

        <div class="buy-group">
            @guest
                {{-- Dành cho khách chưa đăng nhập --}}
                <a href="{{ route('login') }}" onclick="alert('Vui lòng đăng nhập để mua hàng!')" class="btn-add-cart-small">
                    Thêm vào giỏ
                </a>
                <a href="{{ route('login') }}" onclick="alert('Vui lòng đăng nhập để mua hàng!')" class="btn-buy-now-small">
                    Mua Ngay
                </a>
            @else
                <a href="{{ route('client.add_cart', $product->id) }}" class="btn-add-cart-small">
                    Thêm vào giỏ
                </a>

                <a href="{{ route('client.add_cart', $product->id) }}" class="btn-buy-now-small">
                    Mua Ngay
                </a>
            @endguest
        </div>
    </div>
</div>

{{-- PHẦN THÊM MỚI: SẢN PHẨM LIÊN QUAN --}}
@if(isset($relatedProducts) && $relatedProducts->count() > 0)
    <h2 class="related-title">Sản phẩm liên quan</h2>
    <div class="related-grid">
        @foreach($relatedProducts as $item)
            <a href="{{ route('client.product_detail', $item->slug) }}" class="related-item">
                <img src="{{ asset('images/' . $item->thumbnail) }}" alt="{{ $item->name }}" class="related-img">
                <div class="related-name">{{ $item->name }}</div>
                <div class="related-price">
                    @if($item->discount_price > 0)
                        {{ number_format($item->discount_price, 0, ',', '.') }}đ
                    @else
                        {{ number_format($item->price, 0, ',', '.') }}đ
                    @endif
                </div>
            </a>
        @endforeach
    </div>
@endif

@endsection