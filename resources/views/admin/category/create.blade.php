@extends('master.admin')
@section('title', 'Create a new category')
@section('main')
<div class="row">
    <div class="col-md-4">
        <form action="{{ route('category.store') }}" method="POST" role="form">
            @csrf
            <div class="form-group">
                <label for="">Category name</label>
                <input type="text" name="name" class="form-control" id="" placeholder="Input fieald">
            </div>

            <div class="form-group">
                <label for="">Category Status</label>
                <div class="radio">
                    <label>
                        <input type="radio" name="status" id="input" value="1" checked>
                        Publish
                    </label>
                </div>

                <div class="radio">
                    <label>
                        <input type="radio" name="status" id="input" value="0" checked>
                        Hidden
                    </label>
                </div>
            </div>

            <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i>Save</button>
        </form>
        
    </div>
</div>    

    
@stop