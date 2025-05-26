<?php

namespace App\Console\Commands;

use App\Models\File;
use App\Models\Salary as SalaryModel; // ✅ Đổi alias cho model
use App\Models\User;
use App\Models\Work_Schedule;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Salary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:salaries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command tính lương, sẽ được server chạy định kì, vào 00h hằng ngày';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // $today = Carbon::today()->toDateString(); // tạm thay vì yesterday
        $today = "2025-06-01";
        // $today = Carbon::yesterday()->toDateString();
        $month = Carbon::parse($today)->format('Y-m');
        $shift_value = SalaryModel::SALARY_BY_SHIFT; // tiền cho mỗi ca
        $bonus_salary = SalaryModel::SALARY_ROSE; // tiền thưởng 5% từ giá concept
        $users = User::where('role', User::ROLE_STAFF)->get(); // chỉ lấy nhân viên

        foreach ($users as $user) {
            // // Đếm tổng số ca làm trong ngày hôm qua
            // $workedShifts = Work_Schedule::where('user_id', $user->id)
            //     ->whereDate('work_day', $today)
            //     ->count();

            // Nếu có ca làm
            // if ($workedShifts > 0) {
            //     // Đếm số ca hoàn thành (có contract role = 1)
            //     $finished_shift = DB::table('appointments')
            //         ->join('contracts', 'appointments.id', '=', 'contracts.appointment_id')
            //         ->where('appointments.staff_id', $user->id)
            //         ->where('contracts.role', 1)
            //         ->whereDate('appointments.work_day', $today)
            //         ->count();

            //     // Tính tiền thưởng 5% từ giá concept
            //     $bonus_value = DB::table('appointments')
            //         ->join('contracts', 'appointments.id', '=', 'contracts.appointment_id')
            //         ->join('concepts', 'concepts.id', '=', 'appointments.concept_id')
            //         ->where('appointments.staff_id', $user->id)
            //         ->where('contracts.role', 1)
            //         ->whereDate('appointments.work_day', $today)
            //         ->select(DB::raw('SUM(concepts.price * 0.05) as total_bonus'))
            //         ->value('total_bonus') ?? 0;


            //     // Tìm hoặc tạo mới bản ghi lương
            //     $salary = SalaryModel::firstOrNew([
            //         'user_id' => $user->id,
            //         'month' => $month,
            //     ]);

            //     // Cập nhật các thông tin lương
            //     $salary->total_shift += $workedShifts;
            //     $salary->finished_shift += $finished_shift;
            //     $salary->base_salary = $salary->total_shift * $shift_value;
            //     $salary->total_salary = $salary->base_salary + $bonus_value;

            //     $salary->save();
            // }
                //   // Tìm hoặc tạo mới bản ghi lương
                // $salary = SalaryModel::firstOrNew([
                //     'user_id' => $user->id,
                //     'month' => $month,
                // ]);





$lastMonth = Carbon::parse($today)->subMonth(); // Lấy ngày tháng của tháng trước
$monthh = $lastMonth->month;
$yearr = $lastMonth->year;



 $workedShifts = Work_Schedule::where('user_id', $user->id)
                ->whereMonth('work_day', $monthh)
                ->whereYear('work_day', $yearr)
                ->count();


if ($workedShifts > 0) {
    // Đếm số ca hoàn thành (có contract role = 1) trong tháng trước
    $finished_shift = DB::table('appointments')
        ->join('contracts', 'appointments.id', '=', 'contracts.appointment_id')
        ->where('appointments.staff_id', $user->id)
        ->where('contracts.role', 1)
        ->whereMonth('appointments.work_day', $monthh)
        ->whereYear('appointments.work_day', $yearr)
        ->count();

    // Tính tiền thưởng 5% từ giá concept trong tháng trước
    $bonus_value = DB::table('appointments')
        ->join('contracts', 'appointments.id', '=', 'contracts.appointment_id')
        ->join('concepts', 'concepts.id', '=', 'appointments.concept_id')
        ->where('appointments.staff_id', $user->id)
        ->where('contracts.role', 1)
        ->whereMonth('appointments.work_day', $monthh)
        ->whereYear('appointments.work_day', $yearr)
        ->select(DB::raw('SUM(concepts.price * 0.05) as total_bonus'))
        ->value('total_bonus') ?? 0;



                // Tìm hoặc tạo mới bản ghi lương
                $salary = SalaryModel::firstOrNew([
                    'user_id' => $user->id,
                    'month' => $yearr . '-' . str_pad($monthh, 2, '0', STR_PAD_LEFT),
                ]);

                // Cập nhật các thông tin lương
                $salary->total_shift += $workedShifts;
                $salary->finished_shift += $finished_shift;
                $salary->base_salary = $salary->total_shift * $shift_value;
                $salary->total_salary = $salary->base_salary + $bonus_value;

                $salary->save();
            }
        }

        $this->info('✅ Đã cập nhật lương theo ca và thưởng ca hoàn thành.');
    }
}
