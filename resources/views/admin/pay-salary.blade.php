@extends('admin.index')

@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@elseif (session('update'))
    <div class="alert alert-success">
        {{ session('update') }}
    </div>
@elseif (session('error'))
    <div class="alert alert-success">
        {{ session('error') }}
    </div>
@endif
<div class="d-flex justify-content-center align-items-center mt-3">
    <div class="w-95">
<div id="header">
    <h2><i class="fa-solid fa-money-check-dollar"></i> Trả lương nhân viên</h2>
</div>
<div class="col-md-12 content">
    <div class="row">
        <form id="month-form" method="GET" action="{{ '/admin/pay-salary' }}">
            <div class="row">
                <div class="col-md-6 d-flex align-items-center gap-3">
                    <p class="mb-0">Chọn tháng và năm:</p>
                    <input type="month" id="month" name="month" value="{{ $month }}" class="form-control" style="width: 30%;">
                </div>
                <div class="col-md-6 export-excel">

                    
                    <a href="{{ url('/admin/pay-salary/export?month='.$month) }}" class="btn btn-primary btn-export">
                        <i class="fa-solid fa-file-export"></i>
                        Xuất excel
                    </a>
                </div>
            </div>
        </form>
        
    </div>
    <div class="table-salary">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Nhân viên</th>
                    <th>Email</th>
                    <th>Số ca làm</th>
                    <th>Ca chụp hoàn thành</th>
                    <th>Lương</th>
                    <th>Trả lương</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($staffs as $staff)
                    <tr>
                        <td>{{ $staff->user_id }}</td>
                        <td>{{ $staff->name }}</td>
                        <td>{{ $staff->email }}</td>
                        <td>{{ $staff->total_shift }}</td>
                        <td>{{ $staff->finished_shift }}</td>
                        <td>{{ $staff->total_salary }}</td>
                        <td>
                            <form action="/admin/pay" method="get">

                                <input type="hidden" name="user_id" id="" value="{{ $staff->user_id }}">
                                <input type="hidden" name="month" value="{{ $month }}">
                                @if ($staff->status == App\Models\Salary::PAID)
                                    <div class="btn btn-success">Đã thanh toán</div>
                                @else
                                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-dollar-sign"></i> Trả lương</button>
                                @endif
                               
                            </form>
                           
                        </td>
                       
                    
                    </tr>
                @endforeach
              
            </tbody>
        </table>
    </div>
</div>
    </div>

</div>

<script>
    document.getElementById('month').addEventListener('change', function () {
        document.getElementById('month-form').submit();
    });
</script>

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

    .export-excel {
        display: flex;
        justify-content: flex-end; 
        align-items: center;
    }
    .table-salary {
        margin: 20px 10px 10px 10px;
        overflow: auto;
        max-height: 80vh;
    }
    .table th, .table td {
        text-align: center;
    }
    
</style>
@endsection
