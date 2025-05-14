@extends ('clients.index')
@section('content')
<div class="khung">
    <div class="container rounded trong-khung">
        <h2 class="text-center mb-5">
            <i class="fa-solid fa-location-dot"></i> LIÊN HỆ
        </h2>
        <div class="row">
            <div class="col-md-6 mb-5">
                <p class="fs-5 mb-4 text-secondary">
                    📸 <strong>4Views Studio</strong> - Top studio chụp ảnh đẹp nhất Hà Nội
                </p>
                <h5 class="fw-semibold mb-3">☎️ Thông tin liên hệ</h5>
                <ul class="list-unstyled text-secondary fs-6">
                    <li><i class="fas fa-map-marker-alt text-primary me-2"></i> Cơ sở 1: Km255, Đ.Trần Phú, Hà Đông, Hà Nội</li>
                    <li><i class="fas fa-map-marker-alt text-primary me-2"></i> Cơ sở 2: …</li>
                    <li><i class="fas fa-envelope text-primary me-2"></i> Email: 4viewsstudio@gmail.com</li>
                    <li><i class="fas fa-user text-primary me-2"></i> Tư vấn viên (Ms. Diệp): 0100 000 000</li>
                    <li><i class="fas fa-phone text-primary me-2"></i> Hotline (Mr. 4Views): 0838 683 86</li>
                </ul>
                <p class="fst-italic text-secondary mt-3">
                    Để được hỗ trợ tư vấn, quý khách có thể nhắn tin qua Zalo hoặc gọi điện trực tiếp. <br>
                    Ngoài ra, có thể sử dụng chức năng đặt lịch chụp để được ưu tiên hơn.
                </p>
            </div>
            <div class="col-md-6">
                <div class="map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3371.20350803031!2d105.78657997471312!3d20.980562389433306!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ade83ba9e115%3A0x6f4fdb5e1e9e39ed!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBLaeG6v24gdHLDumMgSMOgIE7hu5lp!5e1!3m2!1svi!2s!4v1745502008823!5m2!1svi!2s" 
                        width="650" height="450" style="border:0;" 
                        allowfullscreen="" loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
    .khung {
        background-color: #fff8e1;
        padding-top: 3rem;
        padding-bottom: 3rem;
    }
    .trong-khung {
        background-color: white; 
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
        padding: 3rem; 
    }
    .map {
        border-radius: 0.5rem;
        overflow: hidden;
        box-shadow: 0 .125rem .25rem rgba(0, 0, 0, 0.075);
        border: 1px solid #dee2e6;
    }
</style>