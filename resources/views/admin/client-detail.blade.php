@extends('admin.index')

@section('content')


<form action="{{ url('/admin/clients/show/' . $client->id) }}" method="GET">
    <div class="d-flex justify-content-center align-items-center" style="min-height: auto;">
        <div class="w-95">
            <h2 class="">Chi tiết hồ sơ khách hàng</h2>
            <div class="col-md-6 margin-top-2">
                <div class="row">
                    <div class="col-md-8">
                        <input type="text" name="search" value="{{ request()->input('search') }}" class="form-control" placeholder="Thông tin thợ chụp hoặc gói concept" aria-describedby="basic-addon1">
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary">Tìm kiếm</button>
                    </div>
                </div>
            </div>

            <table class="table table-bordered margin-top-2 mx-auto" style="text-align: center;">
                <thead>
                    <tr>
                        <th>Ngày chụp</th>
                        <th>Ca chụp</th>
                        <th>Gói concept</th>
                        <th>Thợ chụp</th>
                        <th>Lưu trữ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appointments as $app)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($app->work_day)->format('d/m/Y') }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($app->shift->start_time)->format('H:i') }} -
                            {{ \Carbon\Carbon::parse($app->shift->end_time)->format('H:i') }}
                        </td>
                        <td>{{ $app->concept->name }}</td>
                        <td>{{ $app->staff->name ?? 'Chưa xác nhận' }}</td>
                        @if ($app->status == \App\Models\Appointment::STATUS_DONE)
                        <td><a href="{{ $app->link_image }}" target="_blank">Link ảnh</a></td>
                        @else
                        <td>Chưa có link ảnh</td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</form>

<style>
    .w-95 {
        width: 95%;
        border: 1px solid #ccc;
        padding: 20px;
        border-radius: 5px;
        margin: 20px auto;
        /* Thêm margin trên và dưới để tách biệt */
        background-color: #f8f9fa;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .col-md-6 label {
        margin-top: 2%;
    }

    .margin-top-2 {
        margin-top: 2%;
    }

    .big-btn {
        width: 20%;
        margin-top: 5%;
    }
</style>
@endsection