<?php

namespace App\Http\Controllers\Admin;

use App\Constants\OrderConstant;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginAdminRequest;
use App\Models\Order;
use App\Services\ChartService;
use Carbon\Carbon;
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
        $topStockProducts = $this->chartService->getTopStockProducts();
        $topSellingProducts = $this->chartService->getTopSellingProducts();

        return view('admin.index', compact(
            'totalProducts',
            'totalConfirmedOrder',
            'totalPaidOrder',
            'totalCancelOrder',
            'topStockProducts',
            'topSellingProducts'
        ));
    }

    public function getChartOrder(Request $request)
    {
        $type = $request->get('type', 'year');
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        if ($type === 'month') {
            $daysInMonth = Carbon::create($year, $month, 1)->daysInMonth;
            $result = [];
            $labels = [];

            for ($d = 1; $d <= $daysInMonth; $d++) {
                $revenue = Order::whereDay('created_at', $d)
                    ->whereMonth('created_at', $month)
                    ->whereYear('created_at', $year)
                    ->whereIn('status', [3, 4])
                    ->with('details')
                    ->get()
                    ->flatMap->details
                    ->sum(function ($detail) {
                        return $detail->price * $detail->quantity;
                    });
                $result[] = round($revenue / 1000);
                $labels[] = (string)$d;
            }

            return response()->json([
                'labels' => $labels,
                'data' => $result
            ]);
        } else {
            // Thống kê theo năm: từng tháng
            $result = [];
            for ($m = 1; $m <= 12; $m++) {
                $revenue = Order::whereMonth('created_at', $m)
                    ->whereYear('created_at', $year)
                    ->whereIn('status', [3, 4])
                    ->with('details')
                    ->get()
                    ->flatMap->details
                    ->sum(function ($detail) {
                        return $detail->price * $detail->quantity;
                    });
                $result[] = round($revenue / 1000); // Đơn vị: nghìn đồng
            }

            return response()->json([
                'labels' => ['T1','T2','T3','T4','T5','T6','T7','T8','T9','T10','T11','T12'],
                'data' => $result
            ]);
        } 
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
