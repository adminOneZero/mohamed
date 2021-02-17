<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\User;


class ordersController extends Controller
{
    // alert for users
    function alert($message,$user_id,$for_admin = false) {
        $group = "user";
        if ($for_admin) {
            $group = "admin";

        }
        // dd($group);
        $result = DB::table('Notifications')->insert([
            'message' => $message,
            'user_id' => $user_id,
            'group' => $group,
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
        $items = DB::table('orders')
        ->whereIn('buyer_id',$buyers_ids)
        ->where('status','!=','تم التسليم')
        ->join('users', 'orders.buyer_id', '=', 'users.id')
        ->get();

        return view('orders.orders',['items' => $items]);

    }
    

    function getOrdersItems(Request $request){
        $buyer_id = Auth::user()->id;

        // limt id length
        if (Str::length($buyer_id) > 11) {
            return "";
        }
        $order_id = $request->input('id');
        $items = DB::table('ordered_items')

        ->where('order_id','=',$order_id)
        ->get();
        
        return $items;

    }

    function update_status(Request $request){
        $buyer_id = Auth::user()->id;
        $order_id = $request->input('order_id');
        $new_status = $request->input('new_status');
        $buyer_id = $request->input('buyer_id');

        $all_status = ['التجهيز','الشحن','تم التسليم'];
        if(!\in_array($new_status,$all_status) AND !\is_numeric($id)){
            // dd('y');
            return back();
        }
        
        // update order status
        $r = DB::table('orders')
        ->where('order_id','=',$order_id)
        ->update(['status'=>$new_status]);

        // update items order status
        $r = DB::table('ordered_items')
        ->where('order_id','=',$order_id)
        ->update(['status'=>$new_status]);

        // notification messages
        if ($new_status == 'تم التسليم') {
            notify("الطلبيه رقم $order_id تم تسليمها","Toast","success");
            $this->alert("الطلبيه رقم $order_id تم تسليمها",$buyer_id);
            // dd($buyer_id);
            // dd(User::find($buyer_id)->account_type);

            if (User::find($buyer_id)->account_type == 'marketer') {
                # code...

            $order_commissions = DB::table('marketers_commissions')
            ->where('order_id','=',$order_id)
            ->where('marketer_id','=',$buyer_id)
            ->pluck('commission');

            foreach ($order_commissions as $commission) {
                # code...
                // add commission to wallet
                $is_exists = DB::table('marketers_wallet')
                ->where('marketer_id','=',$buyer_id)
                ->count();
                
                if ($is_exists == 1) {

                    DB::table('marketers_wallet')
                    ->where('marketer_id', $buyer_id)
                    ->increment('wallet', ($commission));

                    
                    
                }else {
                    // insert user money into wallet if not exists
                    DB::table('marketers_wallet')
                    ->insert(
                        [
                            'marketer_id'=> $buyer_id,
                            'wallet' => ($commission),
                        ]
                    );
                }
            }
            }
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
        $order_id = $request->input('id');
        
        $buyer_id = $result = DB::table('orders')
        ->where('order_id','=',$order_id)
        ->pluck('buyer_id')
        ->first();
        
        // dd($buyer_id);
        // delete order
        $result = DB::table('orders')
        ->where('order_id','=',$order_id)
        ->delete();

        // delete orders
        $results = DB::table('ordered_items')
        ->where('order_id','=',$order_id)
        ->delete();
        if ($result ==1) {
            # code...
            $this->alert("ناسف الطلبيه رقم $order_id تم الغاءها",$buyer_id);
        }

        return response()->json([
            'message' => 'تم حذف الطلب',
            'status' => 'success',
        ]);

    }

}
