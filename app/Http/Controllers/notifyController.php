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
        $user_id = Auth::user()->id;

        // validation

        // is admin
        if (Auth::user()->account_type == "admin") {
            // update user notify
            $res = DB::table('Notifications')
            ->where('id', $noti_id)
            ->where('group',"=","admin")
            ->update(['status' => 0]);
            
            $count = DB::table('Notifications')
            ->where('status','=','1')
            ->where('user_id', $user_id)
            ->count();
            return $count;
        } else {
            # code...
            // update user notify
            // dd(Auth::user()->id);
            // dd($noti_id);
            $res = DB::table('Notifications')
            ->where('id', $noti_id)
            ->where('user_id','=',Auth::user()->id)
            ->update(['status' => 0]);
            
            $count = DB::table('Notifications')
            ->where('status','=','1')
            ->where('group',"!=","admin")

            // ->where('user_id', $user_id)
            ->where('user_id','=',Auth::user()->id)
            ->count();
            // ->get();
            // dd($count);

            
            return $count;
        }
        
        }

    function clearNotification(){
        $user_id = Auth::user()->id;
        $res = DB::table('Notifications')
        ->where('user_id', $user_id)
        ->update(['status' => 0]);
        notify("تم تحديد الكل كمقروء","Toast","success");
        return back();
    }
}
