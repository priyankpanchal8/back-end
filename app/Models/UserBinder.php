<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserBinder
{
    var $userID;
    var $name;

    public function User($userID)
    {
        $user = User::where('id','=',$userID)->first();
        if($user != null){
            $this->userID=$userID;
            $this->name=$user->firstname.' '.$user->lastname;
            return $this;
        }
        return null;
    }
}