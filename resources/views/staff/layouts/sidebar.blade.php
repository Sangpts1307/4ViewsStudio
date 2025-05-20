<div class="avatar">
    <img height="100px" width="100px" src="/image/avt.png" alt="Avatar">

    <h5>4ViewStudio</h5>
</div>
<div class="user-header">
    <div class="avatar-hello">
        <i class="fas fa-user-circle"></i>
    </div>
    <div class="user-info">
        <h5>Xin chào!</h5>
        <h6>{{ $user_name }}</h6>
    </div>
</div>
<div class="menu">
    <ul class="nav flex-column">

        <li class="nav-item"><a class="nav-link" href="{{ url('/staff/info') }}"><i class="nav-icon fa-solid fa-user"></i>Thông tin cá nhân</a></li>

        <li class="nav-item"><a class="nav-link" href="{{ url('/staff/work-schedule') }}"><i class="nav-icon fa-regular fa-calendar-days"></i> Lịch làm việc</a></li>

    </ul>
</div>
<br />
<a href="{{ url('/logout') }}">
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
        min-height: 100vh;
        max-height: auto;
        background: linear-gradient(to bottom, #e0f5e5, #fff8e1);

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
        background: linear-gradient(to right, #5fb9a5, #9ad4b1);
        padding: 10px;
        border-radius: 25px;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        height: 60px;
    }

    .user-header .avatar-hello {
        margin-right: 25px;
        /* Space between avatar and text */
    }

    .user-header .avatar-hello i {
        font-size: 2.5em;
        /* Adjust icon size */
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
        color: black;
        font-weight: bold;
        background: linear-gradient(to bottom, #f9f4ec, #cfeae9, #d3f0d2);
        background: linear-gradient(to bottom, #e6e0d8, #b8d8d7, #badbc9);

    }

    .menu ul li:hover {
        color: white;
    }

    .button-wrapper {
        display: flex;
        justify-content: center;
        align-items: end;
        padding-bottom: 20px;
    }

    .btn-logout {
        bottom: 20px;
        left: 20px;
        padding: 10px 20px;
        background: linear-gradient(to left, #3cabb1, #2a7d8c);
        color: white;
        border: 0px solid black;
        border-radius: 10px;
        text-decoration: none;
        font-size: 16px;
        background: linear-gradient(to right, #b3e5c7, #f7d794);
        background: linear-gradient(to right, #5fb9a5, #9ad4b1);

    }
</style>