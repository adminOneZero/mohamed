<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use Illuminate\Http\Request;

class ordersController extends Controller
{
    // alert for users
    function alert($message,$user_id) {
        $result = DB::table('Notifications')->insert([
          'message' => $message,
          'user_id' => $user_id,
          'time' => carbon::now()->toDateTimeString(),
          'status' => 1,
          ]);
        return $result;
    }
     //
     function get_orders(Request $request){
        $buyer_id = Auth::user()->id;
        // $items = DB::table('ordered_items')->where('status','!=','تم التسليم')->get();
        $buyers_ids = DB::table('orders')
        ->where('status','!=','تم التسليم')
        ->pluck('buyer_id');
        
        // dd($buyers_ids);
        $items = DB::table('orders')->whereIn('buyer_id',$buyers_ids)
        ->where('status','!=','تم التسليم')
        ->join('users', 'orders.buyer_id', '=', 'users.id')
        ->get();

        return view('orders.orders',['items' => $items]);

    }
    

    function getOrdersItems(Request $request){
        $buyer_id = Auth::user()->id;
        $order_id = $request->input('id');
        
        $items = DB::table('ordered_items')
        ->where('status','!=','تم التسليم')
        ->where('order_id','=',$order_id)
        ->get();
        
        return $items;

    }

    function update_status(Request $request){
        $buyer_id = Auth::user()->id;
        $order_id = $request->input('order_id');
        $new_status = $request->input('new_status');
        $buyer_id = $request->input('buyer_id');
        // dd($buyer_id);
        $all_status = ['التجهيز','الشحن','تم التسليم'];
        if(!\in_array($new_status,$all_status) AND !\is_numeric($id)){
            // dd('y');
            return back();
        }
        
        // update order status
        $r = DB::table('orders')
        ->where('order_id','=',$order_id)
        ->update(['status'=>$new_status]);

        // notification messages
        if ($new_status == 'تم التسليم') {
            notify("الطلبيه رقم $order_id تم تسليمها","Toast","success");
            $this->alert("الطلبيه رقم $order_id تم تسليمها",$buyer_id);
            return back();
        }

        if ($new_status == 'الشحن') {
            notify("الطلبيه رقم $order_id تم شحنها","Toast","success");
            $this->alert("الطلبيه رقم $order_id تم شحنها",$buyer_id);
            return back();
        }

        if ($new_status == 'التجهيز') {
            notify("الطلبه رقم $order_id يتم تجهيزها للشحن","Toast","success");
            $this->alert("الطلبه رقم $order_id يتم تجهيزها للشحن",$buyer_id);
            return back();
        }
        return back();

    }

    function delete_order(Request $request){
        $buyer_id = Auth::user()->id;
        $order_id = $request->input('id');
        $items = DB::table('orders')
        ->where('order_id','=',$order_id)
        ->delete();

        $items = DB::table('ordered_items')
        ->where('order_id','=',$order_id)
        ->delete();

        return response()->json([
            'message' => 'تم حذف الطلب',
            'status' => 'danger',
        ]);

    }

}
