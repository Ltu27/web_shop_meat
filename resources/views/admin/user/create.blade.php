@extends('master.admin')
@section('title', 'Thêm mới người dùng')
@section('main')
<div class="row">
    <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="col-md-9">
            <div class="form-group">
                <label for="">Tên người dùng</label>
                <input type="text" name="name" class="form-control" id="" placeholder="Input field">
            </div>
            <div class="form-group">
                <label for="">Email</label>
                <input type="email" name="email" class="form-control" id="" placeholder="Input field">
            </div>
            <div class="form-group">
                <label for="">Số điện thoại</label>
                <input type="text" name="phone" class="form-control" id="" placeholder="Input field">
            </div>
            <div class="form-group">
                <label for="">Địa chỉ</label>
                <textarea name="address" class="form-control" placeholder="Product content"></textarea>
            </div>
        </div>
        <div class="col-md-3">
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
                        <input type="radio" name="status" id="input" value="0" checked>
                        Tắt
                    </label>
                </div>
            </div>
            <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i>Lưu</button>
        </div>
    </form>
</div>    

    
@stop

@section('css')
<link rel="stylesheet" href="ad_assets/plugins/summernote/summernote.min.css">
@stop()

@section('js')
<script src="ad_assets/plugins/summernote/summernote.min.js"></script>
<script>
    $('.description').summernote({
        height: 250
    });

    function showImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
            $('#show_img').attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    function showOtherImage(input) {
        if (input.files && input.files.length) {

            var _html = '';
            for (let i = 0; i < input.files.length; i++) {
                var file = input.files[i];

                var reader = new FileReader();

                reader.onload = function (e) {
                    _html += `
                        <div class="thumbnail col-md-3">
                            <img src="${e.target.result}" alt="" width="100%">
                        </div>
                    `;

                    $('#show_other_img').html(_html)
                };
                reader.readAsDataURL(file);
            }
        }
    }
</script>
@stop()