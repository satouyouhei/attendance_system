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
        return view('index');
    }

    public function punch(Request $request){
        
        $now_date = Carbon::now()->format('Y-m-d');
        $now_time = Carbon::now()->format('H:i:s');
        $user_id = Auth::user()->id;
        $Timestamp = Timestamp::where('user_id',$user_id)->whereDate('date_work',$now_date)->latest()->first();

        if($request->has('punchIn')){
            $timestamp = new Timestamp();
            $timestamp -> date_work = $now_date;
            $timestamp -> punchIn = $now_time;
            $timestamp -> user_id = $user_id;
            $scene = 1;
        }

        if($request->has('breakIn')){
            $rest = new Rest();
            $rest -> rest_start = $now_time;
            $rest -> timestamp_id = $Timestamp->id;
            $scene = 2;
        };

        if($request->has('breakOut')){
            $rest = Rest::where('timestamp_id',$Timestamp->id)->whereNotNull('rest_start')->whereNull('rest_end')->first();
            $rest -> rest_end = $now_time;
            $scene = 1;
        }

        if($request->has('punchOut')){
            $timestamp = Timestamp::where('user_id',$user_id)->whereDate('date_work',$now_date)->latest()->first();
            $timestamp -> punchOut = $now_time;
            $scene = 0;
        }
        
        $user = User::find($user_id);
        $user->scene = $scene;
        $user->save();

        if(isset($timestamp)){
            $timestamp->save();
        }else{
            $rest->save();
        }

        return redirect('/');
    }
}