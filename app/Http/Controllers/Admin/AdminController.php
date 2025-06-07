<?php

namespace App\Http\Controllers\Admin;

use App\Constants\OrderConstant;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginAdminRequest;
use App\Services\ChartService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct(
        protected ChartService $chartService,
    )
    {
    }

    public function index() {
        $totalProducts = $this->chartService->getTotalProducts();
        $totalConfirmedOrder = $this->chartService->getTotalOrderWithStatus(OrderConstant::STATUS_CONFIRMED); 
        $totalPaidOrder = $this->chartService->getTotalOrderWithStatus(OrderConstant::STATUS_PAID); 
        $totalCancelOrder = $this->chartService->getTotalOrderWithStatus(OrderConstant::STATUS_COMPLETED); 
        return view('admin.index', compact(
            'totalProducts',
            'totalConfirmedOrder',
            'totalPaidOrder',
            'totalCancelOrder'
        ));
    }

    public function login() {
        return view('admin.login');
    }

    public function check_login(LoginAdminRequest $req) {
        // $req->validate([
        //     'email' => 'required|email|exists:users',
        //     'password' => 'required'
        // ]);

        $data = $req->only('email', 'password');

        $check = auth()->attempt($data);

        if ($check) {
            return redirect()->route('admin.index')->with('ok', 'Welcome back');
        }

        return redirect()->back()->with('no', 'Your email or password does not match');

    }

    public function logout() {
        auth()->logout();
        return redirect()->route('admin.login')->with('no', 'Logout');
    }
}
