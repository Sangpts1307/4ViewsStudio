<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Contract;
use App\Models\Shift;
use App\Models\Appointment;
use App\Models\Concept;

use function Psy\sh;

class ContractController extends Controller
{
    public function create(Request $request)
    {
        $appointments = Appointment::all(); // để chọn cuộc hẹn cần tạo HĐ
        $concepts = Concept::all();
        $shifts = Shift::all();
    
        $price = $concepts->first()->price ?? 0;
    
        return view('admin.create-contract', compact('appointments', 'concepts', 'shifts', 'price'));
    }
    

    public function store(Request $request)
    {
        $params = $request->all();
        // Tìm appointment phù hợp
        $user = new User();
        $user->name = $params['ten_khach_hang'];
        $user->email = $params['gmail'];
        $user->phone = $params['so_dien_thoai'];
        $user->password = User::getDefaultPassword();
        $user->save();
        
        $appointment = new Appointment();
        $appointment->user_id = $user->id;
        $appointment->concept_id = $params['concept'];
        $appointment->shift_id = $params['ca_chup'];
        $appointment->work_day = $params['ngay_chup'];
        $appointment->save();

        $contract = new Contract();
        $contract->appointment_id = $appointment->id;
        $contract->save();
    

    return redirect('/admin/contract')->with('success', 'Tạo hợp đồng thành công!');
    }


//Tìm kiếm thông tin
    public function index(Request $request)
    {

        $contracts = DB::table('appointments')
        ->join('users', 'appointments.user_id', '=', 'users.id')
        ->join('concepts', 'appointments.concept_id', '=', 'concepts.id')
        ->join('contracts', 'contracts.appointment_id', '=', 'appointments.id')
        ->select(
            'users.name as user_name',
            'users.phone',
            'appointments.work_day',
            'concepts.price',
            'contracts.role',
            'contracts.id'
        );
        if ($request->filled('customer_name')) {
            $contracts->where('users.name', 'like', '%' . $request->customer_name . '%');
        }
        
        if ($request->filled('phone')) {
            $contracts->where('users.phone', 'like', '%' . $request->phone . '%');
        }
        
        if ($request->filled('contract_date')) {
            $contracts->whereDate('appointments.work_day', $request->contract_date);
        }
        $contracts = $contracts->get();



        return view('admin.contract', compact('contracts'));
    }


}
