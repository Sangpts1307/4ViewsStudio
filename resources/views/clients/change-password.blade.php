@extends('clients.index')

@section('content')

@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if (session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-sm" style="max-width: 600px; width: 100%; background-color: #f8f9fa; padding: 40px;">
        <div class="">
            <h2 class="mb-0 text-center">Đổi Mật Khẩu</h2>
        </div>
        <div class="card-body">
            <form action="{{ url('/change_password') }}" method="POST" id="changePasswordForm">
                @csrf
                <div class="mb-3">
                    <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
                    <input type="password" name="current_password" id="current_password" class="form-control" placeholder="Nhập mật khẩu hiện tại" required>
                </div>
                <div class="mb-3">
                    <label for="new_password" class="form-label">Mật khẩu mới</label>
                    <input type="password" name="new_password" id="new_password" class="form-control" placeholder="Nhập mật khẩu mới" required>
                </div>
                <div class="mb-4">
                    <label for="confirm_new_password" class="form-label">Xác nhận mật khẩu mới</label>
                    <input type="password" name="confirm_new_password" id="confirm_new_password" class="form-control" placeholder="Xác nhận mật khẩu mới" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">
                        Đổi Mật Khẩu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('changePasswordForm').addEventListener('submit', function(e) {
        var newPassword = document.getElementById('new_password').value;
        var confirmNewPassword = document.getElementById('confirm_new_password').value;

        if (newPassword !== confirmNewPassword) {
            e.preventDefault();
            alert('Mật khẩu mới và xác nhận mật khẩu không khớp.');
        }
    });
</script>

@endsection