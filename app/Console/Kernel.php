<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        //cài đặt command chạy theo ngày vào 00h
        $schedule->command('app:salaries')->daily(); 
        //yearly: 1 năm chạy 1 lần, hourly, monthly
        //nếu muốn cài đặt để chạy vào 1  thời điểm cụ thể thì thay bằng dấu * và số
      //  $schedule->command('app:salaries')->cron('0 0 * * *'); 
        //phút giờ ngày tháng tuần
        // cron chay moi thang 0h
        $schedule->command('app:concept-category')->monthlyOn(1, '0:00'); // Chạy vào ngày 1 hàng tháng lúc 00:00
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
