<?php
// use App\Alert\Notify;
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
 
use Illuminate\Http\Request;

class basketController extends Controller
{
    //

    function get_all_in_basket(){
        $current_user_id = Auth::user()->id;
        $user_ids = DB::table('basket')->where('buyer_id','=',$current_user_id)->pluck('seller_id');
        // dd($user_ids);
        //get just subscribet users
        // $date_now = '2020-11-27 10:04:36';
        $date_now = carbon::now()->toDateTimeString();
        $user_ids = DB::table('users')
        ->whereDate('subscription_in','<',$date_now)
        ->whereDate('subscription_out','>',$date_now)
        ->whereIn('id',$user_ids)
        ->pluck('id');
        // ->dump();
        // dd($user_ids);
        
        $items = DB::table('Items')
        ->join('basket', 'Items.id', '=', 'basket.item_id')
        ->whereIn('basket.seller_id',$user_ids)
        ->get();
        
        // $items = DB::table('basket')
        // ->join('Items', 'Items.id', '=', 'basket.item_id')
        // ->whereIn('Items.user_id',$items_id)
        // ->get();

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


    function alert($message,$user_id) {
        $result = DB::table('Notifications')->insert([
          'message' => $message,
          'user_id' => $user_id,
          'time' => carbon::now()->toDateTimeString(),
          'status' => 1,
          ]);
        return $result;
    }

    function addItemToBasket(Request $request){
        // $Noti = new Notify();
        $user_id = Auth::user()->id;
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
        // validate input
        if (!\is_numeric($item_id)) {
            return response()->json([
                'message' => 'الصنف غير صحيح',
                'status' => 'danger',
            ]);
        }
        // check if added any item to basket 
        $is_added = DB::table('basket')->where('item_id','=',$item_id)->count();
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
        
        DB::table('basket')->update([
            'quantity' => $quantity,
        ]);
        return response()->json([
            'message' => 'تم تحديث الكميه الى : '.$quantity,
            'status' => 'success',
        ]);
    }

    function buy_all(){

        $buyer_id = Auth::user()->id;
        $user_name = Auth::user()->name;
        $is_active = Auth::user()->account_active;
        // ceck if user account is active or not
        if (!$is_active) {
            notify('راسل الاداره لتنشيط حسابك',"Toast","danger");
            return redirect('/basket');
        }

        // get all items in basket
        $user_ids = DB::table('basket')
        ->where('buyer_id','=',$buyer_id)
        ->pluck('buyer_id');

        // check is any somthing in basket or not
        if (\sizeof($user_ids) < 1) {
            # code...
            notify("السله فارغه","Toast","danger");

            return back();
        }
        
        //get just subscribet users
        $date_now = carbon::now()->toDateTimeString();
        $user_ids = DB::table('users')
        ->whereDate('subscription_in','<',$date_now)
        ->whereDate('subscription_out','>',$date_now)
        ->whereIn('id',$user_ids)
        ->pluck('id');
        // get items and join with seller and buyer info
        $items = DB::table('Items')
        ->join('basket', 'Items.id', '=', 'basket.item_id')
        ->whereIn('basket.buyer_id',$user_ids)
        ->get();
        
        // insert order and get id
        $order_id = DB::table('orders')->insertGetId(
            ['name' => $user_name,
            'buyer_id' => $buyer_id,
            'status' => 'تجهيز',
            ]
        );
        // dd($items[0]->price);
        // $data = false;
        // insert all items with order id
        foreach ($items as $item) {
            # code...
            DB::table('ordered_items')->insert([
            'item_id' => $item->item_id,
            'order_id' => $order_id,
            'price' => $item->price,
            'color' => $item->color,
            'description' => $item->description,
            'image1' => $item->image1,
            'image2' => $item->image2,
            'image3' => $item->image3,
            'X' => $item->X,
            'L' => $item->L,
            'XL' => $item->XL,
            'type' => $item->type,
            'seller_id' => $item->seller_id,
            'buyer_id' => $buyer_id,
            'quantity' => $item->quantity,
            'status' => 'التجهيز',
            // 'notify' => true,
            ]);

            
        // tracking the most items buyed by table most_buy
        $is_exists = DB::table('most_buy')->where('item_id','=',$item->item_id)->count();
        if ($is_exists == 1) {
            // if item exists increse number of buying
            $up = DB::table('most_buy')
            ->where('item_id', $item->item_id)
            ->increment('buy_count', 1);

        }else {
            // insert the item if not eexists
            DB::table('most_buy')->insert(
                [
                'item_id'=>$item->item_id,
                'buy_count' => 1,
                ]
            );
        }
        }
        // dd($order_id);
        # clear basket from items
        // DB::delete('delete basket where buyer_id = ?;', [$buyer_id]);
        DB::table('basket')->where('buyer_id','=',$buyer_id)->delete();
        // dd($data);
        $this->alert('يتم الان تجهيز طلبك تحت الرقم : '.$order_id,$buyer_id);

        notify("تمت عمليه الشراء بنجاح","Toast","success");
        return redirect('/basket');
        // if ($data == true) {
        // }
        
        notify("لم يتم ارسال الطلب الرجاء مراسله الاداره","Toast","danger");
        return redirect('/basket');
        

        // remove all basket items from Basket

        // return back with success message
    }


    function clearBasket(){
        $buyer_id = Auth::user()->id;
        $is_active = Auth::user()->account_active;
        // ceck if user account is active or not
        if (!$is_active) {
            notify('راسل الاداره لتنشيط حسابك',"Toast","danger");
            return redirect('/basket');
        }
        DB::table('basket')->where('buyer_id','=',$buyer_id)->delete();
        notify("تم تفريغ السله","Toast","success");
        return redirect('/basket');

    }





}
