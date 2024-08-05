<?php

namespace App\Console;

use Carbon\Carbon;
use App\Models\WorkOrder;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('stock:update')->daily();
        // $schedule->call(function () {
        //     $workOrders = WorkOrder::with('userWorkOrders')->where('selected_time', '!=', 'no')->get();
        //     foreach ($workOrders as $workOrder) {
        //         $givenDate = Carbon::parse($workOrder->created_at);
        //         $currentDate = Carbon::now();
        //         $daysDifference = $givenDate->diffInDays($currentDate);

        //         if ($workOrder->selected_time == 'daily' && $daysDifference > 0) {
        //             scheduleWorkOrder($workOrder, $daysDifference);
        //         } elseif ($workOrder->selected_time == 'weekly' && $daysDifference % 7 === 0 && $daysDifference / 7 >= 1) {
        //             scheduleWorkOrder($workOrder, $daysDifference);
        //         } elseif ($workOrder->selected_time == 'monthly' && $daysDifference % 30 === 0 && $daysDifference / 30 >= 1) {
        //             scheduleWorkOrder($workOrder, $daysDifference);
        //         } elseif ($workOrder->selected_time == 'yearly' && $daysDifference % 365 === 0 && $daysDifference / 365 >= 1) {
        //             scheduleWorkOrder($workOrder, $daysDifference);
        //         }
        //     }
        // })->daily();
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
