<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\UserBinder;

class UserConnection extends Model
{
    // @var array
    protected $fillable = [
        'User1', 'User2'
    ];
    public function Connections(int $userID){
        $Connectionss = [];
        $con1 = UserConnection::where('User1', $userID)->pluck('User2');
        foreach ($con1 as $c) {
            $obj=new UserBinder();
            array_push($Connectionss, $obj->User($c));
            // $Connectionss.add($obj->User($c->user2));
        }
        $con2 = UserConnection::where('User2', $userID)->pluck('User1');
        foreach ($con2 as $c) {
            $obj=new UserBinder();
            array_push($Connectionss, $obj->User($c));
            // $Connectionss.add();
        }
        // $Connectionss = $con1->merge($con2);
        return $Connectionss;
    }
}