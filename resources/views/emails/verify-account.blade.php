<h3>Dear {{ $account->name }}</h3>
<?php
?>
<p>Bạn vừa tạo tài khoản tại Bemet. Hãy xác nhận để tạo tài khoản thành công.</p>
<p>
    <a href="{{ route('account.verify', $account->email) }}">Ấn vào đây để xác nhận tạo tài khoản</a>
</p>