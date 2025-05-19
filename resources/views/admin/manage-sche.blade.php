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
        <h2>Quản lý lịch làm</h2>
        <br>

        <form action="{{ url('/admin/manage-sche') }}" method="GET">
            <div class="filter">
                <input type="date" name="date" class="form-control" placeholder="Chọn ngày" aria-label="Chọn ngày"
                    value="{{ $date }}" style="width: 40%;">
                <button type="submit" class="search-btn">🔎</button>
            </div>

        </form>


        <div class="table-container">
            <table class="table table-bodered table-hover">
                <thead>
                    <tr>
                        <th>Ca làm</th>
                        <th>Nhân viên</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($shifts as $shift)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($shift->start_time)->format('H:i') }} -
                            {{ \Carbon\Carbon::parse($shift->end_time)->format('H:i') }}
                        </td>
                        <td>
                            @if ($schedules->has($shift->id))
                            @foreach ($schedules[$shift->id] as $schedule)
                            {{ $schedule->user_name }}<br>
                            @endforeach
                            @else
                            Không có nhân viên trong ca này
                            @endif
                        </td>
                        <td>
                            <form action="{{ url('/admin/manage-sche') }}" method="GET" style="display: inline;">
                                <input type="hidden" name="shift_id" value="{{ $shift->id }}">
                                <input type="hidden" name="date" value="{{ $date }}">
                                <button type="submit" class="edit-btn">🔧 Chỉnh sửa</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@if (request()->has('shift_id') && request()->has('date'))
<div class="modal" tabindex="-1" style="display: flex;">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">
            <form action="{{ url('/admin/save-schedule') }}" method="POST">
                @csrf
                <input type="hidden" name="shift_id" value="{{ request('shift_id') }}">
                <input type="hidden" name="date" value="{{ request('date') }}">

                <div class="modal-header">
                    <h5 class="modal-title">Phân công nhân viên</h5>
                    <button type="button" class="btn-close" onclick="closePopup()" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <p>Chọn nhân viên cho ca làm:</p>
                    <div id="employee-checkboxes">
                        <div class="col-md-12">
                            <div class="row">
                                @foreach ($assignedStaffs as $staff)
                                <div class="col-md-4">
                                    <label>
                                        <input type="checkbox" name="employees[]" value="{{ $staff->user_id }}" checked>
                                        {{ $staff->name }}
                                    </label>
                                </div>
                                @endforeach
                                @foreach ($unassignedStaffs as $staff)
                                <div class="col-md-4">
                                    <label>
                                        <input type="checkbox" name="employees[]" value="{{ $staff->id }}">
                                        {{ $staff->name }}
                                    </label>
                                </div>
                                @endforeach
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

<script>
    function closePopup() {
        document.querySelector('.modal').style.display = 'none';
    }

    // Giới hạn chọn tối đa 3 checkbox
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('input[name="employees[]"]');

        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const checkedCount = document.querySelectorAll('input[name="employees[]"]:checked').length;
                if (checkedCount > 3) {
                    alert("Chỉ được chọn tối đa 3 nhân viên cho mỗi ca làm!");
                    this.checked = false;
                }
            });
        });
    });
</script>


@endsection

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    .w-95 {
        width: 95%;
        border: 1px solid #ccc;
        padding: 20px;
        border-radius: 5px;
        margin: 0 auto;
        background-color: #f8f9fa;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
        margin-bottom: 20px;
        margin-top: 50px;
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
        background-color: gray;
        border: none;
        border-radius: 10%;
    }

    .table-container {
        overflow-x: auto;
    }

    .edit-btn {
        padding: 5px 10px;
        background-color: #4CAF50;
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 10px;
    }

    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
        z-index: 999;
    }

    .modal-dialog {
        background: white;
        padding: 20px;
        border-radius: 20px;
        width: 500px;
        position: relative;
    }
</style>