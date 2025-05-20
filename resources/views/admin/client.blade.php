@extends('admin.index')

@section('content')
    <div class="d-flex justify-content-center align-items-center mt-3" style="min-height: 0vh;">
        <div class="w-95">
            <h2>Thông tin khách hàng</h2>

            <form action="{{ url('/admin/clients/search') }}" method="GET">
                <div class="col-md-6 margin-top-2">
                    <div class="row">
                        <div class="col-md-8">
                            <input type="text" name="inf" value="{{ request('inf') }}" class="form-control" placeholder="Thông tin">
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-primary">Tìm kiếm</button>
                        </div>
                    </div>
                </div>
            </form>

            <div class="table-responsive-custom">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Tên khách hàng</th>
                            <th>Số điện thoại</th>
                            <th>Email</th>
                            <th>Địa chỉ</th>
                            <th>Ngày sinh</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clients as $client)
                            <tr>
                                <td>{{ $client->name }}</td>
                                <td>{{ $client->phone }}</td>
                                <td>{{ $client->email }}</td>
                                <td>{{ $client->address }}</td>
                                <td>{{ \Carbon\Carbon::parse($client->birth_date)->format('d-m-Y') }}</td>
                                <td>
                                    <a href="{{ url('/admin/clients/show/' . $client->id) }}" class="btn btn-primary">Xem hồ sơ</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Không tìm thấy khách hàng nào.</td>
                            </tr>
                        @endforelse
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

        .table-responsive-custom {
            max-height: 620px;
            overflow-y: auto;
            margin-top: 20px;
        }

        .table-responsive-custom table {
            width: 100%;
            border-collapse: collapse;
        }

        /* .table-responsive-custom thead th {
            background-color: #f8f9fa;
            position: sticky;
            top: 0;
            z-index: 1;
            border-bottom: 2px solid #dee2e6;
        }

        .table-responsive-custom th, .table-responsive-custom td {
            padding: 0.75rem;
            border: 1px solid #dee2e6;
            text-align: left;
        } */
    </style>
@endsection
