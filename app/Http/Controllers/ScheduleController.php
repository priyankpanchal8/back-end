<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\UserConnection;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    public function index($userID)
    {
        $model = new Schedule();
        $Schedule = $model->getSchedule($userID);// app('db')->select("SELECT * FROM schedules s join user_connections uc on uc.id=s.user_connections_id where uc.User1=".$userID." or uc.User2=".$userID);
        $obj = new UserConnection();
        $connections = $obj->Connections($userID);
        return response()->json(['Schedule' => $Schedule, 'Connections' => $connections]);
    }

    public function createSchedule(Request $request)
    {
        $userID = $request->userID;
        $userID2 = $request->userID2;
        $date = $request->date;
        $time = $request->time;

        if($userID2<0 or $date == null or $time == null){
            return response()->json(['status' => 'error', 'message'=>'Please enter all details']);
        }
        else {
            $conn = UserConnection::where('User1', '=', $userID)->where('User2', '=', $userID2)->first();
            if($conn == null)
            {
                $conn = UserConnection::where('User1', '=', $userID2)->where('User2', '=', $userID)->first();
            }
            
            if($conn == null){
                return response()->json([ 'status' => 'error', 'message' => 'No Connection' ]);
            }

            $obj = new Schedule();
            $obj->user_connections_id=$conn->id;
            $obj->MeetingDate = $date;
            $obj->MeetingTime = $time;

            $obj->save();
            return response()->json(['status' => 'success', 'message'=> 'Schedule has been created']);
        }
    }

    public function updateSchedule(Request $request, $id){
        $date = $request->date;
        $time = $request->time;

        $sc=Schedule::findOrFail($id);
        if($sc != null){
            $sc->MeetingDate=$date;
            $sc->MeetingTime=$time;
            $sc->save();
            return response()->json(['status'=>'success', 'message'=>'Schedule has been updated']);
        }
        return response()->json(['status'=>'error', 'message'=>'Schedule does not found.']);
    }

    public function removeSchedule($id){
        $sc=Schedule::findOrFail($id);
        if($sc != null){
            $sc->delete();
            return response()->json(['status'=>'success', 'message'=>'Schedule has been removed']);
        }
        return response()->json(['status'=>'error', 'message'=>'Schedule does not found.']);
    }
}
