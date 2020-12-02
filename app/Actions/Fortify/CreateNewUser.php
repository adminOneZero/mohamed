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
    public function create(array $input)
    {
      // 'province' => $input['province'],
      // dd($input['province']);
      Validator::make($input, [
        'name' => ['required', 'string','min:6', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => $this->passwordRules(),
        'password' => [
          'string',
          'min:5',
          'max:150',
        ],
        'account_type'=> [
          'string',
          'max:6',
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
          // 'String',
          'max:50',
          'required',
        ],
        'submit'=>[
          'String',
          'max:5',
        ],
        ])->validate();
        
        // $a = carbon::now();
        // $b = $a->addDay();
        // dd($a->toDateTimeString());
        $account_type = $input['account_type'];
        
        if ($account_type == 'seller') {
          # code...
          $account_type = 'seller';
        }elseif ($account_type == 'buyer') {
          # code...
          $account_type = 'buyer';
        } else {
          # code...
          return redirect('/login');
        }
        // dd("Hi");
        
        return User::create([
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
    }
}
