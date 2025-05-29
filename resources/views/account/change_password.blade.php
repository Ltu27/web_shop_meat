@extends('master.main')
@section('title', 'Đổi mật khẩu')
@section('main')
    
<!-- main-area -->
<main>

    <!-- breadcrumb-area -->
    <section class="breadcrumb-area tg-motion-effects breadcrumb-bg" data-background="uploads/bg/chup_anh_my_pham.webp">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-content">
                        <h2 class="title">Đổi mật khẩu</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Trang chủ</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Đổi mật khẩu</li>
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
                                <span class="sub-title">Đổi mật khẩu</span>
                            <form action="" method="POST">
                                @csrf
                                <div class="contact-form-wrap">
                                    <div class="form-grp">
                                        <input name="old_password" type="password" placeholder="Mật khẩu cũ *" required>
                                        @error('old_password')
                                            <small class="help-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-grp">
                                        <input name="password" type="password" placeholder="Mật khẩu mới *" required>
                                        @error('password')
                                            <small class="help-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-grp">
                                        <input name="confirm_password" type="password" placeholder="Nhập lại mật khẩu *" required>
                                        @error('confirm_password')
                                            <small class="help-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <button type="submit">Đổi mật khẩu</button>
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


@stop()