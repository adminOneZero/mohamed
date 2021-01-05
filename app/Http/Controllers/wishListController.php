<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class wishListController extends Controller
{
    //
    function addItemToWishList(Request $request){
        $item_id = $request->input('id');
        $user_id = Auth::user()->id;
        $is_active = Auth::user()->account_active;
        // ceck if user account is active or not
        if (!$is_active) {
            return response()->json([
                'message' => 'راسل الاداره لتنشيط حسابك',
                'status' => 'danger',
            ]);
        }

        if (!\is_numeric($item_id)) {
            return response()->json([
                'message' => 'الصنف غير صحيح',
                'status' => 'danger',
            ]);
        }
        $is_added = DB::table('wishList')->where('item_id','=',$item_id)->count();
        if ($is_added >= 1) {
            # code...
            return response()->json([
                'message' => 'تمت الاضافه مسبقا الى قائمه الامنيات',
                'status' => 'warning',
            ]);
        }

        $result = DB::table('wishList')->where('item_id','!=',$item_id)->insert(
            [
                'item_id' => $item_id,
                'buyer_id' => $user_id,
            ]
        );

        return response()->json([
            'message' => 'تمت الاضافه الى قائمه الامنيات',
            'status' => 'success',
        ]);
    }


    function get_all_in_wishlist(){
        $current_user_id = Auth::user()->id;
        $user_ids = DB::table('wishList')->where('buyer_id','=',$current_user_id)->pluck('buyer_id');
        //get just subscribet users
        $date_now = carbon::now()->toDateTimeString();
        $user_ids = DB::table('users')
        ->whereDate('subscription_in','<',$date_now)
        ->whereDate('subscription_out','>',$date_now)
        ->whereIn('id',$user_ids)
        ->pluck('id');
        // dd('yes');

        $items = DB::table('Items')
        ->join('wishList', 'Items.id', '=', 'wishList.item_id')
        ->whereIn('wishList.buyer_id',$user_ids)
        ->paginate(config('conf.page_items_limit'));
        
        // $items = DB::table('basket')
        // ->join('Items', 'Items.id', '=', 'basket.item_id')
        // ->whereIn('Items.user_id',$items_id)
        // ->get();

        // dd($items);
        return view('basket.wishlist', ['items' => $items]);

    }


    function clearWishlist(){
        $buyer_id = Auth::user()->id;
        DB::table('wishList')->where('buyer_id','=',$buyer_id)->delete();
        notify("تم تفريغ قائمه الامنيات","Toast","success");
        return redirect('/wishlist');

    }

}
