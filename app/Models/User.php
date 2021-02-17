<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'cuntry',
        'province',
        'address',
        'account_type',
        'account_active',
        'image',
        'status',
        'subscription_in',
        'subscription_out',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];


    public function Items()
    {
        return $this->hasMany('App\Models\Item');
    }
    public function isAdmin()
    {
        if ($this->account_type == 'admin') {
            # code...
            return true;
        }else{
            
            return false;
        }
    }

    public function isActive()
    {
        try {
            //code...
            $status = $this->account_active;
            if ($status == 1) {
                # code...
                return true;
            }else {
                # code...
                return false;
            }
        } catch (\Throwable $th) {
            //throw $th;
            return false;
            
        }
    }

    public function isAllowAddItems()
    {
        try {
            //code...
            if ($this->account_type == 'admin') {
                # code...
                return true;
            } else {
                if ($this->isSubscripted()) {
                    // check if complete the limt of adding items according of subsrciption  
                    $subscription = $this->subscription_type;
                    $items_count = \sizeof(DB::table('Items')->where('user_id','=',$this->id)->get());
                    // check if stell allow add items                
                    if ($subscription >= $items_count) {
                        # code...
                        return true;
                    }else {
                        # code...
                        return false;
                    }
                }else{
                    return false;
                }
                # code...
            }
            
        } catch (\Throwable $th) {
            //throw $th;
            return false;
            
        }
    }



    public function isSubscripted()
    {
        if ($this->account_type == 'admin') {
            # code...
            return true;
        } else {

            if ($this->subscription_out != null) {
                # code...
                // $sub_start = carbon::createFromFormat('Y-m-d H:i:s',$this->subscription_in) ;
                $sub_end = carbon::createFromFormat('Y-m-d H:i:s',$this->subscription_out);
                $now = carbon::now();
                $status = $sub_end->gt($now);
                if ($status) {
                    return true;
                }
            }
            return false;
    
        }
        
    }
    
    function dactiveItemsIfNotSubscribe(){
        if (!$this->isSubscripted()) {
            # code...
            DB::table('Items')->update(['view' => 0])->where('user_id','=',$this->id);
            // NOTE: user shuld go and reactive items manually
        }
    }
}
