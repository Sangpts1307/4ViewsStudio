@extends('staff.index')

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
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-4">
                <h2>Chi tiết lịch làm</h2>
            </div>
            <div class="col-md-8">
                <form action="{{ url('/staff/schedule-detail') }}" method="GET" class="d-flex align-items-center gap-3">
                    <p class="mb-0">Chọn ngày:</p>
                    <input type="date" id="date" name="date" class="form-control" style="width: 30%;" value="{{ $date }}" onchange="this.form.submit()">
                </form>
            </div>
            
        </div>
    </div>

    {{-- Ca có khách hẹn --}}
    <div class="col-md-12 margin-top-3">
        <h4>Danh sách ca có khách hẹn</h4>
        <div class="w-90">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Ca làm</th>
                        <th>Khách hẹn</th>
                        <th>Concept</th>
                        <th>Link ảnh</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($schedules as $schedule)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($schedule->shift->start_time)->format('H:i') }} 
                                - {{ \Carbon\Carbon::parse($schedule->shift->end_time)->format('H:i') }}
                            </td>
                            <td>{{ $schedule->user->name }}</td>
                            <td>{{ $schedule->concept->name }}</td>
                            @if ($schedule->status != \App\Models\Appointment::STATUS_DONE)
                            <td>
                            <a href="{{ url('/staff/schedule-detail?date='.$date.'&appointment_id='.$schedule->id) }}" class="btn btn-primary add-link" >
                                <i class="fa-solid fa-plus"></i> Gắn link ảnh
                            </a>
                        </td>
                                <td>Chưa hoàn thành</td>
                            @else
                                <td><a href="{{ $schedule->link_image }}" target="_blank">Link ảnh</a></td>
                                <td>Đã hoàn thành</td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Ca chưa có khách hẹn --}}
    <div class="col-md-12 margin-top-3">
        <h4>Danh sách ca chưa có khách hẹn</h4>
        <div class="w-90">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Ca làm</th>
                        <th colspan="4">Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($shifts as $shift)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($shift->start_time)->format('H:i') }} 
                                - {{ \Carbon\Carbon::parse($shift->end_time)->format('H:i') }}
                            </td>
                            <td colspan="4">Chưa có dữ liệu</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    @if (request()->has('appointment_id') && request()->has('date'))
    <div class="modal" tabindex="-1" style="display: flex;">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ url('/staff/add-link-image') }}" method="POST">
                    @csrf
                    <input type="hidden" name="appointment_id" value="{{ request('appointment_id') }}">
                    <input type="hidden" name="date" value="{{ request('date') }}">

                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                        <button type="button" class="btn-close" onclick="closePopup()" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="col-md-12 margin-top-2">
                            <div class="row">
                                <div class="col-md-3">
                                    <p>Người nhận</p>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="name" class="form-control" placeholder="Người nhận" value="{{ $information->user->name }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 margin-top-2">
                            <div class="row">
                                <div class="col-md-3">
                                    <p>Email</p>
                                </div>
                                <div class="col-md-9">
        
                                    <input type="email" class="form-control" placeholder="Email" name="email" value="{{ $information->user->email }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 margin-top-2">
                            <div class="row">
                                <div class="col-md-3">
                                    <p>Concept</p>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" placeholder="Concept" name="concept" value="{{ $information->concept->name }}" readonly>
                                   
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 margin-top-2">
                            <div class="row">
                                <div class="col-md-3">
                                    <p>Link ảnh</p>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" placeholder="Link ảnh" name="link-image" value="">
                                </div>
                            </div>
                                
                        </div>
                        <div class="col-md-12 margin-top-2">
                            <div class="row">
                                <div class="col-md-3">
                                    <p>Lời nhắn</p>
                                </div>
                                <div class="col-md-9">
                                   <textarea class="form-control" name="message"  id=""  rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                      
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="closePopup()">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endif
    </div>

</div>

<script>
    function closePopup() {
        document.querySelector('.modal').style.display = 'none';
    }
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

        .w-90 {
            width: 90%;
            margin: 0 auto;
        }

        .table th,
        .table td {
            text-align: center;
        }

        .table th {
            background-color: #f8f9fa;
        }

        .margin-top-3 {
            margin-top: 3%;
        }

        .add-link a {
            color: white;
            text-decoration: none;
        }

        tr td {
            vertical-align: middle;
            text-align: center;
        }
        .margin-top-2 {
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
        }
    </style>
@endsection
