<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\models\Rest;
use App\models\Timestamp;
use App\models\User;
use Carbon\Carbon;


class TimestampJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    public function getUserId()
    {
        return $this->user->id;
    }

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->user = Auth::find($id)->first();
    }

    /**
     * Execute the job.
     *
     * @return void
     */

    public function __invoke()
    {
        $this->handle();
    }

    public function handle()
    {
        $this->doJob();
    }

    public function doJob()
    {
        $now_date = Carbon::now()->format('Y-m-d');
        $timestamp = Timestamp::where('user_id',$id)->whereDate('date_work',$now_date)->latest()->first();

        $old_date_time = new Carbon('11:59:59');
        $new_date_time = new Carbon('12:00:00');

        $timestamp -> punchOut = $old_date_time;

        $newTimestamp = new Timestamp();
        $newTimestamp -> user_id = $id ;
        $newTimestamp -> date_work = $now_date;
        $newTimestamp -> punchIn = $new_date_time;

        $timestamp->save();
        $newTimestamp->save();

        if(user->scene == 2){
            $rest = Rest::where('timestamp_id',$timestamp->id)->whereNotNull('rest_start')->whereNull('rest_end')->first();
            $rest -> rest_end = $old_date_time ;

            $newRest = new Rest();
            $newRest -> timestamp_id = $timestamp->id;
            $newRest -> rest_start = $new_date_time;

            $rest->save();
            $newRest->save();
        }


        Storage::append(user_access_log.txt, $this->user->all_date);
    }
    }
