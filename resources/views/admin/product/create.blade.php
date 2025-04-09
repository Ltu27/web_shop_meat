@extends('master.admin')
@section('title', 'Thêm mới sản phẩm')
@section('main')
<div class="row">
    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="col-md-9">
            <div class="form-group">
                <label for="">Tên sản phẩm</label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-control input-val" id="" placeholder="Nhập dữ liệu">
                @error('name')
                    <span class="help-block has-error text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="">Mô tả sản phẩm</label>
                <textarea name="description" id="note-editable" value="{{ old('description') }}" class="form-control description" placeholder="Product content"></textarea>
                @error('description')
                    <span class="help-block has-error text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="">Ảnh sản phẩm khác</label>
                <input type="file" name="other_img[]" class="form-control" multiple onchange="showOtherImage(this)">
                <hr>
                <div class="row" id="show_other_img">
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="">Danh mục sản phẩm</label>
                <select name="category_id" class="form-control">
                    <option value="">Chọn 1</option>
                    @foreach ($cats as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <span class="help-block has-error text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="">Giá sản phẩm</label>
                <input type="text" name="price" value="{{ old('price') }}" class="form-control" id="" placeholder="Nhập dữ liệu">
                @error('price')
                    <span class="help-block has-error text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="">Giá khuyến mãi</label>
                <input type="text" name="sale_price" value="{{ old('sale_price') }}" class="form-control" id="" placeholder="Nhập dữ liệu">
                @error('sale_price')
                    <span class="help-block has-error text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="">Trạng thái</label>
                <div class="radio">
                    <label>
                        <input type="radio" name="status" id="input" value="1" checked>
                        Kích hoạt
                    </label>
                </div>

                <div class="radio">
                    <label>
                        <input type="radio" name="status" id="input" value="0" checked>
                        Ẩn
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label for="">Ảnh sản phẩm</label>
                <input type="file" name="img" value="{{ old('img') }}" class="form-control" onchange="showImage(this)">
                @error('img')
                    <span class="help-block has-error text-danger">{{ $message }}</span>
                @enderror
                <img src="" id="show_img" alt="" width="100%">
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
        height: 250,
        callbacks: {
            onInit: function() {
                $(".note-editable").html("<pre>Cải bẹ xanh 400g</pre>");
            }
        }
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