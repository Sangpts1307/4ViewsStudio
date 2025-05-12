<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($hour = 8; $hour < 20; $hour += 2) {
            $start = Carbon::createFromTime($hour, 0);
            $end = Carbon::createFromTime($hour + 2, 0);
            $start_time = $start->format('H:i');
            $end_time = $end->format('H:i');


            DB::table('shifts')->insert([
                'start_time' => $start_time,
                'end_time' => $end_time
            ]);
        }
    }
}
