<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\user;
use App\hash;
use Spatie\ArrayToXml\ArrayToXml;
use Illuminate\Support\Facades\Storage;

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
        $schedule->call(function () {
            $users = User::all();
            foreach($users as $user)
            {
                $hashes = Hash::
                select('vocabulary.word', 'algorithms.name as algorithm', 'hashes.hash')->
                join('vocabulary', 'hashes.word_id', '=', 'vocabulary.id')->
                join('algorithms', 'hashes.algorithm_id', '=', 'algorithms.id')->
                where('hashes.user_id', $user->id)->
                get()->keyBy('word')->toArray();

                $result = [
                    'user' => $user->name,
                    'user_ip' => $user->ip,
                    'user_agent' => $user->user_agent,
                    'vocabulary' => $hashes
                ];

                $result = ArrayToXml::convert($result);
                Storage::disk('local')->put($user->name.'.xml', $result);
            }
        })->everyTenMinutes();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
