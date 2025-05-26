<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    // Hiển thị danh sách khách hàng
    public function index()
    {
        $clients = DB::table('users')->where('role', User::ROLE_CLIENT)->get();
        return view('admin.client', compact('clients'));
    }

    // Tìm kiếm khách hàng
    public function search(Request $request)
    {
        $inf = $request->input('inf');

        if (empty($inf)) {
            $clients = DB::table('users')->where('role', User::ROLE_CLIENT)->get();
        } else {
            $query = User::where('name', 'like', "%$inf%")
            ->where('role', User::ROLE_CLIENT)
                ->orWhere('phone', "%$inf%")
                ->orWhere('email', 'like', "%$inf%")
                ->orWhere('address', 'like', "%$inf%");
            try {
                $date = Carbon::parse($inf);
                $query->orWhereDate('birth_date', $date->format('Y-m-d'));
            } catch (\Exception $e) {
            }
            $clients = $query->get();
        }
        return view('admin.client', compact('clients'));
    }


    // Hiển thị chi tiết khách hàng
    public function show($id, Request $request)
    {
        $params = $request->all();
        $client = User::findOrFail($id);
        $appointments = Appointment::with(['staff', 'concept', 'shift'])
            ->where('user_id', $id)
            ->orderByDesc('work_day');
        if (isset($params['search']) && !empty($params['search'])) {
            $appointments->where(function ($query) use ($params) {
                $query->whereHas('concept', function ($queryBuilder) use ($params) {
                    $queryBuilder->where('name', 'like', '%' . $params['search'] . '%');
                })->orWhereHas('staff', function ($queryBuilder) use ($params) {
                    $queryBuilder->where('name', 'like', '%' . $params['search'] . '%');
                });
            });
        }
        $appointments = $appointments->get();
        return view('admin.client-detail', compact('client', 'appointments'));
    }
}
