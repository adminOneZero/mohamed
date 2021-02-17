<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use Illuminate\Http\Request;

class marketersController extends Controller
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

    function payments()
    {
        $paymentHistory = DB::table('marketers_payment_requests')
        ->where('marketer_id',Auth::user()->id)
        ->orderBy('id', 'desc')
        ->paginate(config('conf.page_items_limit'));
        
        return view('marketers.payments',['payments' => $paymentHistory]);
    }

    function get_paid(Request $request)
    {
        $user_id = Auth::user()->id;
        $phone = $request->input('phone_number');
        $money = $request->input('money');
        $payment_methode = $request->input('payment_methode');
        
        $isRequestToGetPaidBefore = DB::table('marketers_payment_requests')
        ->where('status',1)
        ->count();

        $wallet = DB::table('marketers_wallet')
        ->where('marketer_id',Auth::user()->id)
        ->first();
        
        $wallet = $wallet == [] ? 0 : $wallet->wallet;

        if ($wallet < 500) {
            # code...
            notify('اقل مبلغ للتحويل هو 500 ج.م','Tost','danger');
            return back();
        }
        if ($isRequestToGetPaidBefore != 0) {
            # code...
            notify('ارسلت طلب للدفع من قبل الرجاء الانتظار...','Tost','danger');
            return back();
        }

        if ($isRequestToGetPaidBefore == 0 && $wallet > 500) {

            $status = DB::table('marketers_payment_requests')
            
            ->insert([
                'marketer_id' => $user_id,
                'phone' => $phone,
                'payment_methode' => $payment_methode,
                'money' => $money,
                'status' => true,
                'date' => carbon::now()->toDateTimeString()
            ]);

            $this->alert('هنالك طلب دفع جديد',1,true);
            notify('تم ارسال الطلب','Tost','success');
            return back();
        }


    }

}
