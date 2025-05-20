@extends('admin.index')

@section('content')
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="d-flex justify-content-center align-items-center mt-3">
        <div class="w-95">
            <div id="header">
                <h2><i class="fa-solid fa-money-bill-wave"></i> Quản lý chi tiêu</h2>
            </div>

            <form method="POST" id="expenseForm" action="{{ url('/admin/expense/store') }}">
                @csrf
                <input type="hidden" name="id" id="expense_id" value="">

                <div class="col-md-12 content">
                    <div class="row mb-3">
                        <div class="col-md-6 mb-2">
                            <label for="">Tên danh mục</label>
                            <input type="text" class="form-control" name="name" id="name"
                                placeholder="Tên danh mục" required>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="">Giá thành</label>
                            <input type="number" class="form-control" name="price" id="price" placeholder="Giá thành"
                                required>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 content">
                    <div class="row mb-3">
                        <div class="col-md-6 mb-2">
                            <label for="">Ngày thực hiện</label>
                            <input type="date" class="form-control" name="expense_day" id="expense_day" required>
                        </div>

                        <div class="col-md-6 mb-2">
                            <label for=""></label>
                            <div class="col-md-12 d-flex">
                                <button type="submit" class="btn btn-success me-2" id="btnSave" >
                                    <i class="fa-solid fa-plus"></i> Thêm mới
                                </button>

                                <button type="button" class="btn btn-primary" id="btnReset"
                                    style="width: 20%; display: none;">
                                    <i class="fa-solid fa-pen-to-square"></i> Cập nhật
                                </button>

                            </div>

                        </div>
                    </div>
                </div>

            </form>

            <div class="table-expense">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Tên danh mục</th>
                            <th>Ngày</th>
                            <th>Giá thành</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($expenses as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->expense_day)->format('d/m/Y') }}</td>
                                <td>{{ number_format($item->price, 0, ',', '.') }}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm me-1 btnEdit"
                                        data-id="{{ $item->id }}">Sửa</button>

                                    <form method="POST" action="{{ url('/admin/expense/delete/' . $item->id) }}"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Bạn chắc chắn muốn xóa?')">Xóa</button>
                                    </form>
                                </td>
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

        .content {
            margin-top: 15px;
        }

        .table-expense {
            margin: 20px 10px 10px 10px;
        }

        .table th,
        .table td {
            text-align: center;
            vertical-align: middle;
        }

        #header h2 {
            font-weight: bold;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const editButtons = document.querySelectorAll('.btnEdit');
            const form = document.getElementById('expenseForm');
            const idField = document.getElementById('expense_id');
            const nameField = document.getElementById('name');
            const priceField = document.getElementById('price');
            const dateField = document.getElementById('expense_day');
            const saveButton = document.getElementById('btnSave');

            editButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.dataset.id;
                    fetch(`/admin/expense/edit/${id}`)
                        .then(response => response.json())
                        .then(data => {
                            idField.value = data.id;
                            nameField.value = data.name;
                            priceField.value = data.price;
                            dateField.value = data.expense_day.split(' ')[0];

                            console.log(dateField);
                            form.action = `/admin/expense/update/${data.id}`;
                            saveButton.innerHTML =
                                `<i class="fa-solid fa-pen-to-square"></i> Cập nhật`;
                            document.getElementById('btnReset').style.display = 'none';

                        });
                });
            });

            document.getElementById('btnReset').addEventListener('click', function() {
                idField.value = '';
                nameField.value = '';
                priceField.value = '';
                dateField.value = '';
                form.action = "{{ url('/admin/expense/store') }}";
                saveButton.innerHTML = `<i class="fa-solid fa-plus"></i> Lưu`;
            });
        });
    </script>
@endsection
