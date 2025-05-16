<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\GoogleCalendarService;
use Carbon\Carbon;
use Google\Service\AdMob\App;

use function Laravel\Prompts\form;

class AppointmentController extends Controller
{
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
        $appointment->status = Appointment::STATUS_CONFIRMED;
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
            $query->concept->name, $query->concept->short_content, 
            $workDay . ' ' . $query->shift->start_time, $workDay . ' ' . $query->shift->end_time,
            [], config('services.google.calendar_id')
        );
        // async staff-calendar
        $googleCalendarService->createEvent(
            $query->concept->name, $query->concept->short_content, 
            $workDay . ' ' . $query->shift->start_time, $workDay . ' ' . $query->shift->end_time,
            [], $query->staff->email
        );
        // async user-calendar
        $googleCalendarService->createEvent(
            $query->concept->name, $query->concept->short_content, 
            $workDay . ' ' . $query->shift->start_time, $workDay . ' ' . $query->shift->end_time,
            [], $query->user->email
        );
        
        /** async if use google workspace and change tham so dau vao trong service*/ 
        // $googleCalendarService->createEvent(
        //     $query->concept->name, $query->concept->short_content, 
        //     $workDay . ' ' . $query->shift->start_time, $workDay . ' ' . $query->shift->end_time,
        //     // here is email of staff and user
        //     [
        //         $query->staff->email,
        //         $query->user->email
        //     ]
        // );
        $query->status = Appointment::STATUS_ASYNC;
        $query->save();
        
        return redirect('/admin/appointment-sche');
    }
}
