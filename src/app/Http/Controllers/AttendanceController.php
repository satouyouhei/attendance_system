<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Timestamp;
use App\Models\Rest;
use Illuminate\Pagination\paginator;
use Illuminate\Support\Carbon;

class AttendanceController extends Controller
{
    public function indexDate(Request $request)
    {   
        $displayDate = Carbon::now();
        $timestamps = Timestamp::whereDate('date_work', $displayDate)->paginate(5);

        return view('attendance_date', compact('timestamps', 'displayDate'));
    }

    public function perDate(Request $request)
    {   
        $date = $request->input('displayDate');
        $date_work = Carbon::parse($date);

        if ($request->has('prevDate')) {
           $date_work = $date_work->subDay();
        }

        if ($request->has('nextDate')) {
            $date_work = $date_work->addDay();
        }
        $displayDate = $date_work;
        $timestamps = Timestamp::whereDate('date_work', $displayDate)->paginate(5);
        return view('attendance_date', compact('timestamps','displayDate'));
    }

    public function indexUser()
    {
        $displayUser = Auth::user()->name;
        $user_id = Auth::user()->id;
        $timestamps = Timestamp::where('user_id', $user_id)->paginate(5);
        $userList = User::all();

        $data['params'] = array(
            'userList' => $userList,
            'displayUser' => $displayUser,
        );

        $timestamps ->appends($data);

        return view('attendance_user', compact('timestamps', 'data' ));
    }

    public function perUser(Request $request)
    {
        $searchName = $request->input('search_name');
        $user = User::where('name', $searchName)->first();
        $displayUser = $user->name;
        $user_id = $user->id;

        $timestamps = Timestamp::where('user_id', $user_id)->paginate(5);

        $userList = User::all();

        $data['params'] = array(
            'userList' => $userList,
            'displayUser' => $displayUser,
        );

        $timestamps ->appends($params);

        return view('attendance_user', compact('timestamps','data'));
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
