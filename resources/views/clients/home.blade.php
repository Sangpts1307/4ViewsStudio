@extends ('clients.index')
@section('content')
@include('clients.layouts.slider')


<div class="col-md-12">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8 info">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="col-md-12 padding-top-20 ">
                            <div class="row">
                                <div class="col-md-2 icon-center">
                                    <i class="fa-solid fa-map-location size-icon"></i>
                                </div>
                                <div class="col-md-10">
                                    <h4>ĐỊA CHỈ</h4>
                                    <p>Cơ sở 1: Km 10, Đường Trần Phú, phường Văn Quán, quận Hà Đông, thành phố Hà Nội</p>
                                    <p>Cơ sở 2: Km 10, Đường Trần Phú, phường Văn Quán, quận Hà Đông, thành phố Hà Nội</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box-time-working">
                            <h4>THỜI GIAN LÀM VIỆC</h4>
                            <p><i class="fa-regular fa-clock"></i> Thứ 2 ..................... 7:30 AM - 8:30 PM</p>
                            <p><i class="fa-regular fa-clock"></i> Thứ 3 ..................... 7:30 AM - 8:30 PM</p>
                            <p><i class="fa-regular fa-clock"></i> Thứ 4 ..................... 7:30 AM - 8:30 PM</p>
                            <p><i class="fa-regular fa-clock"></i> Thứ 5 ..................... 7:30 AM - 8:30 PM</p>
                            <p><i class="fa-regular fa-clock"></i> Thứ 6 ..................... 7:30 AM - 8:30 PM</p>
                            <p><i class="fa-regular fa-clock"></i> Thứ 7 - CN .......... 7:30 AM - 7:00 PM</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="col-md-12 padding-top-20 ">
                            <div class="row">
                                <div class="col-md-2 icon-center">
                                    <i class="fa-solid fa-mobile size-icon"></i>
                                </div>
                                <div class="col-md-10">
                                    <h4>TRUNG TÂM TƯ VẤN</h4>
                                    <p>Moblie: 1322131223</p>
                                    <p>Facebook: </p>
                                    <p>Instagram: </p>
                                    <p>Gmail: phamthesang1307@gmail.com</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
        @include('clients.layouts.concept-layout')
    </div>
</div>
@endsection


<style>
    .size-icon {
        font-size: 50px;
        color: #000;
    }


    .icon-center {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100px;
    }


    .box-time-working {
        background: linear-gradient(to bottom, #e0f5e5, #fff8e1);
        padding: 20px;
        text-align: center;
    }

    .mar-top-10 {
        margin-top: 10px;
    }

    .padding-top-20 {
        padding-top: 20px;
    }
</style>