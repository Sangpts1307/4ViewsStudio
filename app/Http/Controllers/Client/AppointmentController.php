<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\MailBooking;
use App\Models\Contract;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Concept;
use App\Models\Shift;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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
        

            $appointment = new Appointment();
            $appointment->shift_id = $shiftId;
            $appointment->concept_id = $conceptId;
            $appointment->work_day = $work_day;
            $appointment->user_id = $userId;
            $appointment->save();

            $user = User::find($userId);
            $shift = Shift::find($shiftId);
            $concept = Concept::find($conceptId);

            $contract = new Contract();
            $contract->appointment_id = $appointment->id;
            $contract->save();

            try {
                $workDay = Carbon::create($work_day)->format('d-m-Y');
                $startTime = Carbon::parse($shift->start_time)->format('H:i');
                $endTime = Carbon::parse($shift->end_time)->format('H:i');

                $mailBooking = new MailBooking();
                $mailBooking->setConcept($concept->name);
                $mailBooking->setWorkDay($workDay);
                $mailBooking->setShift($startTime . ' - ' . $endTime);
                $mailBooking->setPrice($concept->price);
                $mailBooking->setDeposit($concept->price * Contract::SCALE_DEPOSIT);
                
                Mail::to($user->email)->send($mailBooking);
                return redirect('/clients/appointments');
            } catch (\Exception $e) {
                dd($e);
            }
        }

        $appointments = Appointment::with(['staff', 'concept', 'shift'])
            ->where('user_id', $userId)
            ->orderBy('work_day', 'desc')
            ->get();

        return view('clients.appointment', compact('appointments'));
    }
}
