<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = Customer::orderBy('id', 'DESC')->paginate(10);

        return view('admin.user.index', compact('users'));
    }

    public function getListUser()
    {
        $users = Customer::all();
        return response()->json([
            'data' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories'
        ]);

        $data = $request->all();
        Customer::create($data);

        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Category $category)
    // {
    //     return view('admin.category.edit',compact('category'));
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, Category $category)
    // {
    //     $request->validate([
    //         'name' => 'required|unique:categories,name,'.$category->id
    //     ]);

    //     $data = $request->all('name', 'status');
    //     if ($category->update($data)) {
    //         return redirect()->route('category.index')->with('ok', 'Update a category successfully');
    //     }
    //     return redirect()->back()->with('no', 'Something wrong, please try again');

    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Category $category)
    // {
    //     if ($category->delete()) {
    //         return redirect()->route('category.index')->with('ok', 'Delete a category successfully');
    //     }
    //     return redirect()->back()->with('no', 'Something wrong, please try again');
    // }
}
