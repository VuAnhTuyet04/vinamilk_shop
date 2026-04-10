@extends('layouts.master')

@section('content')
<style>
    /* Phần tiêu đề và nút thêm */
    .header-area {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        margin-bottom: 30px;
        gap: 10px;
    }
    .btn-add {
        background-color: #28a745;
        color: white;
        padding: 8px 15px;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
    }

   /* Chỉnh lại lưới cho thẻ nhỏ hơn nếu muốn nhiều cột hơn */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); /* Giảm từ 280px xuống 200px */
        gap: 20px;
    }

    .product-card {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        border: 1px solid #eee;
        transition: transform 0.2s;
    }

    .product-card:hover {
        transform: translateY(-5px); /* Hiệu ứng bay lên nhẹ khi di chuột vào */
    }

    /* ĐÂY LÀ PHẦN CHỈNH ẢNH NHỎ LẠI */
    .product-image {
        width: 100%;
        height: 150px; /* Giảm chiều cao từ 200px xuống 150px hoặc 120px tùy bạn */
        object-fit: contain; /* Dùng 'contain' để hiện toàn bộ ảnh sữa mà không bị mất góc */
        background-color: #f9f9f9; /* Tạo nền xám nhẹ cho các ảnh có nền trắng */
        padding: 10px; /* Tạo khoảng trống xung quanh chai sữa cho đẹp */
    }

    .product-info {
        padding: 12px;
    }

    .product-name {
        font-size: 0.95rem; /* Chữ nhỏ lại một chút */
        font-weight: bold;
        color: #333;
        margin-bottom: 5px;
        height: 2.4em; 
        overflow: hidden;
    }
    .product-price {
        color: #ff9800;
        font-size: 1.2rem;
        font-weight: bold;
        margin-bottom: 15px;
    }
/* Container chứa các nút */
.action-btns {
    display: flex;
    gap: 10px;
    margin-top: 15px;
}

/* Định dạng chung cho cả nút Sửa và Xóa */
.btn-edit, .btn-delete {
    flex: 1; /* Chia đều độ rộng 50/50 */
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    padding: 8px 5px;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: 0.3s;
    height: 38px; /* Độ cao cố định cho bằng nhau */
}

    /* Màu riêng cho nút Sửa (Xanh dương) */
    .btn-edit {
        background-color: #007bff;
        color: white;
    }
    .btn-edit:hover {
        background-color: #0056b3;
    }

    /* Màu riêng cho nút Xóa (Đỏ) */
    .btn-delete {
        background-color: #dc3545;
        color: white;
    }
    .btn-delete:hover {
        background-color: #c82333;
    }
</style>

<div class="container-fluid">
    <div class="header-area">
        <h2 style="margin: 0; color: #333;">Quản lý Sản phẩm - Sữa Vinamilk</h2>
        @if(session('success'))
    <div style="background-color: #d4edda; color: #155724; padding: 15px; border: 1px solid #c3e6cb; border-radius: 5px; margin-bottom: 20px;">
        <strong>Thành công!</strong> {{ session('success') }}
    </div>
@endif
        <a href="{{ route('admin.create') }}" class="btn-add">
            <i class="bi bi-plus-circle"></i> Thêm sản phẩm mới
        </a>
    </div>

    <div class="product-grid">
        @foreach($products as $p)
        <div class="product-card">
          <img src="{{ asset('images/' . $p->thumbnail) }}" 
                 class="product-image" 
                 alt="{{ $p->name }}"
                 onerror="this.onerror=null; this.src='https://via.placeholder.com/300x200?text=No+Image'">
            <div class="product-info">
                <div class="product-name">{{ $p->name }}</div>
                <div class="product-price">{{ number_format($p->price) }}đ</div>
                
                <div class="action-btns">
                   <a href="{{ route('admin.edit', $p->id) }}" class="btn-edit">Sửa</a>
                    
                    <form action="{{ route('admin.destroy', $p->id) }}" method="POST" style="flex: 1;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete" onclick="return confirm('Bạn có chắc muốn xóa?')">
                            <i class="bi bi-trash"></i> Xóa
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection