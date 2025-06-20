@extends('master.admin')
@section('title', 'Thêm mới bài viết')
@section('main')
<form action="{{ route('blog.store') }}" method="POST" role="form">
    @csrf
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="">Tên bài viết</label>
                <input type="text" value="{{ old('name') }}" name="name" class="form-control" id="" placeholder="Nhập dữ liệu">
                @error('name')
                    <span class="help-block has-error text-danger">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="">Trạng thái</label>
                <div class="radio">
                    <label>
                        <input type="radio" name="status" id="input" value="1" checked>
                        Hiển thị
                    </label>
                </div>

                <div class="radio">
                    <label>
                        <input type="radio" name="status" id="input" value="0">
                        Ẩn 
                    </label>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="form-grou[">
                <label for="">Nội dung</label>
                <textarea name="description" value="{{ old('description') }}" class="form-control" placeholder="Nhập dữ liệu"></textarea>
                @error('description')
                    <span class="help-block has-error text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>    
    <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i>Lưu</button>
</form>

    
@stop