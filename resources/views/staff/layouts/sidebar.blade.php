<div class="avatar">
    <img height="100px" width="100px" src="/image/avt.png" alt="Avatar">
   
    <h5>4ViewStudio</h5>
</div>
<div class="user-header">
    <div class="avatar-hello">
        <i class="fas fa-user-circle"></i>  <!-- Font Awesome icon -->
    </div>
    <div class="user-info">
        <h5>Xin chào!</h5>
        <h6>Photographer</h6>
    </div>
</div>
<div class="menu">
    <ul class="nav flex-column">
       
        <li class="nav-item"><a class="nav-link" href="{{ url('/staff/info') }}"><i class="nav-icon fa-solid fa-user"></i>Thông tin cá nhân</a></li>

        <li class="nav-item"><a class="nav-link" href="{{ url('/staff/work-schedule') }}"><i class="nav-icon fa-regular fa-calendar-days"></i>  Lịch làm việc</a></li>
        
    </ul>
</div>
<br/>
<a href="{{ url('/logout') }}" >
    <button class="btn-logout"><i class="fa-solid fa-right-from-bracket"></i> Đăng xuất</button>
</a>

<style>
    .row {
    margin: 0 auto;
    }
    .sidebar-header {
    margin-left: 10px;
    }
    .avatar {
    border-bottom: 1px solid black;
    margin-bottom: 10px;
    text-align: center;
    }
    .menu ul {
    list-style: none;
    padding: 0;
    }
    .sidebar {
    background: linear-gradient(to bottom, #5bcdd1, #8fdde0);
    padding-bottom: 25px;
    height: 820px;
    }
    .menu a {
    display: block;
    padding: 10px;
    }
    .nav-link {
    color: black;
    }
    .user-header {
    background: linear-gradient(to left, #3cabb1, #2a7d8c);
    padding: 10px;
    border-radius: 25px;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    height: 60px;
    }
    .user-header .avatar-hello {
    margin-right: 25px; /* Space between avatar and text */
    }
    .user-header .avatar-hello i {
    font-size: 2.5em; /* Adjust icon size */
    color: white;
    }
    .user-header .user-info {
    margin-top: 10px;
    color: white;
    font-size: 10px;
    }
    .nav-item i {
    margin-right: 15px;
    }
    .nav-item:hover {
    background: linear-gradient(to left, #3cabb1, #2a7d8c);
    }
    .nav-item a:hover {
    color: #f0f0f0;
    font-weight: bold;
    }
    .menu ul li:hover{
    color: white;
    }
    .btn-logout {
    bottom: 20px; 
    left: 20px;
    padding: 10px 20px;
    background: linear-gradient(to left, #3cabb1, #2a7d8c);
    color: white;
    border-radius: 10px;
    text-decoration: none;
    font-size: 16px;
    }
</style>