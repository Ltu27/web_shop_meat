@extends('master.main')
@section('title', 'Đăng ký')
@section('main')
    
<!-- main-area -->
<main>

    <!-- breadcrumb-area -->
    <section class="breadcrumb-area tg-motion-effects breadcrumb-bg" data-background="uploads/bg/chup_anh_my_pham.webp">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-content">
                        <h2 class="title">Đăng ký</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Trang chủ</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Đăng ký</li>
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
                                <span class="sub-title">Đăng ký</span>
                            </div>
                            <form action="" method="POST">
                                @csrf
                                <div class="contact-form-wrap">
                                    <div class="form-grp">
                                        <input name="name" type="text" placeholder="Tên của bạn *" value="{{ old('name') }}">
                                        @error('name')
                                            <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-grp">
                                        <input name="email" type="email" placeholder="email của bạn *" value="{{ old('email') }}">
                                        @error('email')
                                            <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-grp">
                                        <input name="phone" type="text" placeholder="Số điện thoại của bạn *" value="{{ old('phone') }}">
                                        @error('phone')
                                            <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-grp">
                                        <input name="address" type="text" placeholder="Địa chỉ của bạn *" value="{{ old('address') }}">
                                        @error('address')
                                            <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-grp">
                                        <select name="gender" class="form-control">
                                            <option value="1">Nam</option>
                                            <option value="0">Nữ</option>
                                        </select>
                                    </div>
                                    <div class="form-grp">
                                        <input name="password" type="password" placeholder="Mật khẩu của bạn *">
                                        @error('password')
                                            <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-grp">
                                        <input name="confirm_password" type="password" placeholder="Nhập lại mật khẩu *">
                                        @error('confirm_password')
                                            <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit">Tạo tài khoản</button>
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