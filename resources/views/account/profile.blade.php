@extends('master.main')
@section('title', 'Thông tin cá nhân')
@section('main')
    
<!-- main-area -->
<main>

    <!-- breadcrumb-area -->
    <section class="breadcrumb-area tg-motion-effects breadcrumb-bg" data-background="uploads/bg/chup_anh_my_pham.webp">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-content">
                        <h2 class="title">Thông tin cá nhân</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Trang chủ</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Thông tin cá nhân</li>
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
                                <span class="sub-title">Cập nhật thông tin cá nhân</span>
                            </div>
                            <form action="" method="POST">
                                @csrf
                                <div class="contact-form-wrap">
                                    <div class="form-grp">
                                        <input name="name" value="{{ $auth->name }}" type="text" placeholder="Tên của bạn *" required>
                                        @error('name')
                                            <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-grp">
                                        <input name="email" value="{{ $auth->email }}" type="email" placeholder="Email của bạn *" required>
                                        @error('email')
                                            <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-grp">
                                        <input name="phone" value="{{ $auth->phone }}" type="text" placeholder="Số điện thoại của bạn *" required>
                                        @error('phone')
                                            <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-grp">
                                        <input name="address" value="{{ $auth->address }}" type="text" placeholder="Địa chỉ của bạn *" required>
                                        @error('address')
                                            <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-grp">
                                        <select name="gender" class="form-control">
                                            <option value="">Chọn một</option>
                                            <option value="1" {{ $auth->gender == 1 ? 'selected' : '' }}>Nam</option>
                                            <option value="0" {{ $auth->gender == 0 ? 'selected' : '' }}>Nữ</option>
                                        </select>
                                    </div>
                                    <div class="form-grp">
                                        <input name="password" type="password" placeholder="Mật khẩu của bạn *" required>
                                        @error('password')
                                            <div class="help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit">Cập nhật thông tin cá nhân</button>
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