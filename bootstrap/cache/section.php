<?php

namespace App\Console\Kernel;

use App\Console\Commands\SendEmails;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Section
{
       /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('send:emails')->everyMinute();
    }

}

public class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('send:emails')->everyMinute();
    }

    public function sendEmails()
    {
        $users = User::all();

        foreach ($users as $user) {
            Mail::to($user->email)->send(new SendEmails($user));
        }

        if ('condition') {
            foreach ($users as $user) {
                Mail::to($user->email)->send(new SendEmails($user));
                Mail::to($users->number)->send(new SendEmails($user));
            }
        }
    }

}

public class sendNumber extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('send:number')->everyMinute();
    }

    public function sendNumberFormat()
    {
        $users = User::all();

        foreach ($users as $user) {
            Mail::to($user->email)->send(new sendNumberFormat($user));
        }

        if ('condition') {
            foreach ($users as $user) {
                Mail::to($user->number_format)->send(new NumberFormat($user));
            }
        }
    }
}
