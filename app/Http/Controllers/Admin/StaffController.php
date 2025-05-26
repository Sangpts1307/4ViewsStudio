<?php

namespace App\Http\Controllers\Admin;

use App\Exports\SalaryExport;
use App\Http\Controllers\Controller;
use App\Models\Salary;
use App\Models\Shift;
use App\Models\User;
use App\Models\Work_Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class StaffController extends Controller
{
    // Hiển thị danh sách nhân viên
    public function index(Request $request)
    {
        $params = $request->all();
        $staffs = User::where('role', User::ROLE_STAFF)
            ->orderBy('id', 'desc')->get();
        return view('admin.staff', compact('staffs'));
    }

    // Câp nhật thông tin nhân viên
    public function updateStaff(Request $request, int $staffId)
    {
        $params = $request->all();
        $staff = User::find($staffId);
        $staff->name = $params['name'];
        $staff->phone = $params['phone'];
        $staff->email = $params['email'];
        $staff->birth_date = $params['birth_date'];
        $staff->address = $params['address'];
        $staff->account_number = $params['account_number'];
        $staff->save();
        return redirect('/admin/staff')->with('update', 'Cập nhật thông tin nhân viên thành công.');
    }

    // Thêm mới nhân viên
    public function addStaff(Request $request)
    {
        $params = $request->all();
        $staff = new User();
        $staff->name = $params['name'];
        $staff->phone = $params['phone'];
        $staff->email = $params['email'];
        $staff->birth_date = $params['birth_date'];
        $staff->address = $params['address'];
        $staff->account_number = $params['account_number'];
        $staff->password = User::getDefaultPassword();
        $staff->role = User::ROLE_STAFF;
        $staff->save();
        return redirect('/admin/staff')->with('success', 'Thêm thông tin nhân viên thành công.');
    }

    // Xóa nhân viên
    public function deleteStaff(Request $request, int $staffId)
    {
        $staff = User::find($staffId);
        if ($staff) {
            $staff->delete();
            return redirect('/admin/staff')->with('success', 'Xóa nhân viên thành công');
        }
        return redirect('/admin/staff')->with('error', 'Không tìm thấy nhân viên');
    }


    // Quản lý lịch làm việc
    public function schedule(Request $request)
    {
        $date = $request->input('date', Carbon::now()->format('Y-m-d'));
        $shiftId = $request->input('shift_id', null);

        $shifts = Shift::all();
        // Lấy danh sách lịch làm việc theo ngày
        $schedules = Work_Schedule::with(['user', 'shift'])
            ->whereDate('work_day', $date)
            ->get()
            ->groupBy('shift_id');
            // Lấy danh sách lịch làm việc theo ngày và ca
        // Lấy danh sách nhân viên đã được phân công và chưa được phân công
        $assignedStaffs = [];
        $unassignedStaffs = [];
        if ($shiftId) {
            // Lấy danh sách nhân viên đã được phân công cho ca và ngày này
            $assignedStaffs = Work_Schedule::with('user')
                ->whereDate('work_day', $date)
                ->where('shift_id', $shiftId)
                ->get();
            // Lấy danh sách nhân viên chưa được phân công cho ca và ngày này
            $unassignedStaffs = User::where('role', User::ROLE_STAFF)
                ->whereNotIn('id', $assignedStaffs->pluck('user_id'))
                ->get();
        }
        return view('admin.manage-sche', compact('shifts', 'assignedStaffs', 'unassignedStaffs', 'schedules', 'date', 'shiftId'));
    }

    // Lưu lịch làm việc
    public function saveSchedule(Request $request)
    {
        $params = $request->all();
        $shiftId = $params['shift_id'];
        $date = $params['date'];
        $employees = $params['employees'] ?? [];
        // Xóa các lịch làm việc cũ của ca làm và ngày này
        DB::table('work_schedules')
            ->where('shift_id', $shiftId)
            ->whereDate('work_day', $date)
            ->delete();
        // Thêm các lịch làm việc mới
        foreach ($employees as $employeeId) {
            $schedule = new Work_Schedule();
            $schedule->shift_id = $shiftId;
            $schedule->user_id = $employeeId;
            $schedule->work_day = $date;
            $schedule->save();
        }
        // Chuyển hướng về trang quản lý lịch làm với thông báo thành công
        return redirect('/admin/manage-sche?date=' . $date)
            ->with('success', 'Lịch làm việc đã được cập nhật thành công.');
    }



    // Trả lương nhân viên
    public function paySalary(Request $request)
    {
        $month = $request->input('month')
            ? Carbon::parse($request->input('month'))->format('Y-m')
            : now()->subMonth()->format('Y-m');
        $staffs = DB::table('salaries')
            ->join('users', 'users.id', '=', 'salaries.user_id')
            ->where('month', $month)
            ->get();
        if ($request->filled('staff_id')) {
            $staffId = $request->input('staff_id');
            $month = $request->input('month');

            Salary::where('user_id', $staffId)
                ->where('month', $month)
                ->update(['status' => Salary::PAID]); // Hoặc giá trị bạn muốn
            return redirect('/admin/pay-salary?month=' . $month)
                ->with('success', 'Trả lương nhân viên thành công.');
            // Có thể trả về một response hoặc redirect sau khi cập nhật thành công
        }
        return view('admin.pay-salary', compact('staffs', 'month'));
    }


    // Trả lương nhân viên theo tháng
    // Hiển thị thông tin trả lương của nhân viên
    public function pay(Request $request)
    {
        $userId = $request->input('user_id');
        $month = $request->input('month');
        // Retrieve the staff data based on the user_id and month
        $staff = DB::table('salaries')
            ->join('users', 'users.id', '=', 'salaries.user_id')
            ->where('salaries.month', $month)
            ->where('salaries.user_id', $userId)
            ->first();
        return view('admin.pay', compact('staff', 'month'));
    }

    
    // Xuất bảng lương theo tháng
    public function export(Request $request)
    {
        $month = $request->input('month');
        // Ép kiểu chuỗi thành đối tượng Carbon
        $carbonDate = Carbon::parse($month);

        // Định dạng lại
        $monthFormat = $carbonDate->format('m_Y'); // hoặc 'm-Y'
        return Excel::download(new SalaryExport($month), 'bangluongthang' . $monthFormat . '.xlsx');
    }
}
