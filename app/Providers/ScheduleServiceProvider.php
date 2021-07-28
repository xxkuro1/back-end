<?php

namespace App\Providers;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
class ScheduleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Schedule $schedule)
    {
        //
        $schedule->call(function () {
            DB::table('posts')->delete();
        })->everyMinute();
    }
}
