<?php

namespace Database\Seeders;

use App\Models\Work_Schedule;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Work_Schedule_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // for($i = 11; $i < 40; $i++) {
        //     for ($hour = 8; $hour < 20; $hour += 2) {
        //         $start = Carbon::createFromTime($hour, 0);
        //         $end = Carbon::createFromTime($hour + 2, 0);
        //         $shiftLabel = rand(1, 6);

        //         // Sinh ngẫu nhiên ngày trong 7 ngày tới
        //         $randomDay = Carbon::now()->startOfDay()->addDays(rand(0, 6));

        //         DB::table('work_schedules')->insert([
        //             'user_id' => $i,
        //             'shift_id' => $shiftLabel,
        //             'work_day' => $randomDay->copy()->setTime($hour, 0),
        //             'created_at' => now(),
        //             'updated_at' => now(),
        //         ]);
        //     }
        // }




        // for ($i = 0; $i < 1000; $i++) {
        //     $user_id = rand(50, 100); // Giả sử user_id từ 50 đến 100
        //     $shift_id = rand(1, 3); // Giả sử có 3 ca làm việc (shift_id từ 1 đến 3)
        //     $work_day = Carbon::createFromFormat('Y-m-d', '2025-05-' . rand(1, 30)); // Ngày làm việc trong tháng 5

        //     Work_Schedule::create([
        //         'user_id' => $user_id,
        //         'shift_id' => $shift_id,
        //         'work_day' => $work_day->format('Y-m-d H:i:s'),
        //     ]);
        // }

        // Tạo lịch làm việc cho 12 nhân viên trong 30 ngày tới
        for ($i = 2; $i <= 13; $i++) { // 12 nhân viên
            for ($j = 0; $j < 30; $j++) { // 30 ngày
                $work_day = Carbon::now()->addDays($j)->startOfDay();

                // Lặp đến khi tìm được shift có ít hơn 3 người
                $attempt = 0;
                do {
                    $shift_id = rand(1, 6); // 6 ca làm việc
                    $count = DB::table('work_schedules')
                        ->whereDate('work_day', $work_day->format('Y-m-d'))
                        ->where('shift_id', $shift_id)
                        ->count();

                    $attempt++;
                } while ($count >= 3 && $attempt < 10); // Thử tối đa 10 lần

                // Nếu tìm được ca phù hợp
                if ($count < 3) {
                    Work_Schedule::create([
                        'user_id' => $i,
                        'shift_id' => $shift_id,
                        'work_day' => $work_day->format('Y-m-d H:i:s'),
                    ]);
                }
            }
        }
    }
}
