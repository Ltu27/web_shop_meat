@extends('master.admin')
@section('title', 'Cập nhật mã giảm giá')
@section('main')
    <form action="{{ route('coupon.update', $coupon->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label for="">Mã giảm giá</label>
                    <input type="text" name="code" value="{{ old('code', $coupon->code ?? '') }}" class="form-control input-val" placeholder="Nhập dữ liệu">
                    @error('code')
                        <span class="help-block has-error text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Tỉ lệ giảm giá</label>
                    <input type="text" name="discount" value="{{ old('discount', $coupon->discount ?? '') }}" class="form-control input-val" placeholder="Nhập dữ liệu">
                    @error('discount')
                        <span class="help-block has-error text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Số lượng</label>
                    <input type="text" name="quantity" value="{{ old('quantity', $coupon->quantity ?? '') }}" class="form-control input-val" placeholder="Nhập dữ liệu">
                    @error('quantity')
                        <span class="help-block has-error text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">Ngày hết hạn</label>
                    <input type="datetime-local" name="end_date" value="{{ old('end_date', isset($coupon->end_date) ? \Carbon\Carbon::parse($coupon->end_date)->format('Y-m-d\TH:i') : '') }}" class="form-control input-val">
                    @error('end_date')
                        <span class="help-block has-error text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Trạng thái</label>
                    <div class="radio">
                        <label>
                            <input type="radio" name="status" value="1" {{ old('status', $coupon->status ?? 1) == 1 ? 'checked' : '' }}>
                            Hoạt động
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="status" value="0" {{ old('status', $coupon->status ?? 1) == 0 ? 'checked' : '' }}>
                            Không hoạt động
                        </label>
                    </div>
                </div>
            </div>
        </div>  
        <div class="box-footer text-right">
            <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Lưu</button>
        </div>
    </form>
@stop