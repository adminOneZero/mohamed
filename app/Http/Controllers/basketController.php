<?php
// use App\Alert\Notify;
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
 
use Illuminate\Http\Request;

class basketController extends Controller
{
    //

    function get_all_in_basket(){
        $current_user_id = Auth::user()->id;
        $user_ids = DB::table('basket')
        ->where('buyer_id','=',$current_user_id)
        ->pluck('seller_id');

        $date_now = carbon::now()->toDateTimeString();
        $user_ids = DB::table('users')
        ->whereDate('subscription_in','<',$date_now)
        ->whereDate('subscription_out','>',$date_now)
        ->orWhere('account_type','=',"admin")
        ->whereIn('id',$user_ids)
        ->pluck('id');
        
        $items = DB::table('Items')
        ->join('basket', 'Items.id', '=', 'basket.item_id')
        ->whereIn('basket.seller_id',$user_ids)
        ->where('buyer_id','=',$current_user_id)

        ->get();
        // dd($items);
        
        return view('basket.basket', ['items' => $items]);
    }


    function show_to_prepare(){
        $user_id = Auth::user()->id;
        $user_ids = DB::table('basket')->where('user_id','=',$user_id)->pluck('user_id');
        
        //get just subscribet users
        $date_now = '2020-11-27 10:04:36';
        $date_now = carbon::now()->toDateTimeString();
        $user_ids = DB::table('users')
        ->whereDate('subscription_in','<',$date_now)
        ->whereDate('subscription_out','>',$date_now)
        ->whereIn('id',$user_ids)
        ->pluck('id');

        $items = DB::table('Items')->whereIn('user_id',$user_ids)->get();

        return view('basket.prepare_basket', ['items' => $items]);

        
    }


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

    function addItemToBasket(Request $request){
        $user_id = Auth::user()->id;
        $item_id = $request->input('id');
        $user_id = Auth::user()->id;
        $is_active = Auth::user()->account_active;

        // ceck if user account is active or not
        if (!$is_active) {
            return response()->json([
                'message' => 'الحساب غير نشط - تفقد الايميل او راسل الاداره',
                'status' => 'danger',
            ]);
        }

        // validate input
        if (!\is_numeric($item_id)) {
            return response()->json([
                'message' => 'الصنف غير صحيح',
                'status' => 'danger',
            ]);
        }

        // check if added any item to basket 
        $is_added = DB::table('basket')
        ->where('item_id','=',$item_id)
        ->where('buyer_id','=',Auth::user()->id)
        ->count();
        if ($is_added >= 1) {
            # code...
            return response()->json([
                'message' => 'تمت الاضافه مسبقا',
                'status' => 'warning',
                ]);
            }

            // if not added before insert new
            $seller_id = DB::table('Items')->where('id','=',$item_id)->pluck('seller_id');
            // return ($seller_id);
            // dd($seller_id);
            $result = DB::table('basket')->where('item_id','!=',$item_id)->insert(
            [
                'item_id' => $item_id,
                'buyer_id' => $user_id,
                'seller_id' => $seller_id[0],
                'quantity' => 1,
            ]
        );

        return response()->json([
            'message' => 'تمت الاضافه الى السله',
            'status' => 'success',
        ]);
    }


    function update(Request $request){

        $id = $request->input('id');
        $quantity = $request->input('quantity');
        $color = $request->input('color');
        $size = $request->input('size');
        // dd($color);
        
        DB::table('basket')
        ->where('id','=',$id)        
        ->update([
            'quantity' => $quantity,
            'selectedColor' => $color,
            'selectedSize' => $size,
        ]);

        return response()->json([
            'message' => 'تم تحديث الكميه الى : '.$quantity,
            'status' => 'success',
        ]);
    }


