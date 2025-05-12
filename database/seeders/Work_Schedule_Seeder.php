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
        for($i = 11; $i < 40; $i++) {
            for ($hour = 8; $hour < 20; $hour += 2) {
                $start = Carbon::createFromTime($hour, 0);
                $end = Carbon::createFromTime($hour + 2, 0);
                $shiftLabel = rand(1, 6);

                // Sinh ngẫu nhiên ngày trong 7 ngày tới
                $randomDay = Carbon::now()->startOfDay()->addDays(rand(0, 6));

                DB::table('work_schedules')->insert([
                    'user_id' => $i,
                    'shift_id' => $shiftLabel,
                    'work_day' => $randomDay->copy()->setTime($hour, 0),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        
for ($i = 0; $i < 1000; $i++) {
    $user_id = rand(50, 100); // Giả sử user_id từ 50 đến 100
    $shift_id = rand(1, 3); // Giả sử có 3 ca làm việc (shift_id từ 1 đến 3)
    $work_day = Carbon::createFromFormat('Y-m-d', '2025-05-' . rand(1, 30)); // Ngày làm việc trong tháng 5

    Work_Schedule::create([
        'user_id' => $user_id,
        'shift_id' => $shift_id,
        'work_day' => $work_day->format('Y-m-d H:i:s'),
    ]);
}
    }
}
