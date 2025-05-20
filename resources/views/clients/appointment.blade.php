@extends ('clients.index')
@section('content')
<div class="khung">
    <div class="container trong-khung">
        <h2 class="text-center margin-bottom-50px">
            <i class="fa-regular fa-calendar-check"></i> LỊCH HẸN CỦA TÔI
        </h2>
        <table class="table table-hover table-bordered text-center">
            <thead class="table-light">
                <tr>
                    <th>STT</th>
                    <th>Ngày Chụp</th>
                    <th>Ca Chụp</th>
                    <th>Concept</th>
                    <th>Thợ Chụp</th>
                    <th>Link ảnh</th>
                    <th>Trạng Thái</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($appointments as $index => $appointment)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($appointment->work_day)->format('d-m-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($appointment->shift->start_time)->format('H:i') }} 
                        - {{ \Carbon\Carbon::parse($appointment->shift->end_time)->format('H:i') }}
                    </td>
                    <td>{{ $appointment->concept->name ?? 'N/A' }}</td>
                    <td>{{ $appointment->staff->name ?? 'N/A' }}</td>
                    <td>
                        @if ($appointment->link_image)
                        <a href="{{ $appointment->link_image }}" target="_blank">Link ảnh</a>
                        @else
                        Không có
                        @endif
                    </td>
                    <td>
                        @switch($appointment->status)
                            @case(\App\Models\Appointment::STATUS_WAIT)
                            Chờ xác nhận
                            @break

                            @case(\App\Models\Appointment::STATUS_CONFIRMED)
                            Đã xác nhận
                            @break

                            @case(\App\Models\Appointment::STATUS_DONE)
                            Hoàn thành
                            @break

                            @default
                            Không rõ
                        @endswitch


                    </td>
                </tr>

                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

<style>
    .khung {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 700px;
        background-color: #fff8e1;
        padding-bottom: 100px;
    }

    .trong-khung {
        background-color: white;
        padding: 50px 40px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        max-width: 1200px;
        margin-top: 30px;
        min-height: 500px;
        overflow-y: auto;
        height: auto;
    }

    .margin-bottom-50px {
        margin-bottom: 50px;
        color: #333;
    }
</style>