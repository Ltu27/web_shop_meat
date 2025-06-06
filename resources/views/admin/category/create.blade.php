@extends('master.admin')
@section('title', 'Thêm mới danh mục')
@section('main')
<div class="row">
    <div class="col-md-4">
        <form action="{{ route('category.store') }}" method="POST" role="form">
            @csrf
            <div class="form-group">
                <label for="">Tên danh mục</label>
                <input type="text" name="name" class="form-control" id="" placeholder="Input fieald">
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
                        <input type="radio" name="status" id="input" value="0" checked>
                        Ẩn 
                    </label>
                </div>
            </div>

            <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i>Lưu</button>
        </form>
        
    </div>
</div>    

    
@stop