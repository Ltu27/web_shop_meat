<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Mail\ForgotPassword;
use App\Mail\VerifyAccount;
use App\Models\Customer;
use App\Models\CustomerResetToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\Favorite;
use App\Services\Customer\Auth\AuthService;

class AccountController extends Controller
{
    public function __construct(
        protected AuthService $authService,
    ) {
        
    }

    public function login() {
        return view('account.login');
    }

    public function favorite() {
        $favorites = auth('cus')->user()->favorites ? auth('cus')->user()->favorites : [];
        return view('account.favorite', compact('favorites'));
    }

    public function logout() {
        auth('cus')->logout();
        return redirect()->route('account.login')->with('ok', 'Bạn đã đăng xuất!');
    }

    public function check_login(LoginRequest $req) {
        $data = $req->validated();

        $check = auth('cus')->attempt($data);

        if($check) {
            // if(!$this->authService->checkVerify($data['email'])) {
            //     auth('cus')->logout();
            //     return redirect()->back()->with('no', 'Tài khoản của bạn chưa được xác minh, hãy kiểm tra lại email!');
            // }

            return redirect()->route('home.index')->with('ok', 'Chào mừng trở lại!');
        }

        return redirect()->back()->with('no', 'Tài khoản hoặc mật khẩu không đúng!');

    }

    public function register() {
        return view('account.register');
    }

    public function check_register(Request $req) {
        $req->validate([
            'name' => 'required|min:6|max:100',
            'email' => 'required|email|min:6|max:100|unique:customers',
            'phone' => 'required|min:6|unique:customers',
            'address' => 'required|min:4',
            'gender' => 'required',
            'password' => 'required|min:4',
            'confirm_password' => 'required|same:password',
        ], [
            'name.required' => 'Họ tên không được để trống',
            'name.min' => 'Họ tên tối thiểu 6 ký tự',
            'name.max' => 'Họ tên tối đa 100 ký tự',
            'email.required' => 'Email không được để trống',
            'email.min' => 'Email tối thiểu 6 ký tự',
            'email.max' => 'Email tối đa 100 ký tự',
            'email.unique' => 'Email đã được đăng ký',
            'phone.required' => 'Số điện thoại không được để trống',
            'phone.min' => 'Số điện thoại tối thiểu 6 ký tự',
            'phone.unique' => 'Số điện thoại đã được đăng ký',
            'address.required' => 'Địa chỉ không được để trống',
            'address.min' => 'Địa chỉ tối thiểu 4 ký tự',
            'gender.required' => 'Giới tính không được để trống',
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu tối thiểu 4 ký tự',
            'confirm_password.required' => 'Mật khẩu không đúng',
            'confirm_password.same' => 'Mật khẩu không đúng',
        ]);

        $data = $req->only('name', 'email', 'phone', 'address', 'gender');

        $data['password'] = bcrypt($req->password);

        $data['email_verified_at'] = date('Y-m-d');
        if ($acc = Customer::create($data)) {
            // Mail::to($acc->email)->send(new VerifyAccount($acc));
            return redirect()->route('account.login')->with('ok', 'Register successfully, please check your email to verify account');
        }

        return redirect()->back()->with('no', 'Something error, please try again');
    }

    public function verify($email) {
        $acc = Customer::where('email', $email)->whereNull('email_verified_at')->firstOrFail();
        Customer::where('email', $email)->update(['email_verified_at' => date('Y-m-d')]);
        return redirect()->route('account.login')->with('ok', 'Verify account successfully, you can login now');
    }

    public function change_password() {
        return view('account.change_password');
    }

    public function check_change_password(Request $req) {
        $auth = auth('cus')->user();
        $req->validate([
            'old_password' => ['required', function($attr, $value, $fail) use($auth) {
                if (!Hash::check($value, $auth->password)) {
                    $fail('Your password is not match');
                }
            }],
            'password' => 'required|min:4',
            'confirm_password' => 'required|same:password'
        ]);

        $data['password'] = bcrypt($req->password);

        if ($auth->update($data)) {
            auth('cus')->logout();
            return redirect()->route('account.login')->with('ok', 'Update your password successfully');
        }
        return redirect()->back()->with('no', 'Something error, please check again');
    }

    public function forgot_password() {
        return view('account.forgot_password');
    }

    public function check_forgot_password(Request $req) {
        $req->validate([
            'email' => 'required|exists:customers'
        ]);

        $customer = Customer::where('email', $req->email)->first();

        $token = Str::random(40);
        $tokenData = [
            'email' => $req->email,
            'token' => $token
        ];
        
        if (CustomerResetToken::create($tokenData)) {
            Mail::to($req->email)->send(new ForgotPassword($customer, $token));
            return redirect()->back()->with('ok', 'Send mail successfully, please check email to continue');
        }
        return redirect()->back()->with('no', 'Something error, please check again');

    }

    public function profile() {
        $auth = auth('cus')->user();
        return view('account.profile', compact('auth'));
    }

    public function check_profile(Request $req) {
        $auth = auth('cus')->user();
        $req->validate([
            'name' => 'required|min:6|max:100',
            'email' => 'required|email|min:6|max:100|unique:customers,email,'.$auth->id,
            'phone' => 'required|min:6|unique:customers,phone,'.$auth->id,
            'address' => 'required|min:4',
            'gender' => 'required',
            'password' => ['required', function($attr, $value, $fail) use($auth) {
                if (!Hash::check($value, $auth->password)) {
                    return $fail('Your password is not much');
                }
            }],
        ], [
            'name.required' => 'Họ tên không được để trống',
            'name.min' => 'Họ tên tối thiểu 6 ký tự',
            'name.max' => 'Họ tên tối đa 100 ký tự',
            'email.required' => 'Email không được để trống',
            'email.min' => 'Email tối thiểu 6 ký tự',
            'email.max' => 'Email tối đa 100 ký tự',
            'email.unique' => 'Email đã được đăng ký',
            'phone.required' => 'Số điện thoại không được để trống',
            'phone.min' => 'Số điện thoại tối thiểu 6 ký tự',
            'phone.unique' => 'Số điện thoại đã được đăng ký',
            'address.required' => 'Địa chỉ không được để trống',
            'address.min' => 'Địa chỉ tối thiểu 4 ký tự',
            'gender.required' => 'Giới tính không được để trống',
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu tối thiểu 4 ký tự',
        ]);

        $data = $req->only('name', 'email', 'phone', 'address', 'gender');

        $check = $auth->update($data);
        if ($check) {
            return redirect()->back()->with('ok', 'Update your profile successfully');
        }
        return redirect()->back()->with('no', 'Something error, please check again');
    }

    public function reset_password($token) {
        $tokenData = CustomerResetToken::checkToken($token);

        return view('account.reset_password');
    }

    public function check_reset_password($token) {
        request()->validate([
            'password' => 'required|min:4',
            'confirm_password' => 'required|same:password'
        ]);

        $tokenData = CustomerResetToken::checkToken($token);
        $customer = $tokenData->customer;

        $data = [
            'password' => bcrypt(request('password'))
        ];
        
        $check = $customer->update($data);
        if ($check) {
            return redirect()->back()->with('ok', 'Reset your password successfully');
        }
        return redirect()->back()->with('no', 'Something error, please check again');
    }
}
