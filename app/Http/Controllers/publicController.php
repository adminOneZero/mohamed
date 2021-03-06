<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class publicController extends Controller
{
    //

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


    function home(){
        $mostBuyItems_ids = DB::table('most_buy')
        ->orderBy('buy_count','desc')
        ->limit(4)
        ->pluck('item_id');
        
        $mostBuyItems = DB::table('Items')
        ->join('most_buy', 'Items.id', '=', 'most_buy.item_id')
        ->whereIn('most_buy.item_id',$mostBuyItems_ids)
        ->orderBy('buy_count','desc')
        
        ->get();

        return view('home',compact('mostBuyItems',$mostBuyItems));
    }

    function affiliaterRegister(){
        return view('auth.affiliaterRegister');
    }



    function get_all_wedings(){
        
        $date_now = carbon::now()->toDateTimeString();
        
        $user_ids = DB::table('users')
        ->whereDate('subscription_in','<',$date_now)
        ->whereDate('subscription_out','>',$date_now)
        ->orWhere('account_type','admin')
        ->pluck('id');
        // dd($user_ids);

        $items = DB::table('Items')
            ->whereIn('seller_id',$user_ids)
            ->where('type','=','فساتين زفاف')
            ->paginate(config('conf.page_items_limit'));

        return view('show.wedding_dresses',compact('items',$items));
    }
    
    function view_item(Request $request,$item_id){


        $item = DB::table('Items')
        ->where('id','=',$item_id)
        ->get();
        
        if (\sizeof($item) > 0) {
            # code...
            $may_like = DB::table('Items')
            ->where('description','like','%'.$item[0]->description)
            ->where('colors','like','%'.$item[0]->colors)
            ->limit(4)
            ->get();
            
            // send data to view
            return view('show.view_item')
            ->with('item' , $item)
            ->with('may_like' , $may_like);

        }else {
            return back();
        }
    }


    function get_all_soaris(){
        
        $date_now = carbon::now()->toDateTimeString();
        $user_ids = DB::table('users')
        ->whereDate('subscription_in','<',$date_now)
        ->whereDate('subscription_out','>',$date_now)
        ->pluck('id');

        $items = DB::table('Items')->whereIn('seller_id',$user_ids)->where('type','=','فساتين سوارية')->paginate(15);

        return view('show.soaris',compact('items',$items));
    }


    function get_all_kids(){
        
        $date_now = carbon::now()->toDateTimeString();
        $user_ids = DB::table('users')
        ->whereDate('subscription_in','<',$date_now)
        ->whereDate('subscription_out','>',$date_now)
        ->pluck('id');

        $items = DB::table('Items')->whereIn('seller_id',$user_ids)->where('type','=','فساتين أطفال')->paginate(15);

        return view('show.kids',compact('items',$items));
    }

    function subsciptions(){ //page
        // get page of adding new items
        return view('subsciption.subsciptions');
    }


    function search(Request $request){
        $search_text = $request->input('search_text');
        $section = $request->input('section');
            // dd($search_text);
        if ($search_text == null) {
            # code...
            notify("اكتب الكلمه المفتاحيه للبحث","Toast","danger");
            return back();
        }
        // dd($section);
        if (\is_numeric($search_text)) {
            
            $items = DB::table('Items')
            ->where('price', '<=', $search_text)
            ->get();
            
            return view('search.search',['items' => $items]);
            
        }


        $section_list = [
            'all',
            'فساتين زفاف',
            'سوارية',
            'اطفال'
        ];

        if(!\in_array($section,$section_list)){
                # code...
                // dd($section);
                $items = DB::table('Items')
                ->where('description', 'like', '%'.$search_text.'%')
                ->where('type','=',$section)
                ->paginate(config('conf.page_items_limit'));
                
                return view('search.search',['items' => $items]);
            
        }

        
        return back();
        
    }


}
