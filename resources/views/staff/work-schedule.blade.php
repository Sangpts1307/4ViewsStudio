@extends('staff.index')

@section('content')
<div class="d-flex justify-content-center align-items-center mt-3">
    <div class="w-95">
<div class="col-md-12">
    <div class="row">
        <div class="col-md-4">
            <h2>Lịch làm việc</h2>
        </div>
        <div class="col-md-8">
            <form action="{{ url('/staff/work-schedule') }}" method="get" class="d-flex align-items-center gap-3">
                <p class="mb-0">Chọn tháng và năm:</p>
                <input type="month" id="month" name="month" value="{{ $month }}" class="form-control mb-0" style="width: 30%;" onchange="this.form.submit()">
            </form>
        </div>
        

        
    </div>
</div>
<div class="col-md-12 margin-top-3">
    <div class="w-80">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Ngày làm việc</th>
                    @foreach ($shifts as $shift)
                        <th>{{ \Carbon\Carbon::parse($shift->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($shift->end_time)->format('H:i') }}</th>
                    @endforeach
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @php
                $days = $staffShedule->groupBy(function($item) {
                    return \Carbon\Carbon::parse($item->work_day)->format('d/m/y');
                });
            @endphp
            
                @foreach ($days as $date => $schedules)
                    <tr>
                        <td>{{ $date }}</td>
                        @foreach ($shifts as $shift)
                            @php
                                $hasShift = $schedules->where('shift_id', $shift->id)->isNotEmpty();
                            @endphp
                            <td>{{ $hasShift ? '✅' : '' }}</td>
                        @endforeach
                        <td>
                          
                            <a href="{{ url('/staff/schedule-detail?date='.$date) }}" class="btn btn-primary">Xem</a>
                        </td>
                    </tr>
                @endforeach
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

    .w-80 {
        width: 80%;
        margin: 0 auto;
    }
    .table th, .table td {
        text-align: center;
    }
    .margin-top-3 {
        margin-top: 3%;
    }
    .btn-primary a {
        color: white;
        text-decoration: none;
    }
    .btn-primary a:hover {
        color: #77ffb4;
    }
</style>
@endsection