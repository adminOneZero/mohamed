<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">

        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>   انشاء حساب جديد</title>

            <!-- Google font -->

            <link  rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cairo|Oswald&display=swap">
            <link  rel="stylesheet" href="https://fonts.googleapis.com/css?family=Reem+Kufi&display=swap">

            <!-- Bootstrap -->
            <link type="text/css" rel="stylesheet" href="/css/bootstrap.min.css"/>
            <link rel="stylesheet" type="text/css" href="/css/iziToast.min.css">

            <!-- normalize -->
            <link type="text/css" rel="stylesheet" href="/css/normalize.css"/>

            <!-- Font Awesome Icon -->
            <link rel="stylesheet" href="/css/all.min.css">

            <!--  psge Icon -->
            <link rel="icon" href="/img/logo-2.png">

            <!-- Custom stlylesheet -->
            <link rel="stylesheet" href="/css/stylePage.css"/>
    </head>
    <body>

        <!--Start my-boxs- regstier-->

        <section class="boxs-regstier text-center">
            <div class="container">
                <div class="boxs">


                    <div class="sign-up">
                        <form action="/register" method="post">

                            <a href="/"><img src="img/logo-2.png" alt=""></a>

                            <h2> انشاء حساب مسوق <i class="fas fa-user-alt"></i></h2>

                            <div class="my-radio">
                                {{-- <input type="radio"  name="account_type" value="buyer" id="radio-cus"><label>مشتري</label>
                                <input type="radio"  name="account_type" value="seller" id="radio-sup"><label>بائع</label> --}}
                                <input type="hidden" name="account_type" value="marketer">
                              </div>
                            <div class="form-group{{ $errors->has('account_type') ? ' has-error' : '' }}">
                              <small class="text-danger"></small>
                            </div>


                            <input  class="form-control" type="text" name="name" id="user_name" placeholder="اسم">
                            <div class="form-group{{ $errors->has('full_name') ? ' has-error' : '' }}">
                              <small class="text-danger"></small>
                            </div>

                            <input  class="form-control" type="email" name="email" placeholder=" البريد الإكتروني">
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                  <small class="text-danger"></small>
                                </div>

                            <input  class="form-control" type="password" name="password" placeholder=" كلمة المرور ">
                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                  <small class="text-danger"></small>
                                </div>

                            <input  class="form-control" type="password" name="password_confirmation" placeholder="تأكيد كلمة المرور">
                                <div class="form-group{{ $errors->has('confirm_password') ? ' has-error' : '' }}">
                                  <small class="text-danger"></small>
                                </div>

                            <input  class="form-control" name="phone" type="text" placeholder="الهاتف">
                                <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                  <small class="text-danger"></small>
                                </div>

                            <select class="" name="cuntry">
                              <option value="مصر">مصر</option>
                            </select>

                            <input  class="form-control" name="province" type="text" placeholder="المحافظة">
                                <div class="form-group{{ $errors->has('province') ? ' has-error' : '' }}">
                                  <small class="text-danger"></small>
                                </div>

                            <input  class="form-control" name="address" type="text" placeholder="العنوان">
                            <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                              <small class="text-danger"></small>
                            </div>
                            @csrf

                            <input  class="button-sub text-center" type="submit" name="submit" value="تسجيل">
                            <a href="/login">لدي حساب</a>

                        </form>
                    </div>


                </div>
            </div>
        </section>

        <!--End my-boxs- regstier-->

        <script src="/js/jQuery-min.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        <script src="/js/script.js"></script>
        <script src="/js/iziToast.js"></script>
        <script src="/js/notify-sys.js"></script>

        @include('vendor.lara-izitoast.toast')

    </body>
</html>
