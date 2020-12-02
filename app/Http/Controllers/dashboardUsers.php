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
        
        dd($result);

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
        if (!\is_numeric($id) || Str::length($id)) {
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
            "addresses"	=> $user_data["addresses"],
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
    
    function alert($message,$user_id) {
        $result = DB::table('Notifications')->insert([
          'message' => $message,
          'user_id' => $user_id,
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

        // validation error
        // if ($validator->fails()) {
        //     return redirect('/dashboard/users')
        //                 ->withErrors($validator)
        //                 ->withInput();
        // }
        $id = $request->input('id');
        $sub_type = $request->input('sub_type');
        // check is request in plan
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
            # code...
            $status = User::where('id',$id)->update(['subscription_in'=>$time_now,'subscription_out'=>$expire,'subscription_type'=>$sub_type]);
            if ($status == 1) {
                # code...
                // return intval($sub_type) == 2 ? 2 : 'a'+strval(10)+'b';
                // return $sub_type;
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
}
