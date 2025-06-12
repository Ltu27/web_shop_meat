<div class="modal fade" id="optionModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                <h4 class="modal-title">Màu sắc</h4>
            </div>
            <div class="modal-body">
                <div id="variantList">
                    <!-- Dòng mẫu -->
                    <div class="text-right">
                        <button type="button" id="addVariantRow" class="btn btn-success">Thêm thuộc tính</button>
                    </div>
                    <div class="row variant-row template" style="display:none">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Chọn màu:</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="color" class="form-control colorPicker" style="width:40px; padding:0; height:34px;" value="#ff0000">
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control variant_color" placeholder="Nhập mã màu">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label>Giá sản phẩm</label>
                            <input type="text" class="form-control variant_price" placeholder="Nhập giá">
                        </div>
                        <div class="col-md-2">
                            <label>Số lượng</label>
                            <input type="text" class="form-control stock_quantity" placeholder="Nhập SL">
                        </div>
                        <div class="col-md-3">
                            <label>Ngày sản xuất</label>
                            <input type="date" class="form-control production_date">
                        </div>
                        <div class="col-md-2">
                            <label>Ngày hết hạn</label>
                            <input type="date" class="form-control expiration_date">
                        </div>
                        <div class="col-md-1">
                            <label>&nbsp;</label>
                            <button class="btn btn-danger btn-block removeRow"><i class="fa fa-trash"></i></button>
                        </div>
                    </div>
                </div>
                <hr>

                <!-- Nút lưu -->
                <button type="button" id="saveColorBtn" class="btn btn-primary btn-block">Lưu</button>
            </div>
        </div>
    </div>
</div>
