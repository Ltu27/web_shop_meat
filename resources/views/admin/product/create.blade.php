@extends('master.admin')
@section('title', 'Thêm mới sản phẩm')
@section('main')
<form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
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
                <textarea name="description" id="note-editable" value="{{ old('description') }}" class="form-control description" placeholder="Product content">{{ old('description') }}</textarea>
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
            {{-- <div class="form-group">
                <label for="">Giá sản phẩm</label>
                <input type="text" name="price" value="{{ old('price') }}" class="form-control" id="" placeholder="Nhập dữ liệu">
                @error('price')
                    <span class="help-block has-error text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="">Số lượng</label>
                <input type="text" name="quantity" value="{{ old('quantity') }}" class="form-control" id="" placeholder="Nhập dữ liệu">
                @error('quantity')
                    <span class="help-block has-error text-danger">{{ $message }}</span>
                @enderror
            </div> --}}
            {{-- <div class="form-group">
                <label for="">Giá khuyến mãi</label>
                <input type="text" name="sale_price" value="{{ old('sale_price') }}" class="form-control" id="" placeholder="Nhập dữ liệu">
                @error('sale_price')
                    <span class="help-block has-error text-danger">{{ $message }}</span>
                @enderror
            </div> --}}
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
                        <input type="radio" name="status" id="input" value="0">
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
        </div>
    </div>  
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Thêm thuộc tính</h3>
            <div class="text-right">
                <button type="button" id="addVariantRow" class="btn btn-success">Thêm thuộc tính</button>
            </div>
        </div>
        <div class="box-body">
            <div id="variantList">
                <!-- Dòng mẫu -->
                <div class="row variant-row template" style="display:none;">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Chọn màu:</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="color" class="form-control colorPicker" style="width:40px; padding:0; height:34px;" value="#ff0000">
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="variants[0][variant_color]" class="form-control variant_color" placeholder="Nhập mã màu">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label>Giá sản phẩm</label>
                        <input type="text" name="variants[0][variant_price]" class="form-control variant_price" placeholder="Nhập giá">
                    </div>
                    <div class="col-md-2">
                        <label>Số lượng</label>
                        <input type="text" name="variants[0][stock_quantity]" class="form-control stock_quantity" placeholder="Nhập SL">
                    </div>
                    <div class="col-md-3">
                        <label>Ngày sản xuất</label>
                        <input type="date" name="variants[0][production_date]" class="form-control production_date">
                    </div>
                    <div class="col-md-2">
                        <label>Ngày hết hạn</label>
                        <input type="date" name="variants[0][expiration_date]" class="form-control expiration_date">
                    </div>
                    <div class="col-md-1">
                        <label>&nbsp;</label>
                        <button class="btn btn-danger btn-block removeRow"><i class="fa fa-trash"></i></button>
                    </div>
                </div>
            </div> 
        </div>
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
<script>
    $(document).ready(function () {
        $(document).on('change', '.colorPicker', function () {
            $(this).closest('.variant-row').find('.variant_color').val($(this).val());
        });

        $(document).on('input', '.variant_color', function () {
            const hex = $(this).val();
            if (/^#([0-9A-F]{3}){1,2}$/i.test(hex)) {
                $(this).closest('.variant-row').find('.colorPicker').val(hex);
            }
        });

        $('#addVariantRow').on('click', function () {
            const $template = $('.variant-row.template');
            const index = $('#variantList .variant-row').not('.template').length;

            const $newRow = $template.clone().removeClass('template').css('display', 'flex');
            $newRow.find('.variant_color').attr('name', `variants[${index}][variant_color]`).val('');
            $newRow.find('.variant_price').attr('name', `variants[${index}][variant_price]`).val('');
            $newRow.find('.stock_quantity').attr('name', `variants[${index}][stock_quantity]`).val('');
            $newRow.find('.production_date').attr('name', `variants[${index}][production_date]`).val('');
            $newRow.find('.expiration_date').attr('name', `variants[${index}][expiration_date]`).val('');

            $('#variantList').append($newRow);
        });

        $(document).on('click', '.removeRow', function () {
            if ($('.variant-row').length > 1) {
                $(this).closest('.variant-row').remove();
            } else {
                alert("Phải có ít nhất một dòng!");
            }
        });

    });
</script>
@stop()