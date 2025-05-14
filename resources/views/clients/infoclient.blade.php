@extends('clients.index')
@section('content')
<div class="khung">
    <div class="container rounded trong-khung">
        <h2 style="text-align: center;">
            <i class="fa-solid fa-circle-info"></i> THÔNG TIN CÁ NHÂN
        </h2>
        <br>

        @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul style="margin-bottom: 0;">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ url('/clients/info/update') }}" method="POST" class="form-label" style="max-width: 800px; margin: 0 auto;">
            @csrf
            <div style="display: flex; gap: 60px; margin-bottom: 15px;">
                <div style="flex: 1;">
                    <label for="name">Họ tên</label>
                    <br>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Họ tên" aria-label="Họ tên"
                        value="{{  $user->name ?? '' }}">
                </div>
                <div style="flex: 1;">
                    <label for="email">Email *</label>
                    <br>
                    <input type="email" id="email" name="email" required class="form-control" placeholder="Email" aria-label="Email"
                        value="{{  $user->email ?? '' }}">
                </div>
            </div>

            <div style="display: flex; gap: 60px; margin-bottom: 15px;">
                <div style="flex: 1;">
                    <label for="phone">Số điện thoại</label>
                    <br>
                    <input type="text" id="phone" name="phone" class="form-control" placeholder="Số điện thoại" aria-label="Số điện thoại"
                        value="{{  $user->phone ?? '' }}">
                </div>
                <div style="flex: 1;">
                    <label for="dob">Ngày sinh</label>
                    <br>
                    <input type="date" id="birth_date" name="birth_date" class="form-control"
                        placeholder="Ngày sinh" aria-label="Ngày sinh"
                        value="{{ old('birth_date', isset($user) && $user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->format('Y-m-d') : '') }}">
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label for="address">Địa chỉ</label>
                <br>
                <input type="text" id="address" name="address" class="form-control" placeholder="Địa chỉ" aria-label="Địa chỉ"
                    value="{{ $user->address ?? ''}}">
            </div>

            <div style="text-align: right;">
                <button type="submit" class="btn btn-primary" style="background-color: #007bff; border: none; padding: 10px 20px; border-radius: 5px;">
                    Lưu thông tin
                </button>
            </div>
            <br>
        </form>
    </div>
</div>


<style>
    .form-label label {
        font-weight: bold;
    }

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
</style>

@endsection