@extends('layouts.master')
@section('content')
<div class="form-container" style="max-width: 500px; margin: 30px auto; background: white; padding: 25px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
    <h3>Sửa danh mục: {{ $category->name }}</h3>
    
    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT') {{-- Bắt buộc phải có --}}
        
        <div style="margin-bottom: 15px;">
            <label>Tên danh mục:</label>
            <input type="text" name="name" value="{{ $category->name }}" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:8px;" required>
        </div>
        
        <div style="margin-bottom: 15px;">
            <label>Mô tả:</label>
            <textarea name="description" rows="3" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:8px;">{{ $category->description }}</textarea>
        </div>
        
        <button type="submit" style="width:100%; background:#007bff; color:white; border:none; padding:12px; border-radius:8px; font-weight:bold; cursor:pointer;">Cập nhật</button>
    </form>
</div>
@endsection