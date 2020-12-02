<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class ordersController extends Controller
{
    //
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
        $all_status = ['التجهيز','الشحن','تم التسليم'];
        if(!\in_array($new_status,$all_status) AND !\is_numeric($id)){
            dd('y');
            return back();
        }

        DB::table('orders')->where('order_id','=',$order_id)->update(['status'=>$new_status]);
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
