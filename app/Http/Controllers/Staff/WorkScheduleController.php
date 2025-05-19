<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Mail\MailLinkImage;
use App\Models\Appointment;
use App\Models\Concept;
use App\Models\Contract;
use App\Models\Shift;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class WorkScheduleController extends Controller
{

    public function schedule(Request $request)
    {
        $userId = session('user_id');
        $month = $request->input('month') ?? date('Y-m');
        $carbonMonth = Carbon::parse($month);

        // Lấy tháng và năm từ đối tượng Carbon
        $_month = $carbonMonth->format('m');  // Lấy tháng
        $_year = $carbonMonth->format('Y');   // Lấy năm

        $staffShedule = DB::table('shifts')
            ->join('work_schedules', 'shifts.id', '=', 'work_schedules.shift_id')
            ->where('user_id', $userId)
            ->whereMonth('work_day', $_month)
            ->whereYear('work_day', $_year)
            ->orderBy('work_day', 'asc')
            ->orderBy('start_time', 'asc')
            ->get();
        $shifts = Shift::orderBy('start_time', 'asc')->get();


        return view('staff.work-schedule', compact('staffShedule', 'shifts', 'month'));
    }
    public function scheduleDetail(Request $request)
    {
        $date = null;
        $userId = session('user_id');

        if ($request->filled('date')) {

            // Lấy đúng định dạng ngày từ URL và chuyển sang định dạng chuẩn (Y-m-d)
            $date = $request->input('date');

            if (!Carbon::hasFormat($date, 'Y-m-d') && Carbon::hasFormat($date, 'd/m/y')) {
                $date = Carbon::createFromFormat('d/m/y', $date)->format('Y-m-d');
            }
            
        } else {
            $date = Carbon::now()->format('Y-m-d');
            //dd($date);
        }
        
        
       // dd($shifts);
        $schedules = Appointment::with(['staff', 'concept', 'shift', 'user'])
            ->whereDate('work_day', $date)
            ->whereHas('staff', function ($query) use ($userId) {
                $query->where('id', $userId);
            })
            ->get();
            $bookedShiftIds = $schedules->pluck('shift_id')->toArray();

            $shifts = DB::table('work_schedules')
            ->join('shifts', 'work_schedules.shift_id', '=', 'shifts.id')
            ->join('users', 'work_schedules.user_id', '=', 'users.id')
            ->whereDate('work_schedules.work_day', $date)
            ->where('users.id', $userId)
            ->whereNotIn('shifts.id', $bookedShiftIds)
            ->select('shifts.*') // lấy thêm gì tùy bạn
            ->get();
            $information = null;
            if($request->filled('appointment_id')){
                
                $appointmentId = $request->input('appointment_id');
                $information = Appointment::with(['concept', 'shift', 'user'])->find($appointmentId)  
                ;
            }
        
  
        return view('staff.schedule-detail', compact('date', 'schedules', 'shifts', 'information'));
    }

    public function addLinkImage(Request $request){
        $appointmentId = $request->input('appointment_id');
        $date = $request->input('date');
        $appointment = Appointment::find($appointmentId);
        $appointment->link_image = $request->input('link-image');
        $appointment->reply = $request->input('message');
        $appointment->status = Appointment::STATUS_DONE;
        $appointment->save();
        
        $staff = User::find($appointment->staff_id);
        $concept = Concept::find($appointment->concept_id);
        $shift = Shift::find($appointment->shift_id);
        $user = User::find($appointment->user_id);

        $contract = Contract::find($appointmentId);
        $contract->role = Contract::STATUS_PAID;
        $contract->save();

        // Send mail
        try {
            $workDay = Carbon::create($date)->format('d-m-Y');
            $startTime = Carbon::parse($shift->start_time)->format('H:i');
            $endTime = Carbon::parse($shift->end_time)->format('H:i');

            $mailLinkImage = new MailLinkImage();
            $mailLinkImage->setStaff($staff->name);
            $mailLinkImage->setConcept($concept->name);
            $mailLinkImage->setWorkDay($workDay);
            $mailLinkImage->setShift($startTime . ' - ' . $endTime);
            $mailLinkImage->setLinkImage($appointment->link_image);
            $mailLinkImage->setMessage($appointment->reply);
            // dd($staff->name, $concept->name, $startTime . ' - ' . $endTime, $appointment->link_image, $appointment->reply);
            
            Mail::to($user->email)->send($mailLinkImage);
        } catch (\Exception $e) {
            dd($e);
        }
        return redirect('/staff/schedule-detail?date='.$date)
            ->with('success', 'Đã gửi ảnh đến khách hàng!');
    }
}
