@extends('master.admin')
@section('title', 'Chỉnh sửa danh mục')
@section('main')
<div class="row">
    <div class="col-md-4">
        <form action="{{ route('category.update', $category->id) }}" method="POST">
            @csrf 
            @method('PUT')
            <div class="form-group">
                <label for="">Tên danh mục</label>
                <input type="text" name="name" class="form-control" value="{{ $category->name }}" id="" >
            </div>

            <div class="form-group">
                <label for="">Trạng thái</label>
                <div class="radio">
                    <label>
                        <input type="radio" name="status" id="input" value="1" {{ $category->status == 1 ? 'checked' : '' }}>
                        Hiển thị
                    </label>
                </div>

                <div class="radio">
                    <label>
                        <input type="radio" name="status" id="input" value="0" {{ $category->status == 0 ? 'checked' : '' }}>
                        Ẩn
                    </label>
                </div>
            </div>

            <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i>Cập nhật</button>
        </form>
        
    </div>
</div>    

    
@stop