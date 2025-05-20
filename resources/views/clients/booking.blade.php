@extends('clients.index')


@section('content')

<div class="khung">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @elseif (session('update'))
        <div class="alert alert-success">
            {{ session('update') }}
        </div>
    @elseif (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <form action="{{ url('/clients/bookingdetail') }}" method="get">
        @csrf
        <div class="col-md-12 height-60vh ">
            <div class="row">
                <div class="col-md-6 mt-3">
                    <div class="container d-flex justify-content-center align-items-center">
                        <div class="calendar">
                            <div class="calendar-header">
                                <button onclick="prevMonth()">◄</button>
                                <span id="month-year"></span>
                                <button onclick="nextMonth()">►</button>
                            </div>
                            <div class="calendar-grid" id="calendar-grid">
                                <div class="day-name">CN</div>
                                <div class="day-name">T2</div>
                                <div class="day-name">T3</div>
                                <div class="day-name">T4</div>
                                <div class="day-name">T5</div>
                                <div class="day-name">T6</div>
                                <div class="day-name">T7</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mt-5">
                    <div class="wpbc_times_selector col-md-12">
                        <h5><b>Chọn ca làm việc</b></h5>
                        <div class="row">
                            @foreach ($shifts as $shift)
                            <div class="col-md-5">
                                <label class="shift-option form-control" for="shift{{ $shift->id }}">
                                    <input type="radio" name="shift" id="shift{{ $shift->id }}" value="{{ $shift->id }}" required>
                                    {{ \Carbon\Carbon::parse($shift->start_time)->format('H:i') }} -
                                    {{ \Carbon\Carbon::parse($shift->end_time)->format('H:i') }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 height-60vh">
            <div class="row">
                <div class="col-md-6">
                    <div class="margin-left-w">
                        <label for="name">Họ tên</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" placeholder="Họ tên" aria-label="Họ tên" required>
                        <!-- <input type="hidden" name="name" id="name" class="form-control" value="{{ $user->name }}" placeholder="Họ tên" aria-label="Họ tên" required> -->
                        <label for="phone">Số điện thoại</label>
                        <input type="text" name="phone" id="phone" class="form-control" value="{{ $user->phone }}" placeholder="Số điện thoại" aria-label="Số điện thoại" required>


                        <label for="concept">Concept</label>
                        <select class="form-select" id="concept" name="concept" required>
                            <option value="" disabled {{ $conceptId ? '' : 'selected' }}>Chọn Concept</option>
                            @foreach ($concepts as $concept)
                                <option value="{{ $concept->id }}" {{ $concept->id == $conceptId ? 'selected' : '' }}>
                                    {{ $concept->name }}
                                </option>
                            @endforeach
                        </select>


                    </div>
                </div>
                <input type="hidden" name="date" id="selected-date">
                <div class="col-md-6">
                    <div class="margin-left-2w">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Email" value="{{ $user->email }}" aria-label="Email" required>


                        <label for="message">Lời nhắn tới thợ</label>
                        <textarea class="form-control" name="message" id="message" placeholder="Chi tiết lời nhắn" style="height: 45%;" aria-label="Chi tiết lời nhắn"></textarea>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Đặt lịch hẹn" style="margin-top: 20px; margin-left: 75%;">
                </div>
            </div>
        </div>

    </form>
</div>


<script>
    let currentDate = new Date();
    let currentMonth = currentDate.getMonth();
    let currentYear = currentDate.getFullYear();

    const months = [
        "Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6",
        "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"
    ];

    function renderCalendar() {
        const firstDayOfMonth = new Date(currentYear, currentMonth, 1);
        const firstDay = firstDayOfMonth.getDay();
        const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();

        document.getElementById("month-year").textContent = `${months[currentMonth]} ${currentYear}`;

        const calendarGrid = document.getElementById("calendar-grid");
        while (calendarGrid.children.length > 7) {
            calendarGrid.removeChild(calendarGrid.lastChild);
        }

        // Thêm ô trống trước ngày đầu tiên
        for (let i = 0; i < firstDay; i++) {
            const emptyDiv = document.createElement("div");
            emptyDiv.className = "empty";
            calendarGrid.appendChild(emptyDiv);
        }

        // Lấy ngày hiện tại (chỉ phần ngày/tháng/năm, bỏ giờ phút)
        const today = new Date();
        const currentDateOnly = new Date(today.getFullYear(), today.getMonth(), today.getDate());

        for (let day = 1; day <= daysInMonth; day++) {
            const dayDiv = document.createElement("div");
            dayDiv.className = "day";
            dayDiv.textContent = day;

            const date = new Date(currentYear, currentMonth, day);

            if (date <= currentDateOnly) {
                // Nếu là ngày trong quá khứ thì vô hiệu hóa
                dayDiv.classList.add("disabled");
            } else {
                // Cho phép chọn ngày
                dayDiv.addEventListener("click", function () {
                    const selectedDay = document.querySelector(".calendar-grid .selected");
                    if (selectedDay) {
                        selectedDay.classList.remove("selected");
                    }

                    dayDiv.classList.add("selected");

                    const dayStr = String(day).padStart(2, '0');
                    const monthStr = String(currentMonth + 1).padStart(2, '0');
                    const dateValue = `${currentYear}-${monthStr}-${dayStr}`;

                    document.getElementById("selected-date").value = dateValue;
                });
            }

            calendarGrid.appendChild(dayDiv);
        }
    }

    function prevMonth() {
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        renderCalendar();
    }

    function nextMonth() {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        renderCalendar();
    }

    renderCalendar();



    document.querySelectorAll('input[name="shift"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('.shift-option').forEach(label => {
                label.classList.remove('selected');
            });
            this.closest('label').classList.add('selected');
        });
    });