    function buy_all(){
        // basic info
        $buyer_id = Auth::user()->id;
        $user_name = Auth::user()->name;
        $is_active = Auth::user()->account_active;

        // ceck if user account is active or not
        if (!$is_active) {
            notify('الحساب غير نشط - تفقد الايميل او راسل الاداره',"Toast","danger");
            return redirect('/basket');
        }

        // get all buyers in basket
        $sellers_ids = DB::table('basket')
        ->where('buyer_id','=',$buyer_id)
        ->pluck('seller_id');

        // check is any somthing in basket or not
        if (\sizeof($sellers_ids) < 1) {
            # code...
            notify("السله فارغه","Toast","danger");

            return back();
        }
        
        //get just subscribet sellers
        $date_now = carbon::now()->toDateTimeString();
        $sub_sellers = DB::table('users')
        ->whereDate('subscription_in','<',$date_now)
        ->whereDate('subscription_out','>',$date_now)
        ->orWhere('account_type','=',"admin")
        ->whereIn('id',$sellers_ids)
        ->pluck('id');
        
        // get items of subscribet sellers //and join with seller and buyer info
        $items = DB::table('Items')
        ->whereIn('basket.seller_id',$sub_sellers)
        ->where('basket.buyer_id',$buyer_id)
        ->join('basket', 'Items.id', '=', 'basket.item_id')
        ->get();
        // dd($items);
        
        // insert order and get id
        $order_id = DB::table('orders')->insertGetId(
            ['name' => $user_name,
            'buyer_id' => $buyer_id,
            'status' => 'تجهيز',
            ]
        );

        // check all items if avalable in store
        foreach ($items as $item) {
            # code...
            // dd($item->storeQuantity > $item->quantity);
            if ($item->storeQuantity >= $item->quantity) {
                # code...
                continue;       
            }else{
            dd($item->storeQuantity > $item->quantity);

                notify("احد االمنتجات قد انتهى مخزونه في المتجر","Toast","danger");
                return back();
            }
        }

        // insert all items with order id
        foreach ($items as $item) {
            # code...
            // dd($item->storeQuantity > $item->quantity);
            // if ($item->storeQuantity > $item->quantity) {
            //     # code...
                
            // }else{
            // dd($item->storeQuantity > $item->quantity);

            //     notify("احد االمنتجات قد انتهى مخزونه في المتجر","Toast","danger");
            //     return back();
            // }

            DB::table('ordered_items')->insert([
                'item_id' => $item->item_id,
                'order_id' => $order_id,
                'price' => $item->price,
                'colors' => $item->colors,
                'selectedColor' => $item->selectedColor,
                'selectedSize' => $item->selectedSize,
                'description' => $item->description,
                'image1' => $item->image1,
                'image2' => $item->image2,
                'image3' => $item->image3,
                'X' => $item->X,
                'L' => $item->L,
                'XL' => $item->XL,
                'M' => $item->M,
                'type' => $item->type,
                'seller_id' => $item->seller_id,
                'buyer_id' => $buyer_id,
                'quantity' => $item->quantity,
                'status' => 'التجهيز',
                // 'notify' => true,
                ]);
            
            // if marketer give hem the item commission
            if (Auth::user()->account_type == 'marketer') {
                # code...
                // made commission history
                DB::table('marketers_commissions')
                ->insert([
                    'marketer_id' => Auth::user()->id,
                    'order_id' => $order_id,
                    'commission' => ($item->quantity * $item->commission) ,
                    'date' =>  carbon::now()->toDateTimeString(),
                ]);
                    
                
            }
            
            // tracking the most items buyed by table most_buy
            $is_exists = DB::table('most_buy')->where('item_id','=',$item->item_id)->count();
            if ($is_exists == 1) {
                // if item exists increse number of buying
                DB::table('most_buy')
                ->where('item_id', $item->item_id)
                ->increment('buy_count', 1 * $item->quantity);

            }else {
                // insert the item if not eexists
                DB::table('most_buy')->insert(
                    [
                    'item_id'=>$item->item_id,
                    'buy_count' => 1 * $item->quantity,
                    ]
                );
            }
        }

        # clear basket from items
        DB::table('basket')->where('buyer_id','=',$buyer_id)->delete();
        $this->alert('يتم الان تجهيز طلبك تحت الرقم : '.$order_id,$buyer_id);
        $this->alert('هنالك طلبيه جديده رقمها : '.$order_id,$buyer_id,true);

        notify("تمت عمليه الشراء بنجاح","Toast","success");
        return redirect('/basket');
        
        // notify("لم يتم ارسال الطلب الرجاء مراسله الاداره","Toast","danger");
        // return redirect('/basket');

    }

    function clearBasket(){
        $buyer_id = Auth::user()->id;
        $is_active = Auth::user()->account_active;

        // ceck if user account is active or not
        if (!$is_active) {
            notify('الحساب غير نشط - تفقد الايميل او راسل الاداره',"Toast","danger");
            return redirect('/basket');
        }

        DB::table('basket')->where('buyer_id','=',$buyer_id)->delete();
        notify("تم تفريغ السله","Toast","success");
        return redirect('/basket');

    }

    function deleteBasketItem(Request $request,$item_id){
        $buyer_id = Auth::user()->id;
        // $is_active = Auth::user()->account_active;

        $is_item = DB::table('basket')
        ->where('item_id','=',$item_id)
        ->where('buyer_id','=',$buyer_id)
        ->count();
        // return $is_item;
        // validate and check basket item
        if (Str::length($item_id) > 11 || !\is_numeric($item_id) || $is_item != 1) {
            notify('هذا المنتج غير موجود',"Toast","danger");
            return back();
        }

        DB::table('basket')
        ->where('item_id','=',$item_id)
        ->where('buyer_id','=',$buyer_id)
        ->delete();
        notify("تم حذف الفستان","Toast","success");
        return back();

    }

    function itemInfo(Request $request){
        $item_id = $request->input('item_id');
        // $item_id = "111111111111";
        // validation
        if (Str::length($item_id) > 11) {
            # code...
            return response()->json([
                'message' => 'فشل',
                'status' => 'danger',
            ]);
        }

        
        $basketItem = DB::table('basket')
        ->where('id',$item_id)
        // ->where('buyer_id',Auth::user()->id)
        ->first();
        
        $item = DB::table('Items')
        ->where('id',$basketItem->item_id)
        ->first();

        // dd($basketItem->item_id);
        $colorInBasket = $basketItem->selectedColor != null ? $basketItem->selectedColor : null;
        $sizeInBasket = $basketItem->selectedSize != null ? $basketItem->selectedSize : null;
        $quantityInBasket = $basketItem->quantity != null ? $basketItem->quantity : null;
        if ($item != null) {
            # code...
            return response()->json([
                'message' => 'تم',
                'status' => 'success',
                'content' => $item ,
                'colorInBasket' => $colorInBasket,
                'sizeInBasket' => $sizeInBasket,
                'quantityInBasket' => $quantityInBasket,
            ]);    
        }
        return response()->json([
            'message' => 'فشل',
            'status' => 'danger',
        ]);
    }

}
