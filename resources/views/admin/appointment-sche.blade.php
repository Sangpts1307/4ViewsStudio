@extends('admin.index')

@section('content')
@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="d-flex justify-content-center align-items-center mt-3">
    <div class="w-95">
        <h2>Quản lý lịch hẹn</h2><br>

        <form action="{{ url('/admin/appointments/search') }}" method="GET">
            <div class="filter">
                <input type="text" name="name" value="{{ request('name') }}" class="form-control"
                    placeholder="Tên khách hàng" aria-label="Tên khách hàng" style="width:40%">
                <input type="text" name="phone" value="{{ request('phone') }}" class="form-control"
                    placeholder="Số điện thoại" aria-label="Số điện thoại" style="width:40%">
                <input type="date" name="day" value="{{ request('day') }}" class="form-control"
                    placeholder="Chọn ngày" aria-label="Chọn ngày" style="width:40%">
                <button class="search-btn">🔎</button>
            </div>
        </form>
        <div class="table-div">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Khách hàng</th>
                        <th>Số điện thoại</th>
                        <th>Concept</th>
                        <th>Ca làm</th>
                        <th>Ngày</th>
                        <th>Giá concept</th>
                        <th>Đã cọc</th>
                        <th>Thợ chụp</th>
                        <th>Ghi chú</th>
                        <th>Đồng bộ lịch</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($appointments as $index => $appointment)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $appointment->user->name ?? 'N/A' }}</td>
                        <td>{{ $appointment->user->phone ?? 'N/A' }}</td>
                        <td>{{ $appointment->concept->name ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($appointment->shift->start_time)->format('H:i') }} -
                            {{ \Carbon\Carbon::parse($appointment->shift->end_time)->format('H:i') }}
                        </td>

                        <td>{{ \Carbon\Carbon::parse($appointment->work_day)->format('d/m/Y') }}</td>
                        <td>{{ number_format($appointment->concept->price) }}đ</td>
                        <td>{{ number_format($appointment->concept->price * 0.3) }}đ</td>
                        <td>
                            @if ($appointment->availableStaffs && $appointment->availableStaffs->isNotEmpty())
                            <form action="{{ url('/admin/appointment-sche') }}" method="POST"
                                id="assignStaffForm-{{ $appointment->id }}">
                                @csrf
                                <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">

                                @if ($appointment->status === \App\Models\Appointment::STATUS_ASYNC)
                                {{-- Nếu đã async, chỉ hiển thị tên thợ nếu có --}}
                                <span>
                                    {{ $appointment->staff ? $appointment->staff->name : 'Chưa phân công' }}
                                </span>
                                @else
                                <select class="select-staff" name="staff_id" id="staff_id_{{ $appointment->id }}" required onchange="this.form.submit()">
                                    @if ($appointment->availableStaffs->count() == 1)
                                    <option value="" {{ !$appointment->staff_id ? 'selected' : '' }}>Chọn thợ chụp</option>
                                    <option value="{{ $appointment->availableStaffs->first()->id }}"
                                        {{ $appointment->staff_id == $appointment->availableStaffs->first()->id ? 'selected' : '' }}>
                                        {{ $appointment->availableStaffs->first()->name }}
                                    </option>
                                    @else
                                    <option value="" {{ !$appointment->staff_id ? 'selected' : '' }}>Chọn thợ chụp</option>
                                    @foreach ($appointment->availableStaffs as $staff)
                                    <option value="{{ $staff->id }}" {{ $appointment->staff_id == $staff->id ? 'selected' : '' }}>
                                        {{ $staff->name }}
                                    </option>
                                    @endforeach
                                    @endif
                                </select>
                                @endif

                            </form>
                            @else
                            <span>Chưa có nhân viên ca này</span>
                            @endif
                        </td>
                        <td>{{ $appointment->note }}</td>
                        @if ($appointment->status === \App\Models\Appointment::STATUS_ASYNC)
                            <td><a class="save-btn"><i class="fa-regular fa-calendar-check"></i></a></td>
                        @elseif ($appointment->status === \App\Models\Appointment::STATUS_WAIT)
                            <td><a href="{{ url('admin/manage-sche?shift_id='. $appointment->shift_id.'&date='. $appointment->work_day) }}" class="btn-add">
                                <i class="fa-solid fa-plus" style="color: white;"></i>
                            </a></td>
                        @else
                            <td><a href="{{ url('admin/appointments/async/' . $appointment->id) }}" class="btn-save"><i class="fa-regular fa-calendar-check"></i></a></td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
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

    .filter {
        display: flex;
        gap: 30px;
        margin-bottom: 20px;
    }

    .filter button {
        padding: 8px 12px;
        cursor: pointer;
    }

    .search-btn {
        border: none;
        border-radius: 10%;
    }

    .table-container {
        overflow-x: auto;
    }

    .tbl-appointment th,
    .tbl-appointment td {
        border: 1px solid #ccc;
        padding: 10px;
        text-align: center;
    }

    .save-btn {
        padding: 5px 10px;
        background-color: gray;
        color: white;
        border: none;
        cursor: pointer;
        text-decoration: none;
    }

    .btn-add {
        padding: 5px 10px;
        background-color:rgb(125, 163, 189);
        color: white;
        border: none;
        cursor: pointer;
        text-decoration: none;
    }

    .btn-save {
        padding: 5px 10px;
        background-color: #4CAF50;
        color: white;
        border: none;
        cursor: pointer;
        text-decoration: none;
    }

    .table-div {
        width: 100%;
        border-collapse: collapse;
        overflow: auto;
        max-height: 70vh;
        width: 100%;


    }

    .tbl-appointment th {
        position: sticky;
        top: 0;
        z-index: 1;
    }
    .select-staff {
        border-radius: 5px;
        height: 30px;
        border: 1px solid yellowgreen
    }
</style>
@endsection