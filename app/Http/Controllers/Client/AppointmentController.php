<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        // $userId = Auth::id();
        $userId = session('user_id');
        if ($request->has(['shift_id', 'work_day', 'concept_id'])) {
            $shiftId = $request->input('shift_id');
            $work_day = $request->input('work_day');
            $conceptId = $request->input('concept_id');
            // dd($shiftId, " date", $work_day, "conceptId ", $conceptId);
            $appointment = new Appointment();
            $appointment->shift_id = $shiftId;
            $appointment->concept_id = $conceptId;
            $appointment->work_day = $work_day;
            $appointment->user_id = $userId;
            $appointment->save();


            $contract = new Contract();
            $contract->appointment_id = $appointment->id;
            $contract->save();
            return redirect('/clients/appointments');
        }


        $appointments = Appointment::with(['staff', 'concept', 'shift'])
            ->where('user_id', $userId)
            ->orderBy('work_day', 'asc')
            ->get();

        return view('clients.appointment', compact('appointments'));
    }
}
