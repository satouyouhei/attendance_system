<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Work;
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
}
