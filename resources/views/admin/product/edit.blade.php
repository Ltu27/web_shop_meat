@extends('master.admin')
@section('title', 'Chỉnh sửa sản phẩm' . $product->name)
@section('main')
<div class="row">
    <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="text" id="product_id" value="{{ $product->id }}" hidden>
        <div class="col-md-7">
            <div class="form-group">
                <label for="">Tên sản phẩm</label>
                <input type="text" name="name" class="form-control" value="{{ $product->name }}" placeholder="Nhập dữ liệu">
            </div>
            <div class="form-group">
                <label for="">Danh mục sản phẩm</label>
                <select name="category_id" class="form-control">
                    <option value="">Chọn 1</option>
                    @foreach ($cats as $cat)
                        <option value="{{ $cat->id }}" {{ $cat->id == $product->category_id ? 'selected' : ''}}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="">Mô tả sản phẩm</label>
                <textarea name="description" class="form-control" placeholder="Product content">{{ $product->description }}</textarea>
            </div>
            <div class="form-group">
                <label for="">Ảnh khác của sản phẩm</label>
                <input type="file" name="other_img[]" class="form-control" multiple onchange="showOtherImage(this)">
                <hr>
                <div class="row">
                    @foreach ($product->images as $img)
                    <div class="col-md-3" style="position: relative">
                        <a href="" class="thumbnail">
                            <img src="uploads/product/{{ $img->image }}" alt="">
                        </a>
                        <div class="caption" style="position: absolute; top: 5px; right: 20px">
                            <a onclick="return confirm('Are you sure delete it?')" href="{{ route('product.destroyImage', $img->id) }}" class="btn btn-sm btn-danger">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                <h4>Các ảnh mới chọn sẽ thay thế ảnh cũ trước đó</h4>
                <div class="row" id="show_other_img">
                </div>
            </div>
        </div>
        <div class="col-md-5">
            {{-- <div class="form-group">
                <label for="">Số lượng</label>
                <input type="text" name="quantity" class="form-control" value="{{ old('quantity', $product->quantity) }}" placeholder="Nhập dữ liệu">
                @error('quantity')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="">Giá</label>
                <input type="text" name="price" class="form-control" value="{{ $product->price }}" placeholder="Nhập dữ liệu">
            </div> --}}
            {{-- <div class="form-group">
                <label for="">Giá khuyến mãi</label>
                <input type="text" name="sale_price" class="form-control" value="{{ $product->sale_price }}" placeholder="Nhập dữ liệu">
            </div> --}}
            <div class="form-group">
                <label for="">Trạng thái sản phẩm</label>
                <div class="radio">
                    <label>
                        <input type="radio" name="status" value="1" {{ $product->status == 1 ? 'checked' : ''}}>
                        Kích hoạt
                    </label>
                </div>

                <div class="radio">
                    <label>
                        <input type="radio" name="status" value="0" {{ $product->status == 0 ? 'checked' : ''}}>
                        Ẩn
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label for="">Ảnh sản phẩm</label>
                <input type="file" name="img" class="form-control" onchange="showImage(this)">
                <img src="uploads/product/{{ $product->image }}" width="100%" id="show_img">
            </div>
            <button type="button" class="btn btn-success btn-add-variants" data-id="{{ $product->id }}" 
                data-toggle="modal" data-target="#optionModal">
                Thêm thuộc tính
            </button>
            <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i>Lưu</button>
        </div>
    </form>
</div>    

@include('admin.product.elements.modal-add-varient')
    
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

    function loadProductVariants(variants) {
        const $variantList = $('#variantList');
        $variantList.find('.variant-row:not(.template)').remove(); 

        const $template = $variantList.find('.variant-row.template');

        variants.forEach(variant => {
            const $newRow = $template.clone().removeClass('template').css('display', 'block');

            $newRow.find('.colorPicker').val(variant.variant_color || '#000000');
            $newRow.find('.variant_color').val(variant.variant_color || '');
            $newRow.find('.variant_price').val(variant.variant_price || '');
            $newRow.find('.stock_quantity').val(variant.stock_quantity || '');
            $newRow.find('.production_date').val(variant.production_date || '');
            $newRow.find('.expiration_date').val(variant.expiration_date || '');

            $variantList.append($newRow);
        });
    }

    $('.btn-add-variants').on('click', function () {
        const productId = $(this).data('id');

        $.get(`/api/product/get-variants/${productId}`, function (res) {
            loadProductVariants(res.data);
        });
    });

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
            const $newRow = $template.clone().removeClass('template').css('display', 'block');
            
            $newRow.find('input').val('');
            $('#variantList').append($newRow);
        });

        $(document).on('click', '.removeRow', function () {
            if ($('.variant-row').length > 1) {
                $(this).closest('.variant-row').remove();
            } else {
                alert("Phải có ít nhất một dòng!");
            }
        });

        // Lưu dữ liệu
        $('#saveColorBtn').on('click', function () {
            const variants = [];
            const product_id = $('#product_id').val();

            
            $('.variant-row').not('.template').each(function () {
                variants.push({
                    variant_color: $(this).find('.variant_color').val(),
                    variant_price: $(this).find('.variant_price').val(),
                    stock_quantity: $(this).find('.stock_quantity').val(),
                    production_date: $(this).find('.production_date').val(),
                    expiration_date: $(this).find('.expiration_date').val()
                });
            });

            // Gửi AJAX
            $.ajax({
                url: '/api/product/save-variants',
                method: 'POST',
                data: {
                    product_id: product_id,
                    variants: variants,
                    _token: '{{ csrf_token() }}'
                },
                success: function (res) {
                    $.toast({
                        heading: 'Thành công',
                        text: 'Lưu thành công!',
                        showHideTransition: 'slide',
                        icon: 'success',
                        position: 'top-center',
                    });
                    $('#optionModal').modal('hide');
                    // reset nếu muốn
                },
                error: function (xhr) {
                    const errors = xhr.responseJSON.errors;
                    if (!errors) {
                        $.toast({
                            heading: 'Lỗi',
                            text: 'Đã có lỗi xảy ra!',
                            showHideTransition: 'slide',
                            icon: 'error',
                            position: 'top-center',
                        });
                        return;
                    }

                    // Xóa lỗi cũ
                    $('.variant-row').not('.template').find('.text-danger').remove();

                    // Gắn lỗi mới
                    Object.keys(errors).forEach(function (key) {
                        const match = key.match(/^variants\.(\d+)\.(\w+)$/);
                        if (match) {
                            const index = parseInt(match[1]);
                            const field = match[2];
                            const message = errors[key][0];

                            const row = $('.variant-row').not('.template').eq(index);
                            const input = row.find(`.${field}`);
                            if (input.length) {
                                input.after(`<div class="text-danger">${message}</div>`);
                            }
                        }
                    });
                }
            });
        });
    });
</script>
@stop()