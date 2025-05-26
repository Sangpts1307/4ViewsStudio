<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Work_Schedule;
use App\Services\GoogleCalendarService;
use Carbon\Carbon;
use Google\Service\AdMob\App;

use function Laravel\Prompts\form;

class AppointmentController extends Controller
{
    // Hiển thị danh sách cuộc hẹn
    public function index()
    {
        $appointments = Appointment::with(['user', 'concept', 'shift', 'staff'])->orderBy('work_day', 'DESC')->get();
        foreach ($appointments as $appointment) {
            $availableStaffs = User::where('role', User::ROLE_STAFF)
                ->whereIn('id', function ($query) use ($appointment) {
                    $query->select('user_id')
                        ->from('work_schedules')
                        ->where('shift_id', $appointment->shift_id)
                        ->whereDate('work_day', $appointment->work_day);
                })
                ->get();
            $appointment->setRelation('availableStaffs', $availableStaffs);
        }
        return view('admin.appointment-sche', compact('appointments'));
    }

    // Phân công staff cho cuộc hẹn
    public function assignStaff(Request $request)
    {
        // Tìm cuộc hẹn theo ID
        $appointment = Appointment::find($request->appointment_id);
        if (!$appointment) {
            return redirect()->back()->with('error', 'Không tìm thấy cuộc hẹn.');
        }
        // Lấy danh sách staff đã được phân công trong cùng ca và ngày (để tránh trùng)
        $assignedStaffIds = Appointment::whereDate('work_day', $appointment->work_day)
            ->where('shift_id', $appointment->shift_id)
            ->whereNotNull('staff_id')
            ->pluck('staff_id')
            ->toArray();
        // Lấy danh sách staff có trong lịch làm việc của ca & ngày đó (work_schedules)
        $availableStaffs = User::where('role', User::ROLE_STAFF)
            ->whereIn('id', function ($query) use ($appointment) {
                $query->select('user_id')
                    ->from('work_schedules')
                    ->where('shift_id', $appointment->shift_id)
                    ->whereDate('work_day', $appointment->work_day);
            })
            ->whereNotIn('id', $assignedStaffIds)
            ->get();
        // Kiểm tra staff_id gửi lên có hợp lệ trong danh sách staff có thể phân công không
        $staffId = $request->staff_id;
        // dd($staffId);
        if (empty($staffId) || $staffId == null) {
            $appointment->staff_id = null;
            return redirect()->back()->with('error', 'Thợ chụp không hợp lệ hoặc đã có lịch làm việc trong ca này.');
        } else {
            $tmp = Appointment::where('staff_id', $staffId)
                ->whereDate('work_day', $appointment->work_day)
                ->where('shift_id', $appointment->shift_id)
                ->first();
            // dd($tmp);
            //  dd($tmp);
            if ($tmp == null) {
                // Cập nhật staff_id cho cuộc hẹn

                $appointment->staff_id = $staffId;
                $appointment->status = Appointment::STATUS_CONFIRMED;
                $appointment->save();
                return redirect()->back()->with('success', 'Thợ chụp cập nhật thành công.');
            } else if ($tmp != null) {
                // Nếu đã có lịch làm việc trong ca này, không cập nhật
                return redirect()->back()->with('error', 'Thợ chụp đã có lịch làm việc trong ca này.');
            }
        }
    }




    // Tìm kiếm cuộc hẹn
    public function search(Request $request)
    {
        $param = $request->all();
        $query = Appointment::with(['user', 'staff', 'concept', 'shift']);

        if ($request->filled('name')) {
            $query->whereHas('user', function ($queryBuilder) use ($param) {
                $queryBuilder->where('name', 'like', '%' . $param['name'] . '%');
            });
        }
        if ($request->filled('phone')) {
            $query->whereHas('user', function ($queryBuilder) use ($param) {
                $queryBuilder->where('phone', '=', $param['phone']);
            });
        }
        if ($request->filled('day')) {
            $query->whereDate('work_day', $param['day']);
        }
        $appointments = $query->get();
        foreach ($appointments as $appointment) {
            $availableStaffs = User::where('role', User::ROLE_STAFF)
                ->whereIn('id', function ($query) use ($appointment) {
                    $query->select('user_id')
                        ->from('work_schedules')
                        ->where('shift_id', $appointment->shift_id)
                        ->whereDate('work_day', $appointment->work_day);
                })
                ->get();
            $appointment->setRelation('availableStaffs', $availableStaffs);
        }
        return view('admin.appointment-sche', compact('appointments'));
    }


    // Tạo sự kiện trên Google Calendar cho cuộc hẹn
    public function async(Request $request, $id)
    {
        $param = $request->all();
        $query = Appointment::with(['user', 'staff', 'concept', 'shift'])
            ->find($id);
        $googleCalendarService = new GoogleCalendarService();
        $googleCalendarService->getEvents();
        $workDay = Carbon::create($query->work_day)->format('Y-m-d');

        // async admin-calendar
        $googleCalendarService->createEvent(
            $query->concept->name,
            $query->concept->short_content,
            $workDay . ' ' . $query->shift->start_time,
            $workDay . ' ' . $query->shift->end_time,
            [],
            config('services.google.calendar_id')
        );
        // async staff-calendar
        $googleCalendarService->createEvent(
            $query->concept->name,
            $query->concept->short_content,
            $workDay . ' ' . $query->shift->start_time,
            $workDay . ' ' . $query->shift->end_time,
            [],
            $query->staff->email
        );
        // async user-calendar
        $googleCalendarService->createEvent(
            $query->concept->name,
            $query->concept->short_content,
            $workDay . ' ' . $query->shift->start_time,
            $workDay . ' ' . $query->shift->end_time,
            [],
            $query->user->email
        );
        $query->status = Appointment::STATUS_ASYNC;
        $query->save();
        return redirect('/admin/appointment-sche');
    }
}
