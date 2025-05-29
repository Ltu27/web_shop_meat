@extends('master.main')
@section('title', 'Đăng nhập')
@section('main')
    
<!-- main-area -->
<main>

    <!-- breadcrumb-area -->
    <section class="breadcrumb-area tg-motion-effects breadcrumb-bg" data-background="uploads/bg/chup_anh_my_pham.webp">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-content">
                        <h2 class="title">Đăng nhập</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Trang chủ</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Đăng nhập</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb-area-end -->

    <!-- contact-area -->
    <section class="contact-area">
        
        <div class="contact-wrap">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="contact-content">
                            <div class="section-title mb-15">
                                <span class="sub-title">Đăng nhập</span>
                            <form action="" method="POST">
                                @csrf
                                <div class="contact-form-wrap">
                                    <div class="form-grp">
                                        <input name="email" type="email" placeholder="Email của bạn *" value="{{ old('email') }}">
                                        @error('email')
                                            <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-grp">
                                        <input name="password" type="password" placeholder="Mật khẩu *">
                                        @error('password')
                                            <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit">Đăng nhập</button>
                                    <a style="display: block; text-align:center; margin-top:15px" 
                                    href="{{ route('account.register') }}">Tạo tài khoản mới</a>
                                    <a style="display: block; text-align:center; margin-top:15px" 
                                    href="{{ route('account.forgot_password') }}">Quên mật khẩu</a>
                                </div>
                            </form>
                            <p class="ajax-response mb-0"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- contact-area-end -->

</main>
<!-- main-area-end -->


@endsection