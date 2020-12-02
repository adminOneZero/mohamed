<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class buyerController extends Controller
{
    //
    function requestedItems(){
        $buyer_id = Auth::user()->id;
        // dd($buyer_id);
        // $items = DB::table('orders')->where('buyer_id','=',$buyer_id)->where('status','!=','تم التسليم')->get();
        // dd($items);
        $buyers_ids = DB::table('orders')
        ->where('status','!=','تم التسليم')
        ->where('buyer_id','=',$buyer_id)
        ->pluck('buyer_id');
        
        // dd($buyers_ids);
        $items = DB::table('orders')->whereIn('buyer_id',$buyers_ids)
        ->where('status','!=','تم التسليم')
        ->join('users', 'orders.buyer_id', '=', 'users.id')
        ->get();
        return view('dashboard_pages.buyers.myorders',['items' => $items]);

    }

    function receiviededOders(){
        $buyer_id = Auth::user()->id;
        $items = DB::table('ordered_items')->where('buyer_id','=',$buyer_id)->where('status','=','تم التسليم')->get();
        return view('dashboard_pages.buyers.received_orders',['items' => $items]);

    }
}
