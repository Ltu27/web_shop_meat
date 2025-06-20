<?php

namespace App\Http\Controllers;

use App\Http\Requests\Blog\CreateBlogRequest;
use App\Http\Requests\Blog\UpdateBlogRequest;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::orderBy('id', 'DESC')->paginate(4);

        return view('admin.blog.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateBlogRequest $request)
    {
        $data = $request->validated();
        Blog::create($data);

        return redirect()->route('blog.index');
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
    public function edit(Blog $blog)
    {
        return view('admin.blog.edit',compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        $data = $request->validated();
        if ($blog->update($data)) {
            return redirect()->route('blog.index')->with('ok', 'Cập nhật danh mục thành công');
        }
        return redirect()->back()->with('no', 'Có lỗi xảy ra, vui lòng kiểm tra lại');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        if ($blog->delete()) {
            return redirect()->route('blog.index')->with('ok', 'Xóa danh mục thành công');
        }
        return redirect()->back()->with('no', 'Có lỗi xảy ra, vui lòng kiểm tra lại');
    }
}
