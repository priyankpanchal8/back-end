<?php

namespace App\Http\Controllers;

use App\Models\UserConnection;
use App\Models\UserBinder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Schedule;

class UserConnectionController extends Controller
{
    public function Connect(Request $request)
    {
        try{
            $con = new UserConnection();
            
            $con->User1=$request->user1;
            $con->User2=$request->user2;
            
            if($con->save()){
                return response()->json([
                    'status' => 'success',
                    'message' => 'Connected'
                ]);
            }
        } catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function disConnect(Request $request)
    {
        $userID = $request->user1;
        $userID2 = $request->user2;
        $conns = app('db')->select("SELECT * FROM user_connections uc where (User1 = ".$userID." and User2=".$userID2.") or (User1=".$userID2 . " and User2 = ".$userID.")");

        if($conns != null)
        {
            for($i = 0; $i < count($conns); $i++)
            {
                $id=$conns[$i]->id;
                $sch = app('db')->select("SELECT * FROM schedules where user_connections_id=".$id);
                for($j = 0; $j < count($sch); $j++){
                    // return response()->json([$sch[$j]]);
                    $o=Schedule::findOrFail($sch[$j]->id);
                    $o->delete();
                }
                $c=UserConnection::findOrFail($conns[$i]->id);
                $c->delete();
            }
        }
        return response()->json(['status'=>'success', 'message'=>'Connection removed']);
    }
}
