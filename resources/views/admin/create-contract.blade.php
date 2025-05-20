@extends('admin.index')

@section('content')
    <div class="container khung">
        <div class="trong-khung">
            <h3 class="text-center mb-4">Tạo mới hợp đồng</h3>

            <form action="{{ url('/admin/contracts/store') }}" method="POST">
                @csrf
                {{-- Thông báo thành công hoặc lỗi --}}
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row mb-3">
                    <div class="col-md-6 mb-3">
                        <label for="ten_khach_hang" class="form-label">Tên khách hàng</label>
                        <input type="text" class="form-control" id="ten_khach_hang" name="ten_khach_hang" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="so_dien_thoai" class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" id="so_dien_thoai" name="so_dien_thoai" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="gmail" class="form-label">Gmail</label>
                        <input type="email" class="form-control" id="gmail" name="gmail" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="concept" class="form-label">Concept</label>
                        <select name="concept" id="concept" class="form-control" required>
                            <option value="" disabled selected>Chọn Concept</option> {{-- Option mặc định --}}
                            @foreach ($concepts as $concept)
                                <option value="{{ $concept->id }}" data-price="{{ $concept->price }}">
                                    {{ $concept->name }}
                                </option>
                            @endforeach
                        </select>

                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="ngay_chup" class="form-label">Ngày chụp</label>
                        <input type="date" class="form-control" id="ngay_chup" name="ngay_chup" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="ca_chup" class="form-label">Ca chụp</label>
                        <select name="ca_chup" id="ca_chup" class="form-control" required>
                            @foreach ($shifts as $shift)
                                <option value="{{ $shift->id }}" data-price="{{ $shift->price }}">
                                    {{ \Carbon\Carbon::parse($shift->start_time)->format('H:i') }} -
                                    {{ \Carbon\Carbon::parse($shift->end_time)->format('H:i') }}
                                </option>
                              
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="gia_tri_hop_dong" class="form-label">Giá trị hợp đồng</label>
                        <input type="text" class="form-control" id="gia_tri_hop_dong" name="gia_tri_hop_dong"  value="{{ $price }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tien_coc" class="form-label">Tiền cọc</label>
                        <input type="text" class="form-control" id="tien_coc" name="tien_coc" value="{{ $price *0.3 }}">
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary px-5">Tạo mới</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('concept').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex]; // Lấy phần tử option đã chọn
            var price = selectedOption.getAttribute('data-price'); // Lấy giá trị price từ thuộc tính data-price của option
    
            // Cập nhật giá trị vào input
            document.getElementById('gia_tri_hop_dong').value = price;
            document.getElementById('tien_coc').value = price*0.3;
        });
    </script>
    


    <style>
        .khung {
            margin-top: 100px;
        }

        .trong-khung {
            background: #fff;
            padding: 24px;
            border-radius: 8px;
            border: 1px solid #ccc;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>

@endsection
