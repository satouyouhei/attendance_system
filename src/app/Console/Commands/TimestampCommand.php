<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Timestamp;
use App\Models\Rest;
use Illuminate\Support\Carbon;


class TimestampCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'TimestampUpdate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Timestamps update at24:00';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $new_date_work = Carbon::now()->format('Y-m-d');
        $oldTime = new Carbon('23:59:59');
        $newTime = new Carbon('00:00:00');
        $users = User::all();

        foreach($users as $user){

            $timestamp = Timestamp::where('user_id',$user->id)->whereNotNull('punchIn')->whereNull('punchOut')->latest()->first();

            if($timestamp){
                $timestamp->punchOut = $oldTime;

                $newTimestamp = new Timestamp();
                $newTimestamp->user_id = $user->id;
                $newTimestamp->date_work = $new_date_work;
                $newTimestamp->punchIn = $newTime;

                $timestamp->save();
                $newTimestamp->save();

                $rest = Rest::where('timestamp_id',$timestamp->id)->whereNotNull('rest_start')->whereNull('rest_end')->latest()->first();
                if($rest){
                    $rest->rest_end = $oldTime;

                    $newRest = new Rest();
                    $newRest->timestamp_id = $newTimestamp->id;
                    $newRest->rest_start = $newTime;

                    $rest->save();
                    $newRest->save();
                }
            }
        }
        return 0;
    }
}
