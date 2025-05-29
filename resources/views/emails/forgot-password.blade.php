<div style="border: 3px solid green; padding: 15px; background: lightgreen; width: 600px; margin: auto">
    <h3>Dear {{ $customer->name }}</h3>
    <p>Bạn vừa xác nhận quên mật khẩu cho tài khoản trang THE FACE SHOP.</p>
    <p>
        <a href="{{ route('account.reset_password', $token) }}" style="display: inline-block; padding: 7px 25px; color: #fff; background: darkblue">Ấn vào đây để lấy mật khẩu mới</a>
    </p>
</div>