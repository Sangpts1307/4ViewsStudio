@extends('admin.index')

@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
<div class="d-flex justify-content-center align-items-center mt-3">
    <div class="w-95">
<div id="header" class="col-md-12 mb-3">
    <div class="d-flex justify-content-between align-items-center">
        
        <h2 style= "margin-top: 25px;"><i class="fa-solid fa-file-contract"></i> Quản lý hợp đồng</h2>
        <button class="btn btn-primary btn-upload">
            <a href="{{ url('/admin/contract/upload-drive') }}"><i class="fa-solid fa-upload"></i> Upload PDF hợp đồng lên Drive</a>
        </button>
    </div> 
</div>


{{-- TEST XEM BIẾN $contracts CÓ ĐƯỢC TRUYỀN CHƯA
<ul>
    @foreach ($contracts as $c)
        <li>{{ $c }}</li>
    @endforeach
</ul> --}}

<div class="col-md-12 content">
    <form action="{{ url('/admin/contract') }}" method="GET">
        <div class="row mb-3 align-items-center">
            <div class="col-md-3 mb-2">
                <input type="text" name="customer_name" class="form-control" placeholder="Tên khách hàng" value="{{ request('customer_name') }}">
            </div>
            <div class="col-md-2 mb-2">
                <input type="text" name="phone" class="form-control" placeholder="Số điện thoại" value="{{ request('phone') }}">
            </div>
            <div class="col-md-2 mb-2">
                <input type="date" name="contract_date" class="form-control" value="{{ request('contract_date') }}">
            </div>
            <div class="col-md-2 mb-2">
                <button type="submit" class="btn btn-warning w-100">
                    <i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm
                </button>
            </div>
            <div class="col-md-3 mb-2 text-end">
                {{-- thêm cái này--}}
                <a href="{{ url('/admin/contracts/create') }}" class="btn btn-success">
                    <i class="fa-solid fa-plus"></i> Tạo hợp đồng mới
                </a>
            </div>
        </div>
    </form>
    <div class="table-contract">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Khách hàng</th>
                    <th>SĐT</th>
                    <th>Ngày</th>
                    <th>Giá trị HĐ</th>
                    <th>Tiền đã trả</th>
                    <th>Còn nợ</th>
                    <th>In hợp đồng</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @forelse ($contracts as  $contract)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $contract->user_name ?? 'N/A' }}</td>
                        <td>{{ $contract->phone ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($contract->work_day)->format('d/m/Y') ?? 'N/A' }}</td>

                        @if ($contract->role == \App\Models\Contract::STATUS_DEBT)
                            <td>{{ $contract->price ?? '0' }}</td>
                            <td>{{ $contract->price * \App\Models\Contract::SCALE_DEPOSIT ?? '0' }}</td>
                            <td>{{ ($contract->price * \App\Models\Contract::SCALE_DEBIT) ?? '0' }}</td>
                        @else 
                            <td>{{ $contract->price ?? '0' }}</td>
                            <td>{{ $contract->price ?? '0' }}</td>
                            <td>{{ '0' }}</td>
                        @endif
                        <td>
                            <a href="{{ url('/admin/contract/print/'.$contract->id) }}"  target="_blank" class="btn btn-secondary"><i class="fa-solid fa-print"></i></a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">Không tìm thấy hợp đồng nào.</td>
                    </tr>
                @endforelse
            </tbody>
            
        </table>
    </div>
</div>
    </div>

</div>

<style>
       .w-95 {
        width: 95%;
        border: 1px solid #ccc;
        padding: 20px;
        border-radius: 5px;
        margin: 0 auto;
        background-color: #f8f9fa;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .table-contract {
        margin: 20px 10px 10px 10px;
    }
    .table th {
        text-align: center;
    }
    .table td {
        text-align: center;
    }
    .btn-upload a {
        color: white;
        text-decoration: none;
    }
</style>
@endsection
