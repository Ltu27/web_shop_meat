@extends('master.admin')
@section('title', 'Chỉnh sửa người dùng')
@section('main')
<div class="row">
    <form action="{{ route('user.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="col-md-9">
            <div class="form-group">
                <label for="">Tên người dùng</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" id="" placeholder="Nhập thông tin">
                @error('name')
                    <span class="help-block has-error text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" id="" placeholder="Nhập thông tin">
                @error('email')
                    <span class="help-block has-error text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="">Số điện thoại</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control" id="" placeholder="Nhập thông tin">
                @error('phone')
                    <span class="help-block has-error text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="">Địa chỉ</label>
                <textarea name="address" value="{{ old('address', $user->address) }}" class="form-control" placeholder="Nhập địa chỉ"></textarea>
                @error('address')
                    <span class="help-block has-error text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Mật khẩu</label>
                <input type="password" name="password" class="form-control" id="" placeholder="Nhập mật khẩu">
                @error('password')
                    <span class="help-block has-error text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Xác nhận mật khẩu</label>
                <input type="password" name="confirm_password" class="form-control" id="" placeholder="Nhập mật khẩu">
            </div>
            <div class="form-group">
                <label for="">Giới tính</label>
                <div class="radio">
                    <label>
                        <input type="radio" name="gender" id="input" value="1" checked>
                        Nam
                    </label>
                </div>

                <div class="radio">
                    <label>
                        <input type="radio" name="gender" id="input" value="0">
                        Nữ
                    </label>
                </div>
            </div>
            <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i>Lưu</button>
        </div>
    </form>
        
</div>    

    
@stop