<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class dashboardUsers extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //
        // function
    }

    function profile()
    {
        $is_subscribe = Auth::user()->isSubscripted();
        return view('profile.profile',['is_subscribe'=>$is_subscribe]);
    }

    function profile_image(Request $request)
    {
        $messsages = array(
            'image1.min'=>'اسم الصوره صغير للغايه',
            'image1.mimes'=>'هذا الملف غير مسموح به كصوره',
            'image1.required'=>'اختر الصوره الشخصيه اولا',

        );

        $validated = $request->validate([
            'image1' => 'mimes:png,jpg,jpeg|min:1|required',
            
        ],$messsages);


        $id = Auth::user()->id;
        $imageName1 = $id."_".time().'A'.\rand(1,2000).'.'.$request->image1->extension();  
         // save images in desk
         $request->image1->move(public_path('images/profile'), $imageName1);
        //  insert 
        DB::table('users')
        ->where('id',$id)
        ->update([
            'image' => '/images/profile/'.$imageName1,
        ]);

        return back();
    }


    function profile_changepass(Request $request)
    {
        notify("تم تغير كلمه المرور بنجاح","Toast","success");
        return redirect('login');
        $old_pass = $request->input('old_pass');
        $new_pass = $request->input('new_pass');
        $confirm_pass = $request->input('confirm_pass');

        $id = Auth::user()->id;

        // check if old pass is currect
        $is_user = DB::table('users')
        ->where('id',$id)
        ->first();

        if (!Hash::check($old_pass,$is_user->password )) {
            notify("كلمه المرور القديمه غير متطابقه!!","Toast","danger");
            return back();
        }

        if ($new_pass === $confirm_pass) {
            # code...
            // check password length
            if (Str::length($new_pass) < 7) {
                # code...
                notify("كلمه المرور الجديده قصيره جدا","Toast","danger");
                return back();
        
            }
            DB::table('users')
            ->where('id','=',$id)
            ->update(['password' => Hash::make($new_pass)]);

            notify("تم تغير كلمه المرور بنجاح","Toast","success");
            return back('login');

        }else {
            notify("تاكد من تطابق كلمه المرور الجديده","Toast","danger");
            return back();
        }

    }

    function get_users()
    {
        // $users = User::paginate(4);
        $users = User::paginate(15);
        return view('dashboard_pages.admin.users', ['users' => $users]);
    }

    function add_new_user(Request $request){
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        $phone = $request->input('phone');
        $cuntry = $request->input('cuntry');
        $province = $request->input('province');
        $address = $request->input('address');
        $account_type = $request->input('account_type');
        
        // check if user exists already
        $is_user_exists = DB::table('users')->where('email','=',$email)->count();
        if ($is_user_exists == 0) {
            # code...
            $result = User::create(
                [
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'phone' => $phone,
                'cuntry' => $cuntry,
                'province' => $province,
                'address' => $address,
                'account_type' => $account_type,
                'account_active' => false,
                'image' => '/img/user_photo.jpg',
                'subscription_type' => 0 ,
                ]
            );

            notify("تم اضافة المستخدم بنجاح","Toast","success");
            return back();

        }else {

            notify("المستخدم موجود مسبقا","Toast","danger");
            return back();

        }
        

    }

    function changePassword(Request $request){
        $password = $request->input('password');
        $password_confirmation = $request->input('password_confirmation');
        $id = $request->input('user_id');

        if ($password === $password_confirmation) {
            # code...
            // check password length
            if (Str::length($password) < 7) {
                # code...
                notify("كلمه المرور قصيره جدا","Toast","danger");
                return back();
        
            }
            DB::table('users')
            ->where('id','=',$id)
            ->update(['password' => Hash::make($password)]);

            notify("تم تغير كلمه المرور بنجاح","Toast","success");
            return back();

        }else {
            notify("تاكد من تطابق كلمه المرور","Toast","danger");
            return back();
        }

    }

    function get_user_info(Request $request,$id){
        // check id 
        if (!\is_numeric($id) || Str::length($id) == 0) {
            return response()->json([
                'message' => 'هنالك خطأ حاول مجدادا',
                'status' => 'danger',
            ]);
        }

        // get user id to get his information
        $user_data = User::where('id',$id)->first();
        $sub_type = $user_data["subscription_type"];

        $ms1 = 'باقه الصنفين';
        $ms2 = 'باقة الـ '. $sub_type . ' صنف';

        if (\is_numeric($sub_type)) {
            # code...
            $message = ($sub_type == 2) ? $ms1 : $ms2;
        }else {
            # code...
            $message = 'غير مشترك في اي باقه';
        }

        // $sub_start = carbon::createFromFormat('Y-m-d H:i:s',$this->subscription_in) ;
        // $sub_end = carbon::createFromFormat('Y-m-d H:i:s',$this->subscription_out);
        // $status = $sub_end->gt($sub_start);

        $respo = [
            "id"	=> $user_data["id"],
            "name"	=> $user_data["name"],
            "email"	=> $user_data["email"],
            "phone"	=> $user_data["phone"],
            "province"	=> $user_data["province"],
            "address"	=> $user_data["address"],
            "image"	=> $user_data["image"],
            "account_type"	=> $user_data["account_type"],
            "account_status"	=> ($user_data["account_active"] == 1 ) ? 'مفعل' : 'عاطل',
            "subscription_type"	=> $message,
            "subscription_in"	=> $user_data['subscription_in'],
            "subscription_out"	=> $user_data['subscription_out'],
            // // "sub_status"	=> $user_data["sub_status"],
        ];
        return $respo;
        // return response()->json([
        //     'message' => 'هنالك خطأ حاول مجدادا',
        //     'status' => 'danger',
        // ]);
        // return $user_data;
        // dd($data);
    }
    
    function alert($message,$user_id,$for_admin = false) {
        $group = "user";
        if ($for_admin) {
            $group = "admin";

        }
        $result = DB::table('Notifications')->insert([
            'message' => $message,
            'user_id' => $user_id,
            'group' => $group,
            'time' => carbon::now()->toDateTimeString(),
            'status' => 1,
            ]);
        return $result;
        
    }

    //active users
    function active_user(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|max:9',
        ]);

        // return \is_numeric($request->input('id'));
        // validation error
        if ($validator->fails() || !(\is_numeric($request->input('id')))) {
            return response()->json([
                'message' => 'لم يتم تفعيل الحساب',
                'status' => 'danger',
                // 'log' => $log,
            ]);
        }

        $id = $request->input('id');
        $current_time = carbon::now();
        $time_now = $current_time->toDateTimeString();
        $expire = $current_time->addMonth(1)->toDateTimeString();
        if (!User::find($id)->isActive() == 1) {
            # code...
            $status = DB::update('update users set account_active = true where id = ?', [$id]);
            // User::where('id',$id)->update(['subscription_in'=>$time_now,'subscription_out'=>$expire]);
            if ($status = 1) {
                # code...
                $this->alert('تم تفعيل وتنشيط حسابك بنجاح',$id);

                return response()->json([
                    'message' => 'تم تفعيل الحساب',
                    'status' => 'success',
                    // 'log' => $log,
                ]);
            }
        }else {
            # code...
            return response()->json([
                'message' => 'الحساب مفعل مسبقا',
                'status' => 'warning',
                // 'log' => $log,
            ]);
        }
    }

    function  deactive_user(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'numeric|required|max:9',
        ]);

        // validation error
        // if ($validator->fails()) {
        //     return redirect('/dashboard/users')
        //                 ->withErrors($validator)
        //                 ->withInput();
        // }
        $id = $request->input('id');
        $current_time = carbon::now();
        $time_now = $current_time->toDateTimeString();
        $expire = $current_time->addMonth(1)->toDateTimeString();
        if (User::find($id)->isActive() == 1) {
            # code...
            $status = DB::update('update users set account_active = false where id = ?', [$id]);
            // User::where('id',$id)->update(['subscription_in'=>$time_now,'subscription_out'=>$expire]);

            if ($status = 1) {
                # code...
                $this->alert('تم الغاء تفعيل حسابك الرجاء مراسله الاداره',$id);

                    return response()->json([
                        'message' => 'تم الغاء تفعيل الحساب',
                        'status' => 'success',
                    ]);
            }
        }else {
            # code...
            return response()->json([
                'message' => 'الحساب معطل مسبقا',
                'status' => 'warning',
            ]);
        }
    }


    function delete_user(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'numeric|required|max:9',
        ]);
        $id = $request->input('id');
        if ($id == 1) {
            # code...
            return response()->json([
                'message' => 'للاسق لايمكن حذف هذا المستخدم',
                'status' => 'danger',
                ]);
            }
            
            try {
                //code...
                $status = User::findOrFail($id)->delete();
                // return $status;
                # code...
                return response()->json([
                    'message' => 'تم حذف المستخدم',
                    'status' => 'success',
                    ]);
                } catch (\Throwable $th) {
                    return response()->json([
                    'message' => 'للاسق لايمكن حذف هذا المستخدم',
                    'status' => 'danger',
                    ]);
                }
    }

    function subscribe(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'numeric|required|max:9',
            'sub_type' => 'numeric|required|max:1',
        ]);

        $id = $request->input('id');
        $sub_type = $request->input('sub_type');
        // check is request one plans
        $isPlan = \in_array($sub_type,[2,5,12]);

        if ($isPlan != true) {
            # code...
            return response()->json([
                'message' => 'لا يمكن الاشتراك في هذه الباقه',
                'status' => 'warning',
            ]);
        }

        // set subscription time        
        $current_time = carbon::now();
        $time_now = $current_time->toDateTimeString();
        $expire = $current_time->addMonth(1)->toDateTimeString();

        if (User::find($id)->isActive() == 1) {
            # check is user request this plan or other
            $seller_plan_req = DB::table('subscriptionRequests')->where("user_id","=",$id)->first()->subscription_type;
            if ($sub_type != $seller_plan_req) {
                # code...
                return response()->json([
                    'message' => 'المستخدم لم يطلب هذه الباقه',
                    'status' => 'danger',
                ]);
            }
            $status = User::where('id',$id)->update(
                [
                    'subscription_in'=>$time_now,
                    'subscription_out'=>$expire,
                    'subscription_type'=>$sub_type
               ]
            );
            if ($status == 1) {
                # code...
                // make the user request done as true
                $items = DB::table('subscriptionRequests')
                ->where('user_id', $id)
                ->update(['status' => 0]);
                
                return response()->json([
                    'message' => (intval($sub_type) == 2) ? 'تم الاشتراك في باقية الصنفين' : 'تم الاشتراك في باقة '.strval($sub_type).' صنف',
                    'status' => 'success',
                ]);
            }
        }else {
            # code...
            return response()->json([
                'message' => 'نشط الحساب اولا',
                'status' => 'warning',
            ]);
        }
    }

    function search(Request $request){
        $search_text = $request->input('search_text');
        $users = DB::table('users')
                ->where('name', 'like', '%'.$search_text.'%')
                ->get();
        return $users;
    }

    function planReq(Request $request){
        $users_ids = DB::table('subscriptionRequests')
        ->where('status', '=', true)
        ->pluck('user_id');
        
        $users = DB::table('subscriptionRequests')
        ->join('users', 'subscriptionRequests.user_id', '=', 'users.id')
        ->whereIn('users.id',$users_ids)
        ->get();

        return $users;
    }

    function paymentReq(Request $request){
        $users_ids = DB::table('marketers_payment_requests')
        ->where('status', '=', 1)
        ->pluck('marketer_id');

        $users = DB::table('marketers_payment_requests')
        ->where('status', '=', 1)
        ->join('users', 'marketers_payment_requests.marketer_id', '=', 'users.id')
        ->whereIn('users.id',$users_ids)
        ->get();

        return $users;
    }
    
    // making user as paid
    function makePaid(Request $request){
        $user_id = $request->input('id');

        if (!\is_numeric($user_id )|| Str::length($user_id) > 11) {
            # code...
            return response()->json([
                'message' => 'المعرف غير صحيح',
                'status' => 'danger',
            ]);
        }

        // get commission
        $userData = DB::table('marketers_payment_requests')
        ->where('marketer_id', $user_id)
        ->where('status', 1)
        ->get();

        if (\count($userData) == 1) {
            # make marketer paid
            $status = DB::table('marketers_payment_requests')
            ->where('marketer_id', $user_id)
            ->where('status', 1)
            ->update(['status' => 0]);

            if ($status == 1) {
                # code...
                $payStatus = DB::table('marketers_wallet')
                ->where('marketer_id', $user_id)
                ->decrement('wallet', ($userData[0]->money));
                
                if ($payStatus == 1) {
                    # code...
                    $this->alert("تم تحويل اليك مبلغ قدره ".$userData[0]->money,$user_id);
                    return response()->json([
                        'message' => 'تم الدفع',
                        'status' => 'success',
                    ]);
                }
            }
        }
        
        return response()->json([
            'message' => 'فشلت العمليه',
            'status' => 'danger',
        ]);
    
    }


}


