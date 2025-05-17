@extends('clients.index')
@section('content')
@if (session('success'))
            <div class="alert alert-success" id="alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger" id="alert-error">
                {{ session('error') }}
            </div>
        @endif
<div class="auth-container">
    <div class="main">      
        <!-- Kiểm tra trạng thái qua session -->
        <input type="checkbox" id="chk" aria-hidden="true" 
            @if(session('showLogin')) checked @endif>
        
        <!-- Phần đăng ký -->
        <div class="signup">
            <form action="{{ url('/auth') }}" method="post" id="form-register">
                @csrf
                <label for="chk" aria-hidden="true">Sign up</label>
                <input type="text" name="name" placeholder="Full name" required="">
                <input type="email" name="email" placeholder="Email" required="">
                <input type="password" name="password" placeholder="Password" required="">
                <input type="password" name="re_password" placeholder="Re_Password" required="">
                <button type="submit">Sign up</button>
            </form>
        </div>

        <!-- Phần đăng nhập -->
        <div class="login">
            <form action="{{ url('/login') }}" method="post" id="form-login">
                @csrf
                <label for="chk" aria-hidden="true">Login</label>
                <input type="email" name="email" id="email" placeholder="Email" required="">
                <input type="password" name="password" id="password" placeholder="Password" required="">
                <button type="submit">Login</button>
            </form>
        </div>
    </div>
</div>

<script>
    // Tự động ẩn alert sau 3 giây
    setTimeout(function() {
        var successAlert = document.getElementById('alert-success');
        if (successAlert) {
            successAlert.style.display = 'none'; // Ẩn alert thành công
        }

        var errorAlert = document.getElementById('alert-error');
        if (errorAlert) {
            errorAlert.style.display = 'none'; // Ẩn alert lỗi
        }
    }, 10000); // 10000ms = 10 giây
</script>
<style>
    .auth-container {
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        font-family: 'Jost', sans-serif;
        background: linear-gradient(to bottom, #f5e4e6,#a2d1cc, #f1f4c3);

    }

    .auth-container .main {
        width: 420px;
        height: 600px;
        background: url("https://doc-08-2c-docs.googleusercontent.com/docs/securesc/68c90smiglihng9534mvqmq1946dmis5/fo0picsp1nhiucmc0l25s29respgpr4j/1631524275000/03522360960922298374/03522360960922298374/1Sx0jhdpEpnNIydS4rnN4kHSJtU1EyWka?e=view&authuser=0&nonce=gcrocepgbb17m&user=03522360960922298374&hash=tfhgbs86ka6divo3llbvp93mg4csvb38") no-repeat center / cover;
        border-radius: 12px;
        box-shadow: 6px 24px 60px #000;
        overflow: hidden;
    }

    .auth-container #chk {
        display: none;
    }

    .auth-container .signup {
        position: relative;
        width: 100%;
        height: 100%;
    }

    .auth-container label {
        color: #3aa89b;
        font-size: 2.8em;
        justify-content: center;
        display: flex;
        margin: 60px;
        font-weight: bold;
        cursor: pointer;
        transition: .5s ease-in-out;
    }

    .auth-container input {
        width: 60%;
        height: 14px;
        background: #e0dede;
        justify-content: center;
        display: flex;
        margin: 25px auto;
        padding: 15px;
        border: none;
        outline: none;
        border-radius: 6px;
        font-size: 1.1em;
    }

    .auth-container button {
        width: 60%;
        height: 48px;
        margin: 12px auto;
        justify-content: center;
        display: block;
        color: #fff;
        /* background: #573b8a; tím */
        background-color: #3aa89b;
        font-size: 1.2em;
        font-weight: bold;
        margin-top: 35px;
        outline: none;
        border: none;
        border-radius: 6px;
        transition: .2s ease-in;
        cursor: pointer;
    }

    .auth-container button:hover {
        /* background: #6d44b8; */
        background-color: #5fc1b3;
    }

    .auth-container .login {
        height: 552px;
        background: #eee;
        border-radius: 60% / 10%;
        transform: translateY(-216px);
        transition: .8s ease-in-out;
    }

    .auth-container .login label {
        /* color: #573b8a; */
        color: #3aa89b;
        transform: scale(.6);
    }

    .auth-container #chk:checked ~ .login {
        transform: translateY(-570px);
    }

    .auth-container #chk:checked ~ .login label {
        transform: scale(1);    
    }

    .auth-container #chk:checked ~ .signup label {
        transform: scale(.6);
    }
</style>

@endsection
