<style>
    ul li a {
        text-decoration: none;
        color: white;
    }

    ul li a:hover {
        color: #a8e6cf;
    }

    .footer-menu {
        margin-top: 10;
        /* bỏ khoảng cách trên của danh sách */
        padding-left: 0;
        /* bỏ padding mặc định của ul */
        list-style: none;
        /* nếu bạn không muốn dấu chấm tròn */
    }
</style>


<div id="footerr" class="col-md-12">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h3>About Us</h3>
                <p> 4Views Studio là viện ảnh lớn ở Tp.Hà Nội, chúng tôi mang đến cho quý khách 
                    đầy đủ các dịch vụ chụp hình hiện có mặt trên thị trường. Chúng tôi có 
                    các cơ sở chính và cơ sở liên kết trên địa bàn Tp.Hà Nội để giúp quý khách 
                    thuận tiện trong việc đi lại và lựa chọn concept chụp ưng ý nhất. Hãy đến 
                    với 4Views Studio để cảm nhận điều đó !!!</p>
            </div>
            <div class="col-md-2">
                <h3>Menu</h3>
                <ul class="footer-menu">
                    <li><a href="{{ url('clients/home') }}">Trang chủ</a></li>
                    <li><a href="{{ url('clients/info') }}">Người dùng</a></li>
                    <li><a href="{{ url('clients/concept') }}">Gói chụp hình</a></li>
                    <li><a href="{{ url('clients/booking') }}">Booking</a></li>
                    <li><a href="{{ url('clients/contact') }}">Liên hệ</a></li>

                </ul>
            </div>
            <div class="col-md-3">
                <h3>Contact</h3>
                <ul class="footer-menu">
                    <li>Hotline: (+84) 0123456789</li>
                    <li>Email: hbdiep2004@gmail.com</li>
                    <li><a href="{{ url('clients/home') }}">Website: 4Views Studio</a></li>

                </ul>
            </div>
            <div class="col-md-3">
                <h3>My Account</h3>
                <ul class="footer-menu">
                    <li><a href="/auth">Login</a></li>
                    <li><a href="/auth">Register</a></li>

                </ul>
            </div>
            <div class="col-md-12 text-center ">
                <div id="logo">
                    <h1 class="font-size-50"> <strong> 4Views Studio</strong></h1>
                </div>
                <p>THE BEST STUDIO</p>
            </div>
            <div class="col-md-12 margin-top-15">
                <div class="row">
                    <div class="col-md-4">
                        <p><i class="fa fa-house"></i> Km 10, Đường Nguyễn Trãi, Quận Thanh Xuân , TP Hà Nội, Việt Nam
                        </p>
                    </div>
                    <div class="col-md-4 text-center">
                        <p><i class="fa fa-phone"></i> 024. 3854 1616</p>
                    </div>
                    <div class="col-md-4 text-end">
                        <p><i class="fa fa-envelope"></i> phamthesang1307@gmail.com</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
    
    <div class="col-md-12">
        <hr>
        <div class="col-md-12 text-center">
            <p><i class="fa fa-copyright"> </i> <span id="year-copy-right"></span>The 4ViewsStudio - All Right Reserved</p>
        </div>
        <hr>
    </div>

</div>