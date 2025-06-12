@extends('master.admin')
@section('title', 'Thêm mới sản phẩm')
@section('main')
<form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
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
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="">Ngày hết hạn</label>
                <input type="date" name="expired_at" value="{{ old('expired_at') }}" class="form-control input-val" id="" placeholder="Nhập dữ liệu">
                @error('expired_at')
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