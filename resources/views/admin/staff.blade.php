@extends('admin.index')

@section('content')
    <div class="d-flex justify-content-center align-items-center">
        <div class="w-90">
            <h2>Quản lý nhân viên</h2>


            <div class="col-md-12">
                <div class="table-staff">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Họ tên</th>
                                <th>Số điện thoại</th>
                                <th>Email</th>
                                <th>Địa chỉ</th>
                                <th>Ngày sinh</th>
                           
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($staffs as $staff)
                                <tr data-id={{ $staff->id }}>
                                    <td>{{ $staff->name }}</td>
                                    <td>{{ $staff->phone }}</td>
                                    <td>{{ $staff->email }}</td>
                                    <td>{{ $staff->address }}</td>
                                    <td>{{ $staff->birth_date }}</td>
                                    <td hidden><input type="hidden" class="account_number" value="{{ $staff->account_number }}"></td>

                                    <td>
                                        <button class="btn btn-danger" onclick="deleteStaff(this)">Xóa</button>
    
                                        <button class="btn btn-primary" onclick="openStaffModal(this)"><a
                                                href="#">Sửa</a></button>
                                    </td>
                                </tr>
                                
                            @endforeach
                        </tbody>
                    </table>
                </div>
               

                <button class="btn btn-primary big-btn"><a href="{{ url('/admin/manage-sche') }}">Lịch làm việc</a></button>
                <button class="btn btn-primary big-btn"><a href="{{ url('/admin/pay-salary') }}">Trả lương</a></button>
                <button onclick="add_staff()" class="btn btn-primary big-btn">Thêm nhân viên</button>
            </div>
        </div>
    </div>

    <!-- MODAL -->
    <div class="modal fade" id="staffModal" tabindex="-1" aria-labelledby="staffModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thông tin nhân viên</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <form id="staffForm" action="#" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Họ tên</label>
                                <input type="text" id="modal-name" name="name" class="form-control">
                                <label>Số điện thoại</label>
                                <input type="text" id="modal-phone" name="phone" class="form-control">
                                <label>Ngày sinh</label>
                                <input type="date" id="modal-birth_date" name="birth_date" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Email</label>
                                <input type="email" id="modal-email" name="email" class="form-control">
                                <label>Địa chỉ</label>
                                <input type="text" id="modal-address" name="address" class="form-control">
                                <label>Số tài khoản</label>
                                <input type="text" id="modal-account_number" name="account_number" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addStaffModal" tabindex="-1" aria-labelledby="staffModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm thông tin nhân viên</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <form id="staffForm" action="{{ url('/admin/staff/add') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Họ tên</label>
                                <input type="text" id="modal-name" name="name" class="form-control">
                                <label>Số điện thoại</label>
                                <input type="text" id="modal-phone" name="phone" class="form-control">
                                <label>Ngày sinh</label>
                                <input type="date" id="modal-birth_date" name="birth_date" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Email</label>
                                <input type="email" id="modal-email" name="email" class="form-control">
                                <label>Địa chỉ</label>
                                <input type="text" id="modal-address" name="address" class="form-control">
                                <label>Số tài khoản</label>
                                <input type="text" id="modal-account_number" name="account_number"
                                    class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- FORM XÓA NHÂN VIÊN (Ẩn) -->
    <form id="deleteForm" method="POST" style="display: none;">
        @csrf

    </form>


    <script>
        function openStaffModal(button) {
            const row = button.closest('tr');
            const cells = row.getElementsByTagName('td');

            const staffId = row.getAttribute('data-id');
            document.getElementById('modal-name').value = cells[0].innerText.trim();
            document.getElementById('modal-phone').value = cells[1].innerText.trim();
            document.getElementById('modal-email').value = cells[2].innerText.trim();
            document.getElementById('modal-address').value = cells[3].innerText.trim();
            document.getElementById('modal-birth_date').value = cells[4].innerText.trim();
            document.getElementById('modal-account_number').value = row.querySelector('.account_number').value;


            document.getElementById('staffForm').action = `/admin/staff/${staffId}/update`;

            const modal = new bootstrap.Modal(document.getElementById('staffModal'));
            modal.show();
        }

        function deleteStaff(button) {
            const row = button.closest('tr');
            const staffId = row.getAttribute('data-id');

            if (confirm("Bạn có chắc chắn muốn xóa nhân viên này?")) {
                const form = document.getElementById('deleteForm');
                form.action = `/admin/staff/${staffId}/delete`;
                form.submit();
            }
        }

        function add_staff() {
            const model = new bootstrap.Modal(document.getElementById('addStaffModal'));
            model.show();
        }
    </script>

    <style>
        .table-staff {
            margin-top: 3%;
            overflow: auto;
            max-height: 70vh;
            width: 100%;
        }

        .w-90 {
            width: 90%;
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

        .big-btn {
            margin-top: 2%;
            width: 15%;
            margin-left: 2%;
        }

        .big-btn a {
            text-decoration: none;
        }

        .btn-primary a,
        .btn-danger a {
            color: white;
        }

        .btn-primary a:hover,
        .btn-danger a:hover {
            color: white;
        }
    </style>
@endsection
