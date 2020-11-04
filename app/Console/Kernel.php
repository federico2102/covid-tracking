<?php

namespace App\Console;

use App\Models\Contagio;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function (){
            $contagios = Contagio::all()->where('fecha_alta', '=', null)
                ->where('fecha', '<=', Carbon::now()->subDays(14))
            ->where('estado', '=', 'En riesgo');

            foreach ($contagios as $contagio){
               $user = User::find($contagio->user_id);
               $user->estado = 'No contagiado';
               $user->save();
               $contagio->fecha_alta = Carbon::now();
               $contagio->save();
            }

        })->daily();;
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
