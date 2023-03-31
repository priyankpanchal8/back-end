<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\UserConnectionBinder;

class Schedule extends Model
{
    protected $fillable = [
        'user_connections_id', 'MeetingDate', 'MeetingTime'
    ];

    public function getSchedule($userID){
        $schedules = [];
        $meetings = app('db')->select("SELECT s.*, uc.User1, uc.User2  FROM schedules s join user_connections uc on uc.id=s.user_connections_id where uc.User1=".$userID." or uc.User2=".$userID);
        foreach ($meetings as $item) {
            $conBinder = new UserConnectionBinder();
            array_push($schedules, $conBinder->bindData($item, $userID));
        }
        return $schedules;
    }
}