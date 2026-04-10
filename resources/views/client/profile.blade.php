@extends('layouts.client')

@section('content')
<div style="max-width: 1000px; margin: 30px auto; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
    
    <h2 style="color: #ee4d2d; border-bottom: 2px solid #ee4d2d; padding-bottom: 10px;">THÔNG TIN CÁ NHÂN</h2>
    
    {{-- Form sửa thông tin --}}
    <form action="{{ route('client.profile.update') }}" method="POST" style="margin-bottom: 40px; padding: 20px; background: #fafafa; border-radius: 5px;">
        @csrf
        <div style="margin-bottom: 10px;">
            <label><strong>Họ tên:</strong></label><br>
            <input type="text" name="name" value="{{ $user->name }}" style="width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px;">
        </div>
        <div style="margin-bottom: 15px;">
            <label><strong>Email:</strong></label><br>
            <input type="email" name="email" value="{{ $user->email }}" style="width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px;">
        </div>

        {{-- Phần hiển thị ngày tham gia --}}
        <div style="margin-bottom: 15px; font-size: 14px; color: #666;">
            <strong>Ngày tham gia:</strong> {{ date('d/m/Y', strtotime($user->created_at)) }}
        </div>

        <button type="submit" style="background: #008d81; color: #fff; border: none; padding: 10px 20px; cursor: pointer; border-radius: 4px; font-weight: bold;">
            Lưu thay đổi
        </button>
    </form>

    <h2 style="color: #008d81; border-bottom: 2px solid #008d81; padding-bottom: 10px;">LỊCH SỬ ĐƠN HÀNG</h2>
    <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
        <thead>
            <tr style="background: #f2f2f2; text-align: left;">
                <th style="padding: 12px; border: 1px solid #ddd;">Mã ĐH</th>
                <th style="padding: 12px; border: 1px solid #ddd;">Ngày đặt</th>
                <th style="padding: 12px; border: 1px solid #ddd;">Tổng tiền</th>
                <th style="padding: 12px; border: 1px solid #ddd;">Trạng thái</th>
                <th style="padding: 12px; border: 1px solid #ddd;">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td style="padding: 12px; border: 1px solid #ddd;">#{{ $order->id }}</td>
                    <td style="padding: 12px; border: 1px solid #ddd;">
                        {{ date('d/m/Y H:i', strtotime($order->created_at)) }}
                    </td>
                    <td style="padding: 12px; border: 1px solid #ddd; color: #ee4d2d; font-weight: bold;">
                        {{ number_format($order->total_amount, 0, ',', '.') }}đ
                    </td>
                    <td style="padding: 12px; border: 1px solid #ddd;">
                        @if($order->status == 'pending')
                            <span style="background: #ffeeba; color: #856404; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: bold;">Chờ xử lý</span>
                        @elseif($order->status == 'shipping')
                            <span style="background: #cfe2ff; color: #084298; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: bold;">Đang giao hàng</span>
                        @elseif($order->status == 'cancelled')
                            <span style="background: #f8d7da; color: #721c24; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: bold;">Đã hủy</span>
                        @else
                            <span style="background: #d4edda; color: #155724; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: bold;">Thành công</span>
                        @endif
                    </td>
                    <td style="padding: 12px; border: 1px solid #ddd;">
                        {{-- Chỉ được hủy nếu đơn hàng đang ở trạng thái 'pending' --}}
                        @if($order->status == 'pending')
                            <form action="{{ route('client.order.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn hủy đơn này?')">
                                @csrf
                                <button type="submit" style="background: #dc3545; color: #fff; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer; font-size: 11px;">Hủy đơn</button>
                            </form>
                        @else
                            <span style="color: #999; font-size: 11px; font-style: italic;">Không thể hủy</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="padding: 20px; text-align: center; color: #888;">Bạn chưa có đơn hàng nào.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection