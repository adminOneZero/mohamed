@extends('layouts.dashboard')

@section('active-users','active')
    
@section('body')
    
<div class="card max mt-10">
    <div class="card-header">
        <h3>
            اداره المستخدمين
        </h3>
        <i class="fas fa-ellipsis-h"></i>
    </div>
                <form class="navbar-search" style="margin-top:20px; ">
                    <input id="search_text" type="text" name="Search" class="navbar-search-input" placeholder="ابحث عن المستخدمين">
                    <i id="search_btn" class="fas fa-search"></i>
                </form>
                <button id="add_user_btn">add new user</button>
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
                        <td style="flex : 1;"><img class="m-2" style="vertical-align: middle" src="/img/8.webp" alt="" height="30px" width="30px"><span style="vertical-align: middle;margin-right:5px;">{{ $user->name }}</span></td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="dot">
                                <i class="bg-success"></i>
                                مكتمل
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
            <legend>Options:</legend>
            <button id="active_btn" type="button" class="btn btn-success">Activate</button>
            <button id="deactive_btn" type="button" class="btn btn-success">Deactivate</button>
            <button id="delete_btn" type="button" class="btn btn-success">Delete</button>
        </fieldset>

        <fieldset>
            <legend>Plans:</legend>
            <button id="sub_btn" type="button" class="btn btn-success">Subscript</button>
            <select name="sub_type" id="sub_type">
                <option value="2">tow</option>
                <option value="5">five</option>
                <option value="12">twelve</option>
            </select>
        </fieldset>
        <fieldset>
            <legend>change password :</legend>
            <form action="/dashboard/changepass" method="post">
                @csrf
                <input type="password" name="password" placeholder="password">
                <input type="password" name="password_confirmation" placeholder="password_confirmation">
                <input id="chPassID" type="hidden" name="user_id" >
                <input type="submit" value="change">
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
            <a href="index.html"><img src="/img/logo-2.PNG" alt=""></a>


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

            <select class="" name="cuntry">
              <option value="مصر">مصر</option>
            </select>

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


    <div id="modalx" class="iziModal" data-izimodal-group="alerts"></div>
</div>

{{ $users->links() }}

@section('js-page','/js/pages/dashboard/users.js')
@endsection