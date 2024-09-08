<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Timestamp;
use App\Models\Rest;
use Illuminate\Pagination\paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;

class AttendanceController extends Controller
{

    public function searchDate(Request $request){

        $date=$request->input('displayDate');
        $conditions = [];
        if($date){
            $date= Carbon::parse($date);

            if ($request->has('prevDate')) {
               $date= $date->subDay();
            }
            if ($request->has('nextDate')) {
                $date = $date->addDay();
            }

        }else{
            $date = Carbon::now();
        }
        $displayDate=$date;
        $conditions[]=['date_work',$date->format('Y-m-d')];
        $append_param['displayDate']= $displayDate->format('Y-m-d');
        $timestamps = DB::table('timestamps_view_table')->where($conditions);
        $timestamps_list= $timestamps->paginate(5);
        $timestamps_list->appends($append_param);

        return view('attendance_date' ,compact('timestamps_list','append_param'));
    }

    public function searchUser(Request $request)
    {
        $displayUser = "";
        $searchName = $request->input('search_name');
        $displayUser = $request->displayUser;
        if($searchName){

        $user = User::where('name',$searchName)->first();
        $displayUser = $user ? $user->name : null;

        $timestamps = DB::table('timestamps_view_table')
            ->where('name', $displayUser)
            ->paginate(5);
        $timestamps->appends(['displayUser'=>$displayUser]);

        }elseif($displayUser){

            $timestamps = DB::table('timestamps_view_table')
            ->where('name', $displayUser)
            ->paginate(5);
        $timestamps->appends(['displayUser'=>$displayUser]);

        }else{

        $displayUser = Auth::user()->name;
        $timestamps = DB::table('timestamps_view_table')
            ->where('name', $displayUser)
            ->paginate(5);
        }

        $userList = User::all();
        return view('attendance_user', compact('timestamps', 'displayUser', 'userList'));
    }

    public function user()
    {
        $users = User::paginate(5);
        $displayDate = Carbon::now();
        $searchScene = 0;
        return view('user', compact('users', 'displayDate','searchScene'));
    }

    public function perScene(Request $request)
    {
        $displayDate = Carbon::now();
        $searchScene = $request->input('scene');
        if($searchScene == 3 || !isset($searchScene)){
            $users = User::paginate(5);
        }else{
            $users = User::where('scene', $searchScene)->paginate(5);
        }
        return view('user', compact('users','displayDate'));
    }

}
