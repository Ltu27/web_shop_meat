@extends('master.main')

@section('title', 'Thông tin')
@section('main')
    
<!-- main-area -->
<main>

    <!-- breadcrumb-area -->
    <section class="breadcrumb-area tg-motion-effects breadcrumb-bg" data-background="uploads/bg/chup_anh_my_pham.webp">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-content">
                        <h2 class="title">Về chúng tôi</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index-2.html">Trang chủ</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Về chúng tôi</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb-area-end -->

    <!-- choose-area -->
    <section class="choose-area choose-area-two choose-bg" data-background="uploads/bg/choose_bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-center mb-50">
                        <span class="sub-title">Về THE FACE SHOP</span>
                        <h2 class="title">Tại sao chọn chúng tôi</h2>
                        <div class="title-shape" data-background="uploads/images/title_shape.png"></div>
                    </div>
                </div>
            </div>
            <div class="choose-item-wrap">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6">
                        <div class="choose-item">
                            <div class="choose-shape">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 408 325"  preserveAspectRatio="none">
                                    <path d="M330.5,2316h368a20,20,0,0,1,20,20l-29,285a20,20,0,0,1-20,20h-299a20,20,0,0,1-20-20l-40-285A20,20,0,0,1,330.5,2316Z" transform="translate(-310.5 -2316)" />
                                </svg>
                            </div>
                            <div class="choose-icon">
                                <i class="flaticon-online-shop"></i>
                            </div>
                            <div class="choose-content">
                                <div class="line" data-background="uploads/images/line.png"></div>
                                <h2 class="title">Chất lượng sản phẩm</h2>
                                <p>Chúng tôi cung cấp những loại thịt tươi ngon, an toàn và chất lượng cao. Với nguồn cung ứng đáng tin cậy và  thịt luôn được bảo quản đúng cách để duy trì chất lượng.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="choose-item">
                            <div class="choose-shape">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 408 325"  preserveAspectRatio="none">
                                    <path d="M330.5,2316h368a20,20,0,0,1,20,20l-29,285a20,20,0,0,1-20,20h-299a20,20,0,0,1-20-20l-40-285A20,20,0,0,1,330.5,2316Z" transform="translate(-310.5 -2316)" />
                                </svg>
                            </div>
                            <div class="choose-icon">
                                <i class="flaticon-chicken-1"></i>
                            </div>
                            <div class="choose-content">
                                <div class="line" data-background="uploads/images/line.png"></div>
                                <h2 class="title">Dịch vụ chuyên nghiệp</h2>
                                <p>Dịch vụ chuyên nghiệp và thân thiện, nhân viên có kiến thức về các loại thịt, cách chế biến và tư vấn cho khách hàng.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="choose-item">
                            <div class="choose-shape">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 408 325"  preserveAspectRatio="none">
                                    <path d="M330.5,2316h368a20,20,0,0,1,20,20l-29,285a20,20,0,0,1-20,20h-299a20,20,0,0,1-20-20l-40-285A20,20,0,0,1,330.5,2316Z" transform="translate(-310.5 -2316)" />
                                </svg>
                            </div>
                            <div class="choose-icon">
                                <i class="flaticon-chicken-wings"></i>
                            </div>
                            <div class="choose-content">
                                <div class="line" data-background="uploads/images/line.png"></div>
                                <h2 class="title">Đa dạng sản phẩm và dịch vụ</h2>
                                <p>Các sản phẩm và dịch vụ đa dạng, bán các loại thịt tươi sống, thịt đã chế biến sẵn, các loại gia vị và phụ kiện đi kèm.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- choose-area-end -->

    <!-- faq-area -->
    <section class="faq-area tg-motion-effects faq-bg" data-background="uploads/bg/faq_bg.jpg">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-6 col-md-10">
                    <div class="faq-img-wrap">
                        <img src="uploads/images/faq_img01.png" alt="">
                        <img src="uploads/images/faq_img02.png" alt="">
                        <img src="uploads/images/faq_img03.png" alt="">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="faq-content">
                        <div class="section-title mb-60">
                            <span class="sub-title">Ý kiến khách hàng</span>
                            <h2 class="title">Những <span>câu hỏi</span> thường gặp.</h2>
                        </div>
                        <div class="faq-wrap">
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            Thịt cam kết 100% tười sống.
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>Thị được cung cấp từ những nguồn cung uy tín nhất.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            Có phải thịt sạch không?
                                        </button>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>Trang trại nuôi trồng sạch sẽ, thịt không chất bảo quản.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="faq-shape-wrap">
            <img src="uploads/images/faq_shape01.png" alt="" class="tg-motion-effects3">
            <img src="uploads/images/faq_shape02.png" alt="" class="tg-motion-effects2">
        </div>
    </section>
    <!-- faq-area-end -->

</main>
<!-- main-area-end -->

@stop()