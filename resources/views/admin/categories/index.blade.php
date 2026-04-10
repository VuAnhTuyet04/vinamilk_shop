@extends('layouts.master')
@section('content')
<div class="container" style="padding: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Danh mục sản phẩm</h2>
        <a href="{{ route('categories.create') }}" class="btn-add" style="background:#28a745; color:white; padding:10px; border-radius:5px; text-decoration:none;">+ Thêm mới</a>
    </div>

    <table style="width:100%; border-collapse: collapse; background: white; border-radius: 10px; overflow: hidden;">
        <thead style="background: #f8f9fa;">
            <tr>
                <th style="padding:15px; border-bottom:1px solid #ddd;">ID</th>
                <th style="padding:15px; border-bottom:1px solid #ddd;">Tên danh mục</th>
                <th style="padding:15px; border-bottom:1px solid #ddd;">Mô tả</th>
                <th style="padding:15px; border-bottom:1px solid #ddd;">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $cat)
            <tr style="border-bottom: 1px solid #eee;">
                <td style="padding:15px; text-align:center;">{{ $cat->id }}</td>
                <td style="padding:15px;"><b>{{ $cat->name }}</b></td>
                <td style="padding:15px;">{{ $cat->description }}</td>
                <td style="padding:15px; display:flex; gap:10px; justify-content:center;">
                    <a href="{{ route('categories.edit', $cat->id) }}" style="background:#007bff; color:white; padding:5px 10px; border-radius:4px; text-decoration:none;">Sửa</a>
                    <form action="{{ route('categories.destroy', $cat->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" style="background:#dc3545; color:white; border:none; padding:5px 10px; border-radius:4px; cursor:pointer;" onclick="return confirm('Xóa danh mục này?')">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection