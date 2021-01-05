<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;
// use Carbon\Carbon;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
// use Illuminate\Http\UploadedFile;
class dashboardSeller extends Controller
{
    //
    function get_dresses(){
        // if user not subscrive dactive all items auto
        if (Auth::user()->subscription_in != null) {
            Auth::user()->dactiveItemsIfNotSubscribe();
        }

        // get all user dresses items
        $user_id = Auth::user()->id; // get id to get his items
        $items = $users = DB::table('Items')->where('seller_id','=',$user_id)
        ->paginate(config('conf.page_items_limit'));
        return view('dashboard_pages.sellers.dresses',['items' => $items]);
    }


    function view_item(Request $request,$item_id){

        // get all user dresses items
        $user_id = Auth::user()->id; // get id to get his items
        $item = $users = DB::table('Items')
        ->where('id','=',$item_id)
        ->where('seller_id','=',$user_id)
        ->get();
        // dd($item[0]);
        return view('dashboard_pages.sellers.view_item',['item' => $item[0]]);
    }


    function add_dresses(){ //page
        // get page of adding new items
        return view('dashboard_pages.sellers.new_dresses');
    }

    function save_dresses(Request $request){
        
        $messsages = array(
            'image1.max'=>'اسم الصوره طويل جدا',
            'image1.min'=>'اسم الصوره صغير للغايه',
            'image1.mimes'=>'هذا الملف غير مسموح به كصوره',
            'image1.required'=>'ارفع 3 صور مطلوب',

            'image2.max'=>'اسم الصوره طويل جدا',
            'image2.min'=>'اسم الصوره صغير للغايه',
            'image2.mimes'=>'هذا الملف غير مسموح به كصوره',
            'image2.required'=>'ارفع 3 صور مطلوب',

            'image3.max'=>'اسم الصوره طويل جدا',
            'image3.min'=>'اسم الصوره صغير للغايه',
            'image3.mimes'=>'هذا الملف غير مسموح به كصوره',
            'image3.required'=>'ارفع 3 صور مطلوب',
            
            'price.required'=>'تمن الفستان مطلوب',
            'price.min'=>'ثمن الفستان قليل للغايه',
            'price.max'=>'ثمن الفستان مرتفع للغايه',
            'price.numeric'=>'اعد كتابه الثمن',

            'color.required'=>'لون الفستان مطلوب',
            'color.min'=>'احرف لون الفستان قليل للغايه',
            'color.max'=>'احرف لون الفستان الفستان كثيره للغايه',
            'color.alpha'=>'اعد كتابه اللون بشكل صحيح',

            'description.required'=>'وصف الفستان مطلوب',
            'description.min'=>'احرف وصف الفستان قليل للغايه',
            'description.max'=>'احرف وصف الفستان الفستان كثيره للغايه',
            'description.string'=>'اعد كتابه الوصف بشكل صحيح',

            'X.alpha'=>'اعد المحاوله',
            'X.max'=>'اعد المحاوله',

            'L.alpha'=>'اعد المحاوله',
            'L.max'=>'اعد المحاوله',

            'XL.alpha'=>'اعد المحاوله',
            'XL.max'=>'اعد المحاوله',

        );

        $validated = $request->validate([
            'image1' => 'mimes:png,jpg,jpeg|min:1|required',
            'image2' => 'mimes:png,jpg,jpeg|min:1|required',
            'image3' => 'mimes:png,jpg,jpeg|min:1|required',
            'price' => 'numeric|max:10000000|min:2|required',
            'color' => 'alpha|max:60|min:2|required',
            'description' => 'string|min:60|max:1000|required',
            'X' => 'alpha|max:1',
            'L' => 'alpha|max:1',
            'XL' => 'alpha|max:2',
        ],$messsages);
       
        $dresses_type = [
            'فساتين زفاف',
            'فساتين سوارية',
            'فساتين أطفال',
            'اخرى',
        ];

        if(!\in_array($request->input('type'),$dresses_type)){
            
            notify("اختر نوع الفستان","Toast","danger");
            return back();
        }



        // check number of items in db for this user if it's not lessthan subscription or equal allow adding item
        $id = Auth::user()->id;
        $items_count = \sizeof($users = DB::table('Items')->where('seller_id','=',$id)->get());
        $subscription_type = Auth::user()->subscription_type;
        
        // if user is admin? allow to add item otherwise check them
        // if user is not admin start checking them and try to stoping them 
        if (!Auth::user()->isAdmin() OR Auth::user()->account_type != 'buyer') {
            // if user not subscribe in plan check if the plan allow hem add more items
            if ($items_count >= $subscription_type AND Auth::user()->account_type != 'admin') {
                notify("انت غير مشترك باي باقه","Toast","danger");
                return back();
            }
        }

        // get all inputs to insert them into db
        $size_x = $request->input('X') == 'X' ? true : false;
        $size_l = $request->input('L') == 'L' ? true : false;
        $size_xl = $request->input('XL') == 'XL' ? true : false;
        $price = $request->input('price');
        $color = $request->input('color');
        $description = $request->input('description');
        $files = $request->file();
        $type = $request->input('type');
        
        // check if there is any file uploaded or not
        if(\sizeof($files) == 3)
        {
        // create names for files
        $imageName1 = $id."_".time().'A'.\rand(1,2000).'.'.$request->image1->extension();  
        $imageName2 = $id."_".time().'B'.\rand(1,2000).'.'.$request->image1->extension();  
        $imageName3 = $id."_".time().'C'.\rand(1,2000).'.'.$request->image1->extension();  
        
        // save images in desk
        $request->image1->move(public_path('images/items'), $imageName1);
        $request->image2->move(public_path('images/items'), $imageName2);
        $request->image3->move(public_path('images/items'), $imageName3);
        
        
        // insert all information in db
        DB::table('Items')->insert([
            [
            'price' => $price,
            'color' => $color,
            'description' => $description,
            'seller_id' => Auth::user()->id,
            'image1' => '/images/items/'.$imageName1,
            'image2' => '/images/items/'.$imageName2,
            'image3' => '/images/items/'.$imageName3,
            'X' => $size_x,
            'L' => $size_l,
            'XL' => $size_xl,
            'view' => false,
            'type' => $type,
            // 'date_expire' => $date_expire,

            ]
        ]);

        notify("تم اضافه الفستان بنجاح","Toast",'success');
        return back();

        }else {

            notify("تاكد من الصور","Toast","danger");
            return back();
        }

        notify("تاكد من المدخلات!!","Toast","danger");
        return back();
    }

    // allows items to show in web site if user is subscribe
    function activeate_item(Request $request,$item_id){
        
        // check if user subscribe or not
        if (Auth::user()->isSubscripted()) {

            $user_id = Auth::user()->id;
            $item = DB::table('Items')->where('id',$item_id)->where('seller_id','=',$user_id)->get();
            // ckeck if is this item in db and user allowed to add more items ? active item 
            if (\sizeof($item) > 0 AND Auth::user()->isAllowAddItems($item_id)) {
                // active item
                $status = DB::update('update Items set view = true where id = ?', [$item_id]);
                notify("تم تفعيل المنتج للعرض","Toast","success");
                return back();
            }
            // otherwise go back 
            notify("لم يتم تنشيط المنتج","Toast","danger");
            return back();
        }

        // if user not subscribe do not allow hem to active his items 
        notify("لم يتم تفعيل المنتج","Toast","warning");
        return back();

    }

    // dectivate items 
    function dactiveate_item(Request $request,$item_id){
        $user_id = Auth::user()->id;
        // is this item for this user? if it's 
        $item = $users = DB::table('Items')->where('id',$item_id)->where('seller_id','=',$user_id)->get();
        // if exists
        if (\sizeof($item) > 0 ) {
            # dactive the item
            $status = DB::update('update Items set view = false where id = ?', [$item_id]);
            
            notify("تم  الغاء تفعيل المنتج للعرض","Toast","warning");
            return back();
        }
        // otherwise go back
        notify("لم يتم الغاء تفعيل المنتج","Toast","warning");
        return back();

    }

    
    // delete item
    function delete_item(Request $request,$item_id){
        $seller_id = Auth::user()->id;
        // dd(Str::length('1234'));
        if (!\is_numeric($item_id) AND Str::length($item_id) <12) {
            # code...
            notify("لم يستم حذف المنتج","Toast","success");

            return back();
        }

        $item = DB::table('Items')
        ->where('id','=',$item_id)
        ->delete();

        if ($item == 1 ) {
            notify("تم حذف المنتج","Toast","success");
            return back();
        }
        // otherwise go back
        notify("لا يمكن حذف هذا المنتج","Toast","danger");
        return back();

    }

    function get_active_items(){
        // get all active items 
        $user_id = Auth::user()->id;
        $items = DB::table('Items')->where('seller_id','=',$user_id)->where('view','=','1')->get();
        
        return view('dashboard_pages.sellers.active_dresses',['items' => $items]);
    }
    
    
    function get_dactive_items(){
        // get all dactivate items 
        $user_id = Auth::user()->id;
        $items = DB::table('Items')->where('seller_id','=',$user_id)->where('view','=','0')->get();

        return view('dashboard_pages.sellers.active_dresses',['items' => $items]);
    }


    // function dalete_item(){
    //     // get all dactivate items 
    //     $user_id = Auth::user()->id;
    //     $items = DB::table('Items')->where('seller_id','=',$user_id)->where('view','=','0')->get();

    //     return view('dashboard_pages.sellers.active_dresses',['items' => $items]);
    // }
}
