<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['user', 'concept', 'shift', 'staff'])->get();
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

    public function assignStaff(Request $request)
    {
        $appointment = Appointment::find($request->appointment_id);

        if (!$appointment) {
            return redirect()->back()->with('error', 'Không tìm thấy cuộc hẹn.');
        }

        $availableStaffs = User::where('role', User::ROLE_STAFF)
            ->whereIn('id', function ($query) use ($appointment) {
                $query->select('user_id')
                    ->from('work_schedules')
                    ->where('shift_id', $appointment->shift_id)
                    ->whereDate('work_day', $appointment->work_day);
            })
            ->pluck('id')
            ->toArray();

        if (empty($request->staff_id) || !in_array($request->staff_id, $availableStaffs)) {
            $appointment->staff_id = null;
        } else {
            $appointment->staff_id = $request->staff_id;
        }

        $appointment->save();

        return redirect()->back()->with('success', 'Thợ chụp cập nhật thành công.');
    }


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
}
