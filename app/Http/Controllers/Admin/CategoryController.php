<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cats = Category::orderBy('id', 'DESC')->paginate(4);

        return view('admin.category.index', compact('cats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories'
        ]);

        $data = $request->all('name', 'status');
        Category::create($data);

        return redirect()->route('category.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.category.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|unique:categories,name,'.$category->id
        ]);

        $data = $request->all('name', 'status');
        if ($category->update($data)) {
            return redirect()->route('category.index')->with('ok', 'Cập nhật danh mục thành công');
        }
        return redirect()->back()->with('no', 'Có lỗi xảy ra, vui lòng kiểm tra lại');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($category->delete()) {
            return redirect()->route('category.index')->with('ok', 'Xóa danh mục thành công');
        }
        return redirect()->back()->with('no', 'Có lỗi xảy ra, vui lòng kiểm tra lại');
    }
}
