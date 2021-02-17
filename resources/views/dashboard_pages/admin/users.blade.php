@extends('layouts.dashboard')

@section('active-users','active')
    
@section('body')

@php
    $notiCount = DB::table('subscriptionRequests')->where('status','=',1)->count();
    $notiPayCount = DB::table('marketers_payment_requests')->where('status','=',1)->count();
    
@endphp
    
<div class="bar">
    <button id="add_user_btn" class="btn-base btn1"><i class="fa fa-plus"></i></button>
    <button id="usersPlanBtn" class="btn-base btn-dark">
        @if ($notiCount > 0)
        <span id="sub-badge" class="noti-badge">{{ $notiCount }}</span>
        @endif
        <i class="fa fa-bell"></i> 
        طلبات الاشتراك
    </button>

    <button id="usersPayments" class="btn-base btn-dark">
        @if ($notiPayCount > 0)
        <span id="paid-badge" class="noti-badge">{{ $notiPayCount }}</span>
        @endif
        <i class="fa fa-bell"></i> 
        طلبات الدفع
    </button>

    <form class="navbar-search" style="display: inline-block; ">
        <input  id="search_text" type="text" name="Search" class="navbar-search-input" placeholder="ابحث عن المستخدمين">
        <i id="search_btn" class="fas fa-search"></i>
    </form>

</div>
<div class="card max mt-10">
    <div class="card-header">
        <h3>
            اداره المستخدمين
        </h3>
        <i class="fas fa-ellipsis-h"></i>
    </div>
    <div class="card-content">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>اسم المستخدم</th>
                    <th>الايميل</th>
                    <th>حاله الحساب</th>
                    <th>نوع الحساب</th>
                    <th>عرض</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td style="flex : 1;"><img class="m-2" style="vertical-align: middle;border-radius:50%;" src="{{ $user->image }}" alt="" height="30px" width="30px"><span style="vertical-align: middle;margin-right:5px;">{{ $user->name }}</span></td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="dot">
                                @if ($user->account_active == 1)
                                
                                <span style="color: rgb(23, 255, 23);">نشط</span>
                                @else
                                
                                <span style="color: rgb(255, 255, 255);">خامل</span>
                                @endif
                            </span>
                        </td>
                        <td>
                            @if ($user->account_type == 'admin')
                                الاداره
                            @endif

                            @if ($user->account_type == 'seller')
                                بائع
                            @endif

                            @if ($user->account_type == 'buyer')
                                مشتري
                            @endif

                            @if ($user->account_type == 'marketer')
                                مسوق
                            @endif
                   
                        </td>
                        <td><a href="#" data-id="{{ $user->id }}" class="btn -btn-danger link-icon fas fa-eye size-1 showUserInfo" ></a></td>
                    </tr>
                    
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{-- start info modal --}}
    <div id="modal">
        <div class="info">
            
        </div>

        <fieldset>
            <legend>خيارات الحساب :</legend>
            <button id="active_btn" type="button" class="btn-base btn-success">تنشيط الحساب</button>
            <button id="deactive_btn" type="button" class="btn-base btn-danger">تغطيل الحساب</button>
            <button id="delete_btn" type="button" class="btn-base btn-danger">حذف الحساب</button>
        </fieldset>

        <fieldset>
            <legend>تجديد الاشتراك :</legend>
            <button id="sub_btn" type="button" class="btn-base btn-success">الاشتراك</button>
            <select name="sub_type" id="sub_type">
                <option value="2">منتجين</option>
                <option value="5">خمس منتجات</option>
                <option value="12">احد عشر منتج</option>
            </select>
        </fieldset>
        <fieldset>
            <legend>تغير كلمه المرور :</legend>
            <form action="/dashboard/changepass" method="post">
                @csrf
                <input type="password" name="password" placeholder="كلمه المرور">
                <input type="password" name="password_confirmation" placeholder="تاكيد كلمه المرور">
                <input id="chPassID" type="hidden" name="user_id" >
                <input type="submit" value="تغير" class="btn-base btn-danger">
            </form>
        </fieldset>
    </div>
    {{-- end info modal --}}

    <div id="searchModal">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>اسم المستخدم</th>
                    <th>الايميل</th>
                    <th>حاله الحساب</th>
                    <th>نوع الحساب</th>
                    <th>عرض</th>
                </tr>
            </thead>
            <tbody id="table_body">
                
            </tbody>
        </table>                
    </div>


    <div id="newUserModal">
        <form action="/dashboard/add" method="POST">
            @csrf
            {{-- <a href="index.html"><img src="/img/logo-2.png" alt=""></a> --}}
            <h3 style="text-align: center">اضف مستخدم جديد</h3>

            <div class="my-radio">
                <input type="radio" required name="account_type" value="buyer" id="radio-cus"><label>مشتري</label>
                <input type="radio" required name="account_type" value="seller" id="radio-sup"><label>بائع</label>
                <input type="radio" required name="account_type" value="admin" id="radio-sup"><label>اداره</label>
              </div>
            <div class="form-group">
              <small class="text-danger"></small>
            </div>


            <input required class="form-control" type="text" name="name" id="user_name" placeholder="اسم المستخدم">
            <div class="form-group">
              <small class="text-danger"></small>
            </div>

            <input required class="form-control" type="email" name="email" placeholder=" البريد الإكتروني">
                <div class="form-group">
                  <small class="text-danger"></small>
                </div>

            <input required class="form-control" type="password" name="password" placeholder=" كلمة المرور ">
                <div class="form-group">
                  <small class="text-danger"></small>
                </div>

            <input required class="form-control" type="password" name="password_confirmation" placeholder="تأكيد كلمة المرور">
                <div class="form-group">
                  <small class="text-danger"></small>
                </div>

            <input required class="form-control" name="phone" type="text" placeholder="الهاتف">
                <div class="form-group">
                  <small class="text-danger"></small>
                </div>
<div>

    <select class="" name="cuntry">
        <option value="مصر">مصر</option>
    </select>
</div>

            <input required class="form-control" name="province" type="text" placeholder="المحافظة">
                <div class="form-group">
                  <small class="text-danger"></small>
                </div>

            <input required class="form-control" name="address" type="text" placeholder="العنوان">
            <div class="form-group">
              <small class="text-danger"></small>
            </div>
            <input  class="button-sub text-center" type="submit" name="submit" value="تسجيل">

        </form>     
    </div>


    {{-- <div id="modalx" class="iziModal" data-izimodal-group="alerts"></div> --}}
    <div id="usersNeedSubPlan" >
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>اسم المستخدم</th>
                    <th>الايميل</th>
                    <th>حاله الحساب</th>
                    <th>نوع الحساب</th>
                    <th>عرض</th>
                </tr>
            </thead>
            <tbody id="planInfo">
                
            </tbody>
        </table>       
    </div>

    <div id="userPaymentRequ" >
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>اسم المستخدم</th>
                    <th>المبلغ</th>
                    <th>طريقه الدفع</th>
                    <th>رقم الهاتف</th>
                    <th>القبول</th>
                    <th>عرض</th>
                </tr>
            </thead>
            <tbody id="paymentReqUserInfo">
                
            </tbody>
            <input type="hidden" id="current_id">
        </table>       
    </div>

</div>

{{ $users->links() }}

@section('js-page','/js/pages/dashboard/users.js')
@endsection