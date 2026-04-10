@extends('layouts.master')

@section('content')
<div style="padding: 20px;">
    <h2 style="margin-bottom: 20px;">QUẢN LÝ ĐƠN HÀNG</h2>
    
    <table style="width: 100%; border-collapse: collapse; background: #fff;">
        <thead>
            <tr style="background: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                <th style="padding: 12px; border: 1px solid #ddd;">ID</th>
                <th style="padding: 12px; border: 1px solid #ddd;">Khách hàng ID</th>
                <th style="padding: 12px; border: 1px solid #ddd;">Tổng tiền</th>
                <th style="padding: 12px; border: 1px solid #ddd;">Trạng thái hiện tại</th>
                <th style="padding: 12px; border: 1px solid #ddd;">Cập nhật trạng thái</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td style="padding: 12px; border: 1px solid #ddd;">#{{ $order->id }}</td>
                <td style="padding: 12px; border: 1px solid #ddd;">{{ $order->user_id }}</td>
                <td style="padding: 12px; border: 1px solid #ddd; color: red; font-weight: bold;">
                    {{ number_format($order->total_amount, 0, ',', '.') }}đ
                </td>
                <td style="padding: 12px; border: 1px solid #ddd;">
                    @if($order->status == 'pending') 
                        <span style="color: orange; font-weight: bold;">Chờ xử lý</span>
                    @elseif($order->status == 'shipping') 
                        <span style="color: #007bff; font-weight: bold;">Đang giao hàng</span>
                    @elseif($order->status == 'cancelled') 
                        <span style="color: red; font-weight: bold;">Đã hủy</span>
                    @else 
                        <span style="color: green; font-weight: bold;">Thành công</span>
                    @endif
                </td>
                <td style="padding: 12px; border: 1px solid #ddd;">
                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                        @csrf
                        <select name="status" style="padding: 5px; border-radius: 4px; border: 1px solid #ccc;">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                            <option value="shipping" {{ $order->status == 'shipping' ? 'selected' : '' }}>Đang giao hàng</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Thành công</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Hủy đơn</option>
                        </select>
                        <button type="submit" style="background: #008d81; color: white; border: none; padding: 6px 12px; cursor: pointer; border-radius: 4px; margin-left: 5px;">
                            Lưu
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection