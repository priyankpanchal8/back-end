<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserConnection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index($userID)
    {
        // $connections = UserConnection::where('user1', '=', $email)
        $conn=new UserConnection();
        $connections = $conn->Connections($userID);
        // $con1 = UserConnection::where('User1', $userID)->pluck('User2');
        // $con2 = UserConnection::where('User2', $userID)->pluck('User1');

        // $connections = $con1->merge($con2);

        // error_log($userID);
        $all = User::all();
        return response()->json(['connections' => $connections, 'allUsers' => $all]) ;
    }

    public function userDetails($userID)
    {
        return User::where('id', '=', $userID)->first();
    }

    public function editUser($userID, Request $request)
    {
        $user = User::where('id', '=', $userID)->first();
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;

        if($user->save()){
            return response()->json(['status'=>'success', 'message'=>'User details are updated.']);
        }
        else{
            return response()->json(['status'=>'success', 'message'=>'Something is wrong']);
        }
    }
}
