@extends('layouts.master')

@section('content')
<style>
    /* Giữ nguyên phần CSS của bạn */
    .form-container {
        max-width: 600px;
        margin: 20px auto;
        background: white;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    .form-group { margin-bottom: 15px; }
    label { display: block; font-weight: bold; margin-bottom: 5px; color: #333; }
    input, select, textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-sizing: border-box;
    }
    .btn-save {
        background: #28a745; /* Đổi màu xanh cho chuyên nghiệp */
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: bold;
        width: 100%; /* Cho nút to rõ ràng */
    }
    .btn-save:hover { background: #218838; }
</style>

<div class="form-container">
    <h2>Thêm sản phẩm mới</h2>

    {{-- CHỈ DÙNG 1 THẺ FORM DUY NHẤT VÀ CÓ enctype --}}
    <form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>Tên sản phẩm:</label>
            <input type="text" name="name" placeholder="Ví dụ: Sữa tươi Vinamilk" required>
        </div>
               
        <div class="form-group">
            <label>Danh mục sản phẩm:</label>
            <select name="category_id" required>
                <option value="">-- Chọn danh mục --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Giá bán (đ):</label>
            <input type="number" name="price" required>
        </div>

        <div class="form-group">
            <label>Chọn hình ảnh từ máy tính:</label>
            <input type="file" name="thumbnail" accept="image/*" required>
        </div>

        <div class="form-group">
            <label>Đơn vị tính (Unit):</label>
            <input type="text" name="unit" placeholder="Hộp, Thùng, Vỉ...">
        </div>

        <div class="form-group">
            <label>Hạn sử dụng:</label>
            <input type="date" name="expiry_date">
        </div>

        <div class="form-group">
            <label>Mô tả ngắn (Summary):</label>
            <textarea name="summary" rows="2"></textarea>
        </div>

        <div class="form-group">
            <label>Nội dung chi tiết (Content):</label>
            <textarea name="content" rows="4"></textarea>
        </div>

        {{-- Nút bấm phải nằm TRONG thẻ </form> --}}
        <button type="submit" class="btn-save">
            <i class="bi bi-floppy-fill"></i> Lưu sản phẩm
        </button>
    </form> 
</div>
@endsection