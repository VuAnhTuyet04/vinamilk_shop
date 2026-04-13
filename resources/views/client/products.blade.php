@extends('layouts.client')

@section('content')
<style>
    .main-container {
        display: flex;
        gap: 30px;
        max-width: 1200px;
        margin: 20px auto;
        padding: 0 15px;
    }

    /* Sidebar danh mục kiểu đứng */
    .category-sidebar {
        width: 260px;
        flex-shrink: 0;
        border: 1px solid #ddd;
        border-radius: 4px;
        overflow: hidden;
        background: #fff;
    }

    .sidebar-header {
        background: #0056b3;
        color: white;
        padding: 12px 15px;
        display: flex;
        align-items: center;
        font-weight: bold;
        font-size: 16px;
        text-transform: uppercase;
    }

    .sidebar-header i {
        margin-right: 10px;
    }

    .category-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .category-list li {
        border-bottom: 1px solid #eee;
    }

    .category-list li:last-child {
        border-bottom: none;
    }

    .category-list li a {
        display: block;
        padding: 12px 15px;
        text-decoration: none;
        color: #333;
        font-size: 15px;
        transition: 0.3s;
    }

    .category-list li a:hover {
        color: #0056b3;
        background-color: #f8f9fa;
        padding-left: 20px;
    }

    /* Khu vực danh sách sản phẩm */
    .product-content {
        flex-grow: 1;
    }

    .page-title {
        font-size: 20px;
        font-weight: bold;
        text-transform: uppercase;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #0056b3;
        color: #333;
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }

    .product-card {
        border: 1px solid #eee;
        padding: 15px;
        text-align: center;
        transition: 0.3s;
        background: #fff;
    }

    .product-card:hover {
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
</style>

<div class="main-container">
    <aside class="category-sidebar">
        <div class="sidebar-header">
            <i class="fa fa-bars"></i> DANH MỤC
        </div>
        <ul class="category-list">
            @foreach($categories as $category)
                <li>
                    <a href="{{ route('client.category', $category->slug) }}">
                        {{ $category->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </aside>

    <main class="product-content">
        <h1 class="page-title">
            @if(isset($query) && $query != '')
                KẾT QUẢ TÌM KIẾM CHO: "{{ $query }}"
            @else
                Tất cả sản phẩm Vinamilk
            @endif
        </h1>
        
        <div class="product-grid">
            @forelse($products as $product)
                <div class="product-card">
                    <div class="product-img" style="height: 200px; margin-bottom: 15px;">
                        <img src="{{ asset('images/' . $product->thumbnail) }}" 
                             alt="{{ $product->name }}" 
                             style="max-width: 100%; max-height: 100%; object-fit: contain;">
                    </div>
                    
                    <h3 style="font-size: 16px; margin: 10px 0; height: 40px; overflow: hidden; color: #333;">
                        {{ $product->name }}
                    </h3>
                    
                    <p style="color: #d70018; font-weight: bold; font-size: 18px; margin: 10px 0;">
                        @if($product->discount_price > 0)
                            {{ number_format($product->discount_price, 0, ',', '.') }}đ
                            <span style="text-decoration: line-through; color: #999; font-size: 14px; margin-left: 5px;">
                                {{ number_format($product->price, 0, ',', '.') }}đ
                            </span>
                        @else
                            {{ number_format($product->price, 0, ',', '.') }}đ
                        @endif
                    </p>
                    
                    <a href="{{ route('client.product_detail', $product->slug) }}" 
                       style="display: inline-block; padding: 8px 15px; border: 1px solid #0056b3; color: #0056b3; text-decoration: none; border-radius: 4px; font-size: 14px;">
                        Xem chi tiết
                    </a>
                </div>
            @empty
                <div style="grid-column: span 3; text-align: center; padding: 50px 0;">
                    <img src="{{ asset('images/no-product.png') }}" alt="" style="width: 100px; opacity: 0.5;">
                    <p style="color: #666; margin-top: 10px;">Không tìm thấy sản phẩm nào phù hợp với yêu cầu của bạn.</p>
                </div>
            @endforelse
        </div>
    </main>
</div>
@endsection