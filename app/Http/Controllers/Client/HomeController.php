<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
  public function index()
{
    // Lấy 8 sản phẩm có số lượng tồn kho nhiều nhất (Sản phẩm bán chạy theo ý bạn)
    $bestSellers = Product::where('is_active', 1)
        ->orderBy('stock_quantity', 'desc')
        ->take(8)
        ->get();

    // Lấy 8 sản phẩm vừa mới thêm vào hệ thống
    $newProducts = Product::where('is_active', 1)
        ->orderBy('created_at', 'desc')
        ->take(8)
        ->get();

    $categories = Category::all();

    return view('client.index', compact('bestSellers', 'newProducts', 'categories'));
}

public function category($slug)
{
    // 1. Lấy tất cả danh mục cho sidebar
    $categories = Category::all();

    // 2. Tìm danh mục hiện tại dựa trên slug
    $category = Category::where('slug', $slug)->firstOrFail();

    // 3. Lấy sản phẩm thuộc danh mục này
    $products = Product::where('category_id', $category->id)
                        ->where('is_active', 1)
                        ->get();

    // 4. Lấy dữ liệu bổ sung để tránh lỗi "Undefined variable" ở giao diện index
    // Vì bảng products của bạn chưa có cột is_best_seller, ta lấy ngẫu nhiên 4 cái
    $bestSellers = Product::where('is_active', 1)->inRandomOrder()->take(4)->get();
    $newProducts = Product::where('is_active', 1)->latest()->take(4)->get();

    // 5. Trả về view 'client.index' và truyền đầy đủ các biến
    return view('client.index', compact('categories', 'category', 'products', 'bestSellers', 'newProducts'));
}
    public function allProducts()
{
    $categories = \App\Models\Category::all(); // Lấy để hiện ở sidebar
    
    // Lấy tất cả sản phẩm, có thể dùng paginate để phân trang nếu nhiều đồ
    $products = \App\Models\Product::where('is_active', 1)->paginate(12); 

    return view('client.products', compact('categories', 'products'));
}
public function productDetail($slug) {
    // 1. Lấy sản phẩm hiện tại
    $product = Product::where('slug', $slug)->firstOrFail();

    // 2. Lấy 4 sản phẩm liên quan (cùng category_id, khác ID sản phẩm hiện tại)
    $relatedProducts = Product::where('category_id', $product->category_id)
        ->where('id', '!=', $product->id) // Không lấy lại chính nó
        ->limit(4) // Lấy tối đa 4 sản phẩm
        ->get();

    return view('client.product_detail', compact('product', 'relatedProducts'));
}
public function search(Request $request)
{
    $query = $request->input('query');
    
    // Tìm kiếm sản phẩm
    $products = Product::where('name', 'LIKE', "%{$query}%")
                        ->where('is_active', 1)
                        ->get();

    // Lấy thêm categories để hiện ở sidebar (tránh lỗi undefined)
    $categories = Category::all(); 
return view('client.search', compact('products', 'categories'));
}
public function about() {
    return view('client.about');
}
}