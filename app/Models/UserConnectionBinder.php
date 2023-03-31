<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\UserBinder;

class UserConnectionBinder
{
    var $id;
    var $user_connections_id;
    var $userID;
    var $name;
    var $MeetingDate;
    var $MeetingTime;
    
    public function bindData($item, $userID){
        $this->id=$item->id;
        $this->user_connections_id=$item->user_connections_id;
        $this->MeetingDate=$item->MeetingDate;
        $this->MeetingTime=$item->MeetingTime;

        $user = null;
        if($item->User1 == $userID){
            $user = User::where('id','=',$item->User2)->first();
        } else {
            $user = User::where('id','=',$item->User1)->first();
        }
        if($user != null){
            $this->name = $user->firstname." ".$user->lastname;
            $this->userID = $user->id;
        }

        return $this;
    }
}