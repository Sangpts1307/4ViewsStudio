@extends('staff.index')

@section('content')

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

    <form action="{{ url('/staff/info/update') }}" method="POST" class="form-label">
        @csrf
        <div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
            <div class="w-80">
                <h2 class="text-center">Thông tin cá nhân</h2>
                <div class="col-md-12 ">
                    <div class="row">
                        <div class="col-md-6">

                            <label>Họ tên</label>
                            <input type="text" name="name" class="form-control" placeholder="Họ tên" aria-label="Họ tên"
                                value="{{  $user->name ?? '' }}">
                            <label for="">Số điện thoại</label>
                            <input type="text" name="phone" class="form-control" placeholder="Số điện thoại"
                                aria-label="Số điện thoại" value="{{$user->phone ?? ''}}">
                            <label for="">Ngày sinh</label>
                            <input type="date"  name="birth_date" class="form-control" placeholder="Ngày sinh" aria-label="Ngày sinh"
                                value="{{ old('birth_date', isset($user) && $user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->format('Y-m-d') : '') }}">

                        </div>
                        <div class="col-md-6">
                            <label for="">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Email" aria-label="Email"
                                value="{{  $user->email ?? ''}}">
                            <label for="">Địa chỉ</label>
                            <input type="text" name="address" class="form-control" placeholder="Địa chỉ" aria-label="Địa chỉ"
                                value="{{ $user->address ?? ''}}">
                            <label for="">Số tài khoản</label>
                            <input type="text" name="account_number" class="form-control" placeholder="Số tài khoản" aria-label="Số tài khoản"
                                value="{{ $user->account_number ?? ''}}">

                        </div>
                        <button type="submit" class="btn btn-primary big-btn">Lưu thông tin</button>
                    </div>
                </div>
            </div>
            </div>
       
    </form>

    <style>
        .w-80 {
            width: 80%;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
            margin: 0 auto;
            background-color: #f8f9fa;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .col-md-6 label {
            margin-top: 2%;
        }

        .big-btn {
            width: 20%;
            margin: 0 auto;
            margin-top: 2%;
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;

            justify-content: center;
            align-items: center;
            display: flex;
            margin-bottom: 2%;
        }
    </style>
@endsection
