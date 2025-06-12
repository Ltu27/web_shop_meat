@extends('master.admin')
@section('title', 'Thêm mới mã giảm giá')
@section('main')
<form action="{{ route('coupon.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label for="">Mã giảm giá</label>
                <input type="text" name="code" value="{{ old('code') }}" class="form-control input-val" id="" placeholder="Nhập dữ liệu">
                @error('code')
                    <span class="help-block has-error text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="">Tỉ lệ giảm giá</label>
                <input type="text" name="discount" value="{{ old('discount') }}" class="form-control input-val" id="" placeholder="Nhập dữ liệu">
                @error('discount')
                    <span class="help-block has-error text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="">Số lượng</label>
                <input type="text" name="quantity" value="{{ old('quantity') }}" class="form-control input-val" id="" placeholder="Nhập dữ liệu">
                @error('quantity')
                    <span class="help-block has-error text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="">Ngày hết hạn</label>
                <input type="datetime-local" name="end_date" value="{{ old('end_date') }}" class="form-control input-val" id="" placeholder="Nhập dữ liệu">
                @error('end_date')
                    <span class="help-block has-error text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="">Trạng thái</label>
                <div class="radio">
                    <label>
                        <input type="radio" name="status" id="input" value="1" checked>
                        Hoạt động
                    </label>
                </div>

                <div class="radio">
                    <label>
                        <input type="radio" name="status" id="input" value="0">
                        Không hoặt động
                    </label>
                </div>
            </div>
        </div>
    </div>  
    <div class="box box-primary">
        <div class="box-footer text-right">
            <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i>Lưu</button>
        </div>
    </div>
</form>

    
@stop

@section('css')
<link rel="stylesheet" href="ad_assets/plugins/summernote/summernote.min.css">
@stop()

@section('js')
<script src="ad_assets/plugins/summernote/summernote.min.js"></script>
@stop()