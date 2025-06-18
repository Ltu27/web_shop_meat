<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;

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
            'name' => 'required|min:6|max:100',
            'email' => 'required|email|min:6|max:100|unique:customers',
            'phone' => 'required|min:6|unique:customers',
            'address' => 'required|min:4',
            'gender' => 'required',
            'password' => 'required|min:4',
            'confirm_password' => 'required|same:password',
        ]);

        $data = $request->all();
        $data['password'] = bcrypt($request->password);

        $data['email_verified_at'] = date('Y-m-d');

        Customer::create($data);

        return redirect()->route('user.index')->with('ok', 'Tạo mới người dùng thành công!');
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
    public function edit(Customer $user)
    {
        return view('admin.user.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => [
                'required', 'email', 'min:6', 'max:100',
                Rule::unique('customers')->ignore($user->id)
            ],
            'phone' => [
                'required', 'min:6',
                Rule::unique('customers')->ignore($user->id)
            ],
            'address' => 'nullable|min:4',
            'gender' => 'nullable',
            'password' => 'nullable|min:4',
            'confirm_password' => 'nullable|same:password',
        ]);

        $data = $request->all();

        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        } else {
            unset($data['password']);
        }

        if ($user->update($data)) {
            return redirect()->route('user.index')->with('ok', 'Cập nhật người dùng thành công');
        }
        return redirect()->back()->with('no', 'Có lỗi xảy ra');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $user)
    {
        if ($user->delete()) {
            return redirect()->route('user.index')->with('ok', 'Xóa người dùng thành công');
        }
        return redirect()->back()->with('no', 'Có lỗi xảy ra');
    }
}
