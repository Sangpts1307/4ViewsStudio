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
    .mar-left-15 {
        margin-left: 15px;
    }
</style>




<div id="footerr" class="col-md-12">
    <div class="container">
        <div class="row">
            <div class="col-md-4 text-center">
                <h3>About Us</h3>
                <p>
                4Views Studio – viện ảnh hàng đầu tại Hà Nội. <br>
                Cung cấp đa dạng dịch vụ chụp ảnh chuyên nghiệp. <br>
                Có nhiều cơ sở, dễ dàng di chuyển, lựa chọn. <br>
                Hãy đến 4Views Studio để cảm nhận sự khác biệt!
                </p>


            </div>
            <div class="col-md-2 text-center">
                <h3>Menu</h3>
                <ul class="footer-menu">
                    <li><a href="{{ url('clients/home') }}">Trang chủ</a></li>
                    <li><a href="{{ url('clients/info') }}">Người dùng</a></li>
                    <li><a href="{{ url('clients/concept') }}">Gói chụp hình</a></li>
                    <li><a href="{{ url('clients/booking') }}">Booking</a></li>
                    <li><a href="{{ url('clients/contact') }}">Liên hệ</a></li>
                </ul>
            </div>
            <div class="col-md-3 text-center">
                <h3>Contact</h3>
                <ul class="footer-menu">
                    <li>Hotline: (+84) 0123456789</li>
                    <li>Email: hbdiep2004@gmail.com</li>
                    <li><a href="{{ url('clients/home') }}">Website: 4Views Studio</a></li>


                </ul>
            </div>
            <div class="col-md-3 text-center">
                <h3>My Account</h3>
                <ul class="footer-menu">
                    <li><a href="{{ url('/login') }}">Login</a></li>
                    <li><a href="{{ url('/register') }}">Register</a></li>


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

