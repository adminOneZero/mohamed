<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */

    function alert($message,$user_id) {
      $result = DB::table('Notifications')->insert([
        'message' => $message,
        'user_id' => $user_id,
        'time' => carbon::now()->toDateTimeString(),
        'status' => 1,
        ]);
      return $result;
  }

  public function create(array $input)
    {

      $customMessages = [
        'name.max'=>'الاسم طويل جدا',
        'name.min'=>'الاسم قصير للغايه',
        'name.required'=>'الرجاء ادخال الاسم',

        'email.max'=>'الايميل طويل جدا',
        'email.min'=>'الايميل قصير للغايه',
        'email.required'=>'الرجاء ادخال الايميل',
        'email.unique'=>'هذا الايميل مستخدم مسبقا',

        'password.max'=>'كلمه المرور طويل جدا',
        'password.min'=>'كلمه المرور قصير يجب ان لا تقل عن 8 احرف',
        'password.required'=>'الرجاء ادخال كلمه المرور',
        'password.string'=>'الرجاء ادخال كلمه المرور حروف وارقام',
        'password.confirmed'=>'الرجاء تاكيد كلمه المرور',

        'account_type.max'=>'حدد نوع الحساب',
        'account_type.min'=>'حدد نوع الحساب',
        'account_type.required'=>'حدد نوع الحساب',
        'account_type.string'=>'حدد نوع الحساب',

        'phone.max'=>'رقم الهاتف طويل جدا',
        'phone.min'=>'رقم الهاتف قصير جدا',
        'phone.required'=>'الرجاء ادخال رقم الهاتف',

        'cuntry.max'=>'اختر الدوله',
        'cuntry.min'=>'اختر الدوله',
        'cuntry.required'=>'اختر الدوله',
        'cuntry.string'=>'اختر الدوله',
        

        'province.max'=>'عنوان المحافظه او الولايه طويل جدا',
        'province.min'=>'عنوان المحافظه او الولايه قصير للغايه',
        'province.required'=>'الرجاء ادخال عنوان المحافظه او الولايه',

        'address.max'=>'العنوان طويل جدا',
        'address.min'=>'العنوان قصير للغايه',
        'address.required'=>'الرجاء ادخال العنوان',
        
      ];

      Validator::make($input, [
        'name' => ['required', 'string','min:6', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => [
          'string',
          'min:8',
          'max:250',
          'required',
          'confirmed'
        ],
        'account_type'=> [
          'string',
          'max:8',
          'required',
        ],
        'phone' => [
          'max:25',
          'required',
        ],
        'cuntry' => [
          'String',
          'max:3',
          'required',
        ],
        'province'=>[
          'String',
          'max:40',
          'required',
        ],
        'address'=>[
          'String',
          'max:50',
          'required',
        ],
        'submit'=>[
          'String',
          'max:5',
        ],
      ],$messages = $customMessages)->validate();
        
        $account_type = $input['account_type'];

        if ($account_type == 'seller') {
          $account_type = 'seller';
        }elseif ($account_type == 'distributor') {
          $account_type = 'distributor';
          
        }elseif ($account_type == 'buyer') {
          $account_type = 'buyer';

        }elseif ($account_type == 'marketer') {
          $account_type = 'marketer';

        } else {
          return redirect('/login');
        }
        
        $result = User::create([
          'name' => $input['name'],
          'email' => $input['email'],
          'password' => Hash::make($input['password']),
          'phone' => $input['phone'],
          'cuntry' => $input['cuntry'],
          'province' => $input['province'],
          'address' => $input['address'],
          'account_type' => $account_type,
          'account_active' => false,
          'image' => '/img/user_photo.jpg',
          'subscription_type' => 0 ,
          ]);
          
          return $result; 

    }
}
