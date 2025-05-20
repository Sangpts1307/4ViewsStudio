<?php

namespace App\Http\Controllers\Client;

use App;
use App\Models\User;
use App\Models\Shift;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Concept;

class BookingController extends Controller
{
    public function showBookingForm(Request $request)
    {
        $shifts = Shift::all();
        $concepts = Concept::all();
        $userId = session('user_id');
        $user = User::find($userId);
        $conceptId = null;
        if ($request->filled('concept_id')) {
            $conceptId = $request->input('concept_id');
        }
        return view('clients.booking', compact('shifts', 'concepts', 'conceptId', 'user'));
    }

    public function processBooking(Request $request)
    {
        $params = $request->all();

        $userId = session('user_id');
        $shiftId = $params['shift'];
        $conceptId = $params['concept'];
        $work_day = $params['date'];

        if ($this->checkExist($work_day, $shiftId, $userId) > 0) {
            return back()->with('error', 'Đã có lịch hẹn trong ca này!');
        }

        $countBooking = Appointment::where('shift_id', $shiftId)
        ->whereDate('work_day', $work_day)->count();
        if ($countBooking >= 3){
            return redirect()->back()->withErrors(['Ca làm việc này đã đủ số lượng đặt lịch. Vui lòng chọn ca khác.']);
        }
        $message = $params['message'];
        $shift = Shift::find($shiftId);
        $concept = Concept::find($conceptId);

        return view('clients.bookingdetail', compact('message', 'work_day', 'concept', 'shift'));
    }

    public function checkExist($workDay, $shiftId, $userId)
    {
        $count = Appointment::where('user_id', $userId)
            ->where('work_day', $workDay)
            ->where('shift_id', $shiftId)
            ->count();
        return $count;
    }
}
