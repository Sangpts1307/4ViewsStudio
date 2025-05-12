<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Concept;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{
    public function getStatistic(Request $request) 
    {
        $selectedMonth = $request->input('month', Carbon::now()->format('Y-m'));
        $selectedYear = $request->input('year', Carbon::now()->year);

        // Lấy số liệu tổng hợp
        $statistics = [
            'totalStaff' => User::where('role', User::ROLE_STAFF)->count(),
            'totalClient' => User::where('role', User::ROLE_CLIENT)->count(),
            'pendingAppointment' => Appointment::where('status', Appointment::STATUS_WAIT)->count(),
            'totalConcept' => Concept::count(),
        ];  

        $conceptUsageData = Appointment::where('status', Appointment::STATUS_DONE)
            ->whereMonth('work_day', Carbon::parse($selectedMonth)->month) // Chỉ lấy dữ liệu của tháng đã chọn
            ->join('concepts', 'appointments.concept_id', '=', 'concepts.id')
            ->groupBy('concepts.id', 'concepts.name')
            ->select(['concepts.name', DB::raw('COUNT(appointments.id) as usage_count')])
            ->get();

        $revenueData = Appointment::where('status', Appointment::STATUS_DONE)
            ->whereYear('work_day', $selectedYear)
            ->join('concepts', 'appointments.concept_id', '=', 'concepts.id')
            ->groupBy(DB::raw('MONTH(work_day)'))
            ->select([DB::raw('MONTH(work_day) as month'), DB::raw('SUM(concepts.price) as total_revenue')])
            ->get();

        return view('admin.statistic', compact('statistics', 'conceptUsageData', 'selectedMonth', 'revenueData', 'selectedYear'));
    }
}
