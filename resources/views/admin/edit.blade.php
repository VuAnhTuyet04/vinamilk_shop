@extends('layouts.master')

@section('content')
<style>
    .form-container { max-width: 600px; margin: 20px auto; background: white; padding: 30px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
    .form-group { margin-bottom: 15px; }
    label { display: block; font-weight: bold; margin-bottom: 5px; }
    input, textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; }
    .btn-update { background: #007bff; color: white; border: none; padding: 12px; border-radius: 8px; cursor: pointer; font-weight: bold; width: 100%; }
    .current-img { margin-top: 10px; border-radius: 5px; border: 1px solid #ddd; padding: 5px; }
</style>

<div class="form-container">
    <h2>Sửa sản phẩm: {{ $product->name }}</h2>

    <form action="{{ route('admin.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') {{-- Bắt buộc phải có khi dùng Update --}}

        <div class="form-group">
            <label>Tên sản phẩm:</label>
            <input type="text" name="name" value="{{ $product->name }}" required>
        </div>
  <div class="form-group" style="margin-bottom: 15px;">
            <label style="font-weight: bold; display: block; margin-bottom: 5px;">Danh mục sản phẩm:</label>
            <select name="category_id" class="form-control" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Giá bán (đ):</label>
            <input type="number" name="price" value="{{ (int)$product->price }}" required>
        </div>

        <div class="form-group">
            <label>Thay đổi hình ảnh (để trống nếu giữ nguyên):</label>
            <input type="file" name="thumbnail" accept="image/*">
            <p>Ảnh hiện tại:</p>
            <img src="{{ asset('images/' . $product->thumbnail) }}" width="100" class="current-img">
        </div>

        <div class="form-group">
            <label>Đơn vị tính (Unit):</label>
            <input type="text" name="unit" value="{{ $product->unit }}">
        </div>

        <div class="form-group">
            <label>Hạn sử dụng:</label>
            <input type="date" name="expiry_date" value="{{ $product->expiry_date }}">
        </div>

        <div class="form-group">
            <label>Mô tả ngắn (Summary):</label>
            <textarea name="summary" rows="2">{{ $product->summary }}</textarea>
        </div>

        <div class="form-group">
            <label>Nội dung chi tiết (Content):</label>
            <textarea name="content" rows="4">{{ $product->content }}</textarea>
        </div>

        <button type="submit" class="btn-update">
            <i class="bi bi-pencil-square"></i> Cập nhật sản phẩm
        </button>
    </form>
</div>
@endsection