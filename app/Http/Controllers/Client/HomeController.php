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
        $categories = \App\Models\Category::all();

    // 1. Lấy 8 sản phẩm bán chạy nhất (Giả sử bạn có cột 'sold_count' hoặc tính theo đơn hàng)
    // Nếu chưa có hệ thống tính, tạm thời dùng orderBy('id', 'desc') hoặc 'sold_count'
    $bestSellers = \App\Models\Product::orderBy('id', 'desc')->take(8)->get(); 

    // 2. Lấy 8 sản phẩm mới nhất
    $newProducts = \App\Models\Product::latest()->take(8)->get();

    return view('client.index', compact('categories', 'bestSellers', 'newProducts'));
    }

    // Hàm bổ sung để xử lý khi click vào danh mục (đã fix lỗi Route ở bước trước)
    public function category($slug)
    {
        $categories = Category::all();
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = Product::where('category_id', $category->id)
                            ->where('is_active', 1)
                            ->get();

        return view('client.index', compact('categories', 'products'));
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
public function about() {
    return view('client.about');
}
}