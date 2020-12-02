<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class notifyController extends Controller
{
    //
    function deactive(Request $request){
        $noti_id = $request->input('id');
        // return $noti_id;
        $res = DB::table('Notifications')
        ->where('id', $noti_id)
        ->where('user_id','=',Auth::user()->id)
        ->update(['status' => 0]);
        $count = DB::table('Notifications')->where('status','=','1')->count();
        return $count;
        }

    function clearNotification(){
        $user_id = Auth::user()->id;
        // return $user_id;
        $res = DB::table('Notifications')
        ->where('user_id', $user_id)
        ->update(['status' => 0]);
        // ->delete();
        notify("تم تحديد الكل كمقروء","Toast","success");
        return back();
    }
}
