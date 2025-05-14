@extends ('clients.index')
@section('content')

<div class="col-md-12 box-concept-detail">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="col-md-12">
                <div class="row">
                    <div class="content-concept-detail text-center">
                        <h4>BÁO GIÁ CHỤP HÌNH <strong>{{ mb_strtoupper($concept->name, 'UTF-8') }}</strong> TẠI 4VIEWS STUDIO</h4>
                        <p>{{ $concept->short_content }}</p>
                    </div>
                    <div class="image-concept-detail text-center">
                        @php
                        $mainImage = glob(public_path("image/concepts/concept_{$concept->id}/main_images/main_image.*"));
                        @endphp
                        @if (!empty($mainImage))
                        <img src="{{ asset(str_replace(public_path(), '', $mainImage[0])) }}" alt="Ảnh chính" title="Ảnh chụp {{ $concept->name }} độc lạ tại 4Views Studio">
                        @else
                        <img src="{{ asset('image/avt.png') }}" alt="Ảnh mặc định" class="image-concept">
                        @endif
                    </div>
                    <div class="concept-detail">
                        <h5><strong>
                                Giới thiệu dịch vụ chụp ảnh {{ $concept->name }} tại 4Views Studio
                            </strong></h5>
                        <p class="margin-top-20">
                            <strong>{{ $concept->name }}</strong>
                            {{ $concept->content }}
                        </p>
                        <div class="col-md-12">
                            <div class="row">
                                @php
                                $supportImages = glob(public_path("image/concepts/concept_{$concept->id}/support_images/*"));
                                @endphp
                                @foreach($supportImages as $image)
                                <div class="col-md-4 concept-images">
                                    <img src="{{ asset(str_replace(public_path(), '', $image)) }}" alt="Ảnh phụ" title="Ảnh chụp {{ $concept->name }} độc lạ tại 4Views Studio">
                                </div>
                                @endforeach
                            </div>
                        </div>

                        @include('clients.layouts.concept-bonus')

                        <h5 class="margin-top-20"><strong>
                                Báo giá chụp hình {{ $concept->name }} tại 4Views studio
                            </strong></h5>
                        <p>Bảng giá bên dưới được <b>4Views Studio</b> thiết kế chụp trong studio hoặc ngoại cảnh,
                            bạn tham khảo sơ qua rồi liên hệ với nhân viên tư vấn. Tùy theo mỗi concept mà
                            có những phục trang hoặc phụ kiện đi kèm thì sẽ có mức giá khác nhau nhé !!!</p>
                        <div class="col-md-12 box-price-concept">
                            <div class="row">
                                <div class="col-md-5 concept-support">
                                    <p><i class="fa-solid fa-circle-check" style="color: #43a7f4;"></i>
                                        Hỗ trợ phụ kiện khi chụp hình (tùy theo concept)
                                    </p>
                                    <p><i class="fa-solid fa-circle-check" style="color: #43a7f4;"></i>
                                        Số lượng ảnh chụp theo thống nhất với Khách hàng
                                    </p>
                                    <p><i class="fa-solid fa-circle-check" style="color: #43a7f4;"></i>
                                        Chỉnh sửa photoshop hoàn thiện
                                    </p>
                                    <p><i class="fa-solid fa-circle-check" style="color: #43a7f4;"></i>
                                        Ekip bao gồm: 1 nhiếp ảnh, 1 trợ lý ánh sáng
                                    </p>
                                    <p><i class="fa-solid fa-circle-check" style="color: #43a7f4;"></i>
                                        Chụp tại địa điểm theo concept, chat với tư vấn viên trước
                                    </p>
                                </div>
                                <div class="col-md-6 concept-price text-center">
                                    <h3>{{ number_format($concept->price, 0, ',', '.') }} VNĐ</h3>
                                    <a href="{{ url('/clients/booking?concept_id='.$concept->id) }}">
                                        <button>Đặt lịch ngay</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
</div>
@endsection

<style>
    .box-concept-detail {
        background: linear-gradient(to bottom, #fff8e1, white);
    }
    .image-concept-detail {
        margin: 30px;
    }

    .margin-top-20 {
        margin-top: 20px;
    }

    .row {
        display: flex;
    }
    .content-concept-detail h4{
        margin-top: 20px;
    }
    .concept-images img {
        width: 100%;
        height: auto;
        border-radius: 5px;
        margin-top: 10px;
        margin-bottom: 10px;
    }

    .box-price-concept {
        background-color: #ececec;
        border-radius: 3px;
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .box-price-concept .row {
        display: flex;
        align-items: center;
    }

    .box-price-concept p {
        margin: 10px 0;
        font-size: 16px;
    }

    .concept-support {
        margin-left: 10px;
    }

    .concept-price {
        margin-left: 70px;
    }

    .concept-price h3 {
        margin-bottom: 20px;
    }

    .concept-price button {
        padding: 10px 20px;
        font-size: 16px;
        background-color: #007BFF;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .concept-price button {
        background-color: #0056b3;
    }
</style>