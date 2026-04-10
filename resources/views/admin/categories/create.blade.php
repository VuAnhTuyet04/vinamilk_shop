@extends('layouts.master')
@section('content')
<div class="form-container" style="max-width: 500px; margin: 30px auto; background: white; padding: 25px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
    <h3>Thêm danh mục mới</h3>
    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div style="margin-bottom: 15px;">
            <label>Tên danh mục:</label>
            <input type="text" name="name" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:8px;" required>
        </div>
        <div style="margin-bottom: 15px;">
            <label>Mô tả:</label>
            <textarea name="description" rows="3" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:8px;"></textarea>
        </div>
        <button type="submit" style="width:100%; background:#28a745; color:white; border:none; padding:12px; border-radius:8px; font-weight:bold; cursor:pointer;">Lưu danh mục</button>
    </form>
</div>
@endsection