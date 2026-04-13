@extends('layouts.client')

@section('content')
<div class="main-layout" style="display: flex; gap: 20px; max-width: 1200px; margin: 20px auto; padding: 0 15px;">
    {{-- Sidebar --}}
    <aside class="sidebar" style="width: 250px; flex-shrink: 0; background: #fff; border: 1px solid #ddd; border-radius: 4px;">
        <h3 style="background: #0056b3; color: white; padding: 12px; margin: 0; font-size: 16px;">DANH MỤC</h3>
        <ul style="list-style: none; padding: 0;">
            @if(isset($categories))
                @foreach($categories as $category)
                    <li style="border-bottom: 1px solid #eee;">
                        <a href="{{ route('client.category', $category->slug) }}" style="display: block; padding: 12px; text-decoration: none; color: #333;">{{ $category->name }}</a>
                    </li>
                @endforeach
            @endif
        </ul>
    </aside>

    {{-- Kết quả tìm kiếm --}}
    <div class="content" style="flex-grow: 1;">
        <div style="border-bottom: 2px solid #0056b3; margin-bottom: 20px;">
            <h2 style="font-size: 18px; text-transform: uppercase;">Kết quả cho: "{{ request('query') }}"</h2>
        </div>

        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px;">
            @forelse($products as $product)
                <div style="border: 1px solid #eee; padding: 10px; text-align: center; background: #fff;">
                    <img src="{{ asset('images/' . $product->thumbnail) }}" style="width: 100%; height: 160px; object-fit: contain;">
                    <h3 style="font-size: 14px; margin: 10px 0; height: 35px; overflow: hidden;">{{ $product->name }}</h3>
                    <p style="color: red; font-weight: bold;">{{ number_format($product->price, 0, ',', '.') }}đ</p>
                    <a href="{{ route('client.product_detail', $product->slug) }}" style="display: block; background: #0056b3; color: white; padding: 8px; text-decoration: none; border-radius: 4px; font-size: 13px;">Xem chi tiết</a>
                </div>
            @empty
                <div style="grid-column: span 3; text-align: center; padding: 50px;">
                    <p>Không tìm thấy sản phẩm nào phù hợp.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection