<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\TimestampJob;
use Illuminate\Support\Facades\Auth;
use App\models\User;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $count = Auth::all()->count();
        $id = rand( 0, $count ) + 1;
        $schedule->call(function() use ($id)
        {
            $user = Auth::find($id);
            TimestampJob::dispatch($user)->delay(now()->addMinutes(5));
        });

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

}
