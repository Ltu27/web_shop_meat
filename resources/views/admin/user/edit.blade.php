@extends('master.admin')
@section('title', 'Chỉnh sửa người dùng')
@section('main')
<div class="row">
    <div class="col-md-4">
        <form action="{{ route('category.update', $category->id) }}" method="POST">
            @csrf 
            @method('PUT')
            <div class="form-group">
                <label for="">Category name</label>
                <input type="text" name="name" class="form-control" value="{{ $category->name }}" id="" >
            </div>

            <div class="form-group">
                <label for="">Category Status</label>
                <div class="radio">
                    <label>
                        <input type="radio" name="status" id="input" value="1" {{ $category->status == 1 ? 'checked' : '' }}>
                        Publish
                    </label>
                </div>

                <div class="radio">
                    <label>
                        <input type="radio" name="status" id="input" value="0" {{ $category->status == 0 ? 'checked' : '' }}>
                        Hidden
                    </label>
                </div>
            </div>

            <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i>Update</button>
        </form>
        
    </div>
</div>    

    
@stop