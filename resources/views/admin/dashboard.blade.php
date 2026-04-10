@extends('layouts.master')

@section('content')
<div style="background: white; padding: 15px; border-radius: 10px; margin-bottom: 25px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
    <form action="{{ route('admin.dashboard') }}" method="GET" style="display: flex; align-items: center; gap: 15px;">
        <div>
            <label style="font-weight: bold; margin-right: 5px;">Từ ngày:</label>
            <input type="date" name="date_from" value="{{ request('date_from') }}" 
                   style="padding: 8px; border: 1px solid #ddd; border-radius: 5px;">
        </div>
        <div>
            <label style="font-weight: bold; margin-right: 5px;">Đến ngày:</label>
            <input type="date" name="date_to" value="{{ request('date_to') }}" 
                   style="padding: 8px; border: 1px solid #ddd; border-radius: 5px;">
        </div>
        <button type="submit" style="background: #008d81; color: white; border: none; padding: 8px 20px; border-radius: 5px; cursor: pointer;">
            Lọc dữ liệu
        </button>
        <a href="{{ route('admin.dashboard') }}" style="text-decoration: none; color: #666; font-size: 14px;">Xóa lọc</a>
    </form>
</div>
<div style="padding: 20px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <h2 style="margin-bottom: 25px; color: #333; text-transform: uppercase; font-weight: bold;">BÁO CÁO THỐNG KÊ HỆ THỐNG</h2>

    {{-- Chỉ số tổng quan --}}
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 40px;">
        {{-- Tổng doanh thu --}}
        <div style="background: linear-gradient(135deg, #28a745, #218838); color: white; padding: 25px; border-radius: 10px; text-align: center; box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);">
            <h3 style="font-size: 18px; opacity: 0.9;">Tổng doanh thu</h3>
            <p style="font-size: 28px; font-weight: bold; margin: 10px 0;">{{ number_format($totalRevenue) }} VNĐ</p>
        </div>

        <div style="background: linear-gradient(135deg, #9ccfef, #0069d9); color: white; padding: 25px; border-radius: 10px; text-align: center; box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);">
            <h3 style="font-size: 18px; opacity: 0.9;">Người dùng đăng ký</h3>
            <p style="font-size: 32px; font-weight: bold; margin: 10px 0;">{{ $totalCustomers }}</p>
        </div>

        {{-- Tổng sản phẩm --}}
        <div style="background: linear-gradient(135deg, #6c757d, #5a6268); color: white; padding: 25px; border-radius: 10px; text-align: center; box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);">
            <h3 style="font-size: 18px; opacity: 0.9;">Tổng sản phẩm</h3>
            <p style="font-size: 32px; font-weight: bold; margin: 10px 0;">{{ $totalProducts }}</p>
        </div>
    </div>
    <div style="background: white; padding: 30px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.08);">
        <h3 style="margin-bottom: 25px; text-align: center; color: #444; font-weight: 600;">TOP 4 SẢN PHẨM ĐẶT HÀNG NHIỀU NHẤT</h3>
        <div style="width: 100%; max-width: 900px; margin: 0 auto; height: 450px;">
            <canvas id="bestSellerChart"></canvas>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('bestSellerChart');
        
        if (ctx) {
           // Thay vì viết trực tiếp, hãy thử dùng JSON.parse
const rawLabels = JSON.parse('{!! json_encode($bestSellers->pluck("name")) !!}');
const rawData = JSON.parse('{!! json_encode($bestSellers->pluck("total_sold")) !!}');
            // Chỉ lấy 4 sản phẩm đầu tiên
            const labels = rawLabels.slice(0, 4);
            const dataValues = rawData.slice(0, 4);

            if (labels.length === 0) {
                ctx.parentNode.innerHTML = '<div style="display:flex; justify-content:center; align-items:center; height:300px; color:#888;">Chưa có dữ liệu đơn hàng nào.</div>';
                return;
            }

            // Khởi tạo biểu đồ
            new Chart(ctx.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Số lượt đặt hàng',
                        data: dataValues,
                        backgroundColor: [
                            'rgba(40, 167, 69, 0.8)',
                            'rgba(0, 123, 255, 0.8)',
                            'rgba(255, 193, 7, 0.8)',
                            'rgba(238, 77, 45, 0.8)'
                        ],
                        borderRadius: 8,
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#333',
                            padding: 12
                        }
                    },
                    scales: {
                        y: { 
                            beginAtZero: true,
                            grid: { color: '#f0f0f0' },
                            ticks: { stepSize: 1, color: '#999' }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: '#666', font: { weight: '500' } }
                        }
                    }
                }
            }); // Kết thúc New Chart
        } // Kết thúc if (ctx)
    }); // Kết thúc addEventListener
</script>
@endsection