<div class="col-md-3 ">
    <img src="/image/avt.png" width="100px" height="100px" alt="">
</div>

<div class="col-md-6">
    <nav class="navbar navbar-expand-lg bg-body-tertiary w-100">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/clients/home') }}">Trang chủ</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" >Người
                            dùng</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="login.blade.php">Đăng nhập, đăng kí</a></li>
                            <li><a class="dropdown-item" href="{{ url('clients/info') }}">Thông tin cá nhân</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="{{ url('/clients/concept') }}" >Gói chụp
                            hình</a>
                        <ul class="dropdown-menu">
                            @foreach ($concepts_header as $concept_header)
                            <li><a class="dropdown-item" href="{{ url('/clients/concept-detail/'.$concept_header->id) }}">{{ $concept_header->name }}</a></li>
                            @endforeach
                          
                           
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="{{ url('/clients/booking') }}" >Booking</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Đặt lịch</a></li>
                            <li><a class="dropdown-item" href="{{ url('/clients/appointments') }}">Lịch hẹn của tôi</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/clients/contact') }}">Liên hệ</a></li>
                </ul>
            </div>
        </div>
    </nav>
</div>

<div class="col-md-3">
    <div class="w-100 d-flex justify-content-between align-items-center">
        <div class="icon-group d-flex gap-3 align-items-center">
            <!-- Facebook -->
            <a href="https://www.facebook.com/nguyen.quang.759856" target="_blank" title="Facebook">
                <i class="fa-brands fa-facebook fa-lg" style="color: #1877f2;"></i>
            </a>

            <!-- Instagram -->
            <a href="https://www.instagram.com/apr.peidbh/" target="_blank" title="Instagram">
                <i class="fa-brands fa-instagram fa-lg" style="color: #e4405f;"></i>
            </a>

            <!-- Gmail (Google) -->
            <a href="mailto:nguyenduykhanh121204@gmail.com" title="Gmail">
                <i class="fa-brands fa-google fa-lg" style="color: #db4437;"></i>
            </a>

            <!-- Zalo (ảnh) -->
            <a href="https://zalo.me/0862009271" target="_blank" title="Zalo">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/91/Icon_of_Zalo.svg/32px-Icon_of_Zalo.svg.png"
                    alt="Zalo" style="width: 22px; height: 22px; filter: drop-shadow(0 0 1px #0068ff);">
            </a>
        </div>

        <!-- Logout -->
        <div class="logout-icon">
            <a href="{{ url('/logout') }}" title ="Đăng xuất">
                <i class="fa-solid fa-right-from-bracket fa-lg" style="color: #6c757d;"></i>
            </a>
        </div>
    </div>
</div>
<style>
    /* Khi trỏ chuột vào li.dropdown thì hiển thị menu con */
.nav-item.dropdown:hover .dropdown-menu {
    display: block;
    margin-top: 0; /* Tránh lệch menu */
}

</style>