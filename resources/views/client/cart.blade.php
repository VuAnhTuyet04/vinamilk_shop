@extends('layouts.client')

@section('content')
<div style="padding: 20px; background: #fff; margin-top: 20px; border-radius: 8px;">
    <h2 style="border-bottom: 2px solid #ee4d2d; padding-bottom: 10px;">GIỎ HÀNG CỦA BẠN</h2>
    
    @if(Session::has('cart') && count(Session::get('cart')) > 0)
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <thead>
                <tr style="background: #f8f8f8; border-bottom: 1px solid #eee;">
                    <th style="padding: 10px;">Ảnh</th>
                    <th>Sản phẩm</th>
                    <th>Giá</th>
                    <th style="width: 150px;">Số lượng</th> {{-- Chỉnh độ rộng cho cột số lượng --}}
                    <th>Tổng</th>
                    <th>Xóa</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0 @endphp
                @foreach($cart as $id => $item)
                    @php $total += $item['price'] * $item['quantity'] @endphp
                    <tr style="border-bottom: 1px solid #eee; text-align: center;">
                        <td style="padding: 10px;"><img src="{{ asset('images/'.$item['thumbnail']) }}" width="60"></td>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ number_format($item['price'], 0, ',', '.') }}đ</td>
                        
                        {{-- PHẦN SỬA ĐỂ CHỈNH SỐ LƯỢNG --}}
                        <td>
                            <form action="{{ route('client.cart.update') }}" method="POST" style="display: flex; align-items: center; justify-content: center; gap: 5px;">
                                @csrf
                                <input type="hidden" name="id" value="{{ $id }}">
                                
                                {{-- Nút giảm số lượng --}}
                                <button type="submit" name="quantity" value="{{ $item['quantity'] - 1 }}" 
                                        {{ $item['quantity'] <= 1 ? 'disabled' : '' }} 
                                        style="width: 25px; height: 25px; border: 1px solid #ddd; background: #fff; cursor: pointer;">-</button>
                                
                                {{-- Ô hiển thị số lượng --}}
                                <input type="text" value="{{ $item['quantity'] }}" readonly 
                                       style="width: 35px; height: 21px; text-align: center; border: 1px solid #ddd; border-left: 0; border-right: 0;">
                                
                                {{-- Nút tăng số lượng --}}
                                <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}" 
                                        style="width: 25px; height: 25px; border: 1px solid #ddd; background: #fff; cursor: pointer;">+</button>
                            </form>
                        </td>
                        
                        <td style="color: #ee4d2d; font-weight: bold;">{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}đ</td>
                        <td><a href="{{ route('client.cart.remove', $id) }}" style="color: red;"><i class="fa fa-trash"></i></a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <div style="text-align: right; margin-top: 30px;">
            <h3 style="margin-bottom: 20px;">Tổng cộng: <span style="color: #ee4d2d; font-size: 24px;">{{ number_format($total, 0, ',', '.') }}đ</span></h3>
   <a href="{{ route('client.checkout') }}" class="btn btn-primary">
    TIẾN HÀNH THANH TOÁN
</a>
        </div>
    @else
        <div style="text-align: center; padding: 50px;">
            <p>Giỏ hàng của bạn đang trống.</p>
            <a href="{{ url('/') }}" class="btn-buy-now-small" style="text-decoration: none;">QUAY LẠI MUA SẮM</a>
        </div>
    @endif
</div>
@endsection