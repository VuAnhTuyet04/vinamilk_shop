<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str; 
use Illuminate\Http\Request;
use App\Models\Product; 
use App\Models\Category;

class AdminController extends Controller
{
    // 1. Hiển thị danh sách sản phẩm
    public function index()
    {
        // Lấy sản phẩm mới nhất lên đầu
        $products = Product::orderBy('created_at', 'desc')->get();
        return view('admin.index', compact('products'));
    }

    // 2. Hiển thị FORM thêm sản phẩm mới
    public function create()
    {

    $categories = Category::all(); // Lấy tất cả danh mục
    return view('admin.create', compact('categories'));
}
    

    // 3. Hàm xử lý lưu sản phẩm
    public function store(Request $request)
    {
        // Validate dữ liệu cơ bản (Tránh lỗi vặt)
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif|max:2048' // Giới hạn 2MB
        ]);

        $product = new Product();
        $product->name = $request->name;
        // Tạo slug tự động từ tên: "Sữa tươi" -> "sua-tuoi-168000000"
        $product->slug = Str::slug($request->name) . '-' . time();
        $product->price = $request->price;
        
        // Các giá trị mặc định nếu form để trống
        $product->category_id = $request->category_id ?? 1;
        $product->discount_price = $request->discount_price ?? 0;
        $product->summary = $request->summary;
        $product->content = $request->content;
        $product->stock_quantity = $request->stock_quantity ?? 100;
        $product->unit = $request->unit ?? 'Hộp';
        $product->is_active = 1;
        $product->expiry_date = $request->expiry_date;

        // --- XỬ LÝ FILE ẢNH ---
        // Lưu ý: name ở đây phải khớp với name="thumbnail" trong file create.blade.php
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            
            // Làm sạch tên file: Xóa khoảng trắng để tránh lỗi hiển thị
            $rawFileName = str_replace(' ', '_', $file->getClientOriginalName());
            $fileName = time() . '_' . $rawFileName;
            
            // Đẩy vào public/images
            $file->move(public_path('images'), $fileName);
            
            $product->thumbnail = $fileName;
        } else {
            // Nếu không chọn ảnh, dùng ảnh mặc định (đảm bảo bạn có file này trong public/images)
            $product->thumbnail = 'default.jpg';
        }

        $product->save();
// Lệnh này giúp chuyển về trang danh sách và gửi thông báo
    return redirect()->route('admin.products.index')
                     ->with('success', 'Thêm sản phẩm mới thành công ');
    }

    // 4. Hàm xóa sản phẩm
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        // Xóa file ảnh vật lý trong thư mục images để nhẹ máy
        if ($product->thumbnail && $product->thumbnail != 'default.jpg') {
            $imagePath = public_path('images/' . $product->thumbnail);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $product->delete();

        return redirect('/admin')->with('success', 'Đã xóa sản phẩm thành công!');
    }
    // 1. Hàm hiển thị form sửa với dữ liệu cũ
public function edit($id)
{
    $product = Product::findOrFail($id);
    return view('admin.edit', compact('product'));
}

// 2. Hàm xử lý cập nhật dữ liệu
public function update(Request $request, $id)
{
    $product = Product::findOrFail($id);
    
    $product->name = $request->name;
    $product->price = $request->price;
    $product->unit = $request->unit;
    $product->expiry_date = $request->expiry_date;
    $product->summary = $request->summary;
    $product->content = $request->content;

    if ($request->hasFile('thumbnail')) {
        // Xóa ảnh cũ nếu có ảnh mới
        if ($product->thumbnail && file_exists(public_path('images/' . $product->thumbnail))) {
            unlink(public_path('images/' . $product->thumbnail));
        }

        $file = $request->file('thumbnail');
        $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
        $file->move(public_path('images'), $fileName);
        $product->thumbnail = $fileName;
    }

    $product->save();
    return redirect('/admin')->with('success', 'Cập nhật sản phẩm thành công!');
}
}