<?php

namespace App\Http\Controllers\Relations;

use App\Http\Controllers\Controller;
use App\Models\Phone;
use App\Models\User;
use Illuminate\Http\Request;

class HasOneController extends Controller
{
    public function hasOne()
    {
        $user = User::with(['phone' => function ($q) {
            $q->select('code', 'phone', 'user_id');
        }])->find(1);
        //return $user -> name;
        //return $user -> phone -> code;
        //return $user->phone;

        return response()->json($user);
    }
    public function hasOneReverse(){
        $phone = Phone::with(['user'=>function($q){
            $q->select('name','email','id');
        }])->find(1);
        // make any hidden attribute to be visible
        $phone->makeVisible(['user_id']);

        return $phone;
    }

    public function getUserHasPhone(){
        //return User::whereHas('phone')->get();

        return User::whereHas('phone',function ($q){
            $q->where('code','056');
        })->get();

    }
    public function getUserNotHasPhone(){
        $user = User::whereDoesntHave('phone')->get();
        return $user;
    }
}
