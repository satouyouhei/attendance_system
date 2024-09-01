<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Timestamp;
use App\Models\Rest;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Carbon;


class TimestampsController extends Controller
{
    public function index()
    {
        $now_date = Carbon::now();
        $user_id = Auth::user()->id;
        $confirm_date = Timestamp::where('user_id', $user_id)
            ->whereDate('date_work', $now_date)
            ->first();

        if (!$confirm_date) {
            $scene = 0;
        } else {
            $scene = Auth::user()->scene;
        }
        return view('index', compact('scene'));
    }

    public function punch(Request $request){
        
        $now = new Carbon();
        $now_date = Carbon::now();
        $now_time = Carbon::now()->format('H:i:s');
        $user = Auth::user();
        $timestamp = Timestamp::where('user_id',$user->id)->whereDate('date_work',$now_date)->latest()->first();

        if($request->has('punchIn')){

            $timestamp = Timestamp::create([
                'user_id' => $user->id,
                'date_work' => $now_date,
                'punchIn' => $now_time,
            ]);

            $user->update([
                'scene' => 1,
            ]);

        }

        if($request->has('breakIn')){

            Rest::create([
                'timestamp_id' => $timestamp->id,
                'rest_start' => $now_time,
            ]);

            $user->update([
                'scene' => 2,
            ]);

        };

        if($request->has('breakOut')){
            
            $rest = Rest::where('timestamp_id',$timestamp->id)->whereDate('created_at', $now_date)->latest()->first();
            $rest_start = new Carbon($rest->rest_start);
            $restTime = $rest_start->diffInSeconds($now);

            $rest->update([
                'rest_end' => $now_date,
                'restTime' => $restTime,
            ]);

            $user->update([
                'scene' => 1,
            ]);

        }

        if($request->has('punchOut')){

            $punchIn = new Carbon($timestamp->punchIn);
            $rests = Rest::where('timestamp_id',$timestamp->id)->whereDate('created_at', $now_date)->get();
            $restTotalTime = 0;
            foreach($rests as $rest){
                $restTotalTime += $rest->restTime;
            };
            $stayTime = $punchIn->diffInSeconds($now);
            $workingTime = $stayTime - $restTotalTime;

            $rest_total_sec = $restTotalTime%60;
            $rest_total_min = ($restTotalTime - $rest_total_sec)/60%60;
            $rest_total_hour = ($restTotalTime - $rest_total_sec - $rest_total_min*60)/3600;
            $rest_total = $rest_total_hour . ':' . $rest_total_min . ':' . $rest_total_sec;

            $work_total_sec = $workingTime%60;
            $work_total_min = ($workingTime - $work_total_sec)/60%60;
            $work_total_hour = ($workingTime - $work_total_sec - $work_total_min*60)/3600;
            $work_total = $work_total_hour . ':' . $work_total_min . ':' . $work_total_sec;

            $timestamp->update([
                'punchOut' => $now,
                'work_total' => $work_total,
                'rest_total' => $rest_total,
            ]);

            $user->update([
                'scene' => 0,
            ]);

        }

        return redirect('/');
    }
}