</script>


<style>
    .khung {
        background: linear-gradient(to bottom, #fff8e1);
        /* background: linear-gradient(to bottom, #fff8e1, #e4f0ea); */
    }
    .calendar {
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        text-align: center;
        width: 65%;
    }


    .calendar-header {
        background-color: #f8f8f8;
        text-align: center;
        padding: 10px;
        font-weight: bold;
        border-bottom: 1px solid #ddd;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }


    .calendar-header button {
        background: none;
        border: none;
        font-size: 16px;
        cursor: pointer;
    }


    .calendar-header button:hover {
        color: #007bff;
    }


    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 1px;
    }


    .calendar-grid div {
        padding: 10px;
        text-align: center;
        border: 1px solid #ddd;
    }


    .calendar-grid .day-name {
        font-weight: bold;
        color: #333;
        background-color: #f0f0f0;
    }


    .calendar-grid .day {
        background-color: #fff;
    }


    .calendar-grid .day:hover {
        background-color: #e0e0e0;
        cursor: pointer;
    }


    .calendar-grid .empty {
        background-color: #f8f8f8;
    }


    .wpbc_times_selector .col-md-5 {
        padding: 5px;
        border-radius: 5px;
        margin: 5px;
        background-color: #f8f8f8;
        cursor: pointer;
        border: 1px solid #ddd;
        text-align: center;
    }


    .wpbc_times_selector .col-md-5:hover {
        background-color: #d0d0d0;
    }


    .wpbc_time_selected {
        background-color: #007bff;
        color: white;
    }


    .height-60vh {
        height: 60vh;
    }

    .margin-left-w {
        margin-left: 17.5%;
        width: 65%;
    }


    .margin-left-w label {
        font-weight: bold;
        margin-top: 25px;
    }


    .margin-left-2w {
        width: 65%;
    }


    .margin-left-2w label {
        font-weight: bold;
        margin-top: 25px;
    }


    .calendar-grid .day.selected {
        background-color: #007bff;
        color: white;
    }

    .day.disabled {
        color: #aaa;
        background-color: #f5f5f5;
        pointer-events: none;
        cursor: default;
    }


    .shift-option {
        cursor: pointer;
        border: 2px solid #ccc;
        padding: 10px;
        text-align: center;
        border-radius: 8px;
        transition: 0.3s;
        background-color: white;
    }


    .shift-option.selected {
        border-color: #007bff;
        background-color: #cce5ff;
        color: #004085;
    }
</style>
@endsection