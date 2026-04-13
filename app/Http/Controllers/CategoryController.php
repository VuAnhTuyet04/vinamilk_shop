<?php
namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Category;



class CategoryController extends Controller {
    public function index() {
        $categories = Category::orderBy('id', 'desc')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create() {
        return view('admin.categories.create');
    }

    public function store(Request $request) {
        $request->validate(['name' => 'required|unique:categories']);
        
        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description
        ]);
        return redirect()->route('categories.index')->with('success', 'Thêm danh mục thành công!');
    }

    public function edit($id) {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id) {
        $cat = Category::findOrFail($id);
        $cat->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description
        ]);
        return redirect()->route('categories.index')->with('success', 'Cập nhật thành công!');
    }

    public function destroy($id) {
        Category::destroy($id);
        return redirect()->route('categories.index');
    return redirect()->route('admin.product.index')->with('success', 'Cập nhật sản phẩm thành công!');
}
}