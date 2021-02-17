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
        $is_active = Auth::user()->email_verified_at;
     
        if (!Auth::user()->account_active) {
            return response()->json([
                'message' => 'الحساب غير نشط - تفقد الايميل او راسل الاداره',
                'status' => 'danger',
            ]);
        }

        if (!\is_numeric($item_id)) {
            return response()->json([
                'message' => 'الصنف غير صحيح',
                'status' => 'danger',
            ]);
        }
        $is_added = DB::table('wishList')
        ->where('item_id','=',$item_id)
        ->where('buyer_id','=',$user_id)
        ->count();
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
        $date_now = carbon::now()->toDateTimeString();

        // get all wishlist items
        $wish_items_id = DB::table('wishList')
        ->where('buyer_id','=',$current_user_id)
        ->pluck('item_id');

        // get all wishlist items sellers
        $seller_ids = DB::table('Items')
        ->whereIn('id',$wish_items_id)
        ->pluck('seller_id');
        
        //get just aishlist subscribet users
        $wishlist_subscribet_users = DB::table('users')
        ->whereDate('subscription_in','>',$date_now)
        ->whereDate('subscription_out','<',$date_now)
        ->orWhere('account_type','admin')
        ->whereIn('id',$seller_ids)
        ->pluck('id');

        // get all items info
        $wishlist_items = DB::table('Items')
        ->whereIn('seller_id',$wishlist_subscribet_users)
        ->whereIn('id',$wish_items_id)
        ->paginate(config('conf.page_items_limit'));

        return view('basket.wishlist', ['items' => $wishlist_items]);
    }


    function clearWishlist(){
        $buyer_id = Auth::user()->id;
        DB::table('wishList')->where('buyer_id','=',$buyer_id)->delete();
        notify("تم تفريغ قائمه الامنيات","Toast","success");
        return redirect('/wishlist');

    }

}
