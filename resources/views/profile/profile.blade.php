
@extends('layouts.dashboard')
@section('active-mange_requests','active')

@section('body')


        <!--Start my-boxs- regstier-->

        <section class="boxs-regstier text-center">
            <div class="container">
                <div class="boxs">
                    <div class="sign-up">

                        <div class=" profile-box">
                            <form method="post" action="/profile/image" enctype="multipart/form-data">
                                <h3>تعين صوره الشخصيه</h3>
                                <a href="#" ><img style="width: 300px;height:50vh;" src="{{ Auth::user()->image }}" alt=""></a>
                                <input type="file" name="image1">
                                <button type="submit" class="btn-base btn-success"> تحميل الصوره الشخصيه </button>
    
                                @csrf
                            </form>
                            <form action="/profile/changepass" method="post">
                                <h3>اعادة تعين كلمه المرور</h3>
                                <input type="password" name="old_pass" placeholder="  كلمة المرور القديمه ">
                                <input type="password" name="new_pass" placeholder=" كلمة المرور الجديده ">
                                <input type="password" name="confirm_pass" placeholder=" اعد كلمة المرور الجديده ">
                                <button type="submit" class="btn-base btn-danger">اعادة تعين كلمه المرور</button>
                                @csrf
    
                            </form>


                            <div class="">

                                @if (Auth::user()->account_type == 'seller')
                                    <h3>الباقه الاشتراكيه</h3>
                                    @if (Auth::user()->subscription_in != null)
                                        <p>  <span>تاريخ الاشتراك : </span></span> <span dir="ltr">{{ Auth::user()->subscription_in  }}</span> </p>
                                        <p>  <span>تاريخ الانتهاء : </span></span> <span dir="ltr">{{ Auth::user()->subscription_out }}</span> </p>
                                    @endif
                                    <p>
                                        <span>حاله الاشتراك : </span>
                                        @if ($is_subscribe)
                                            <strong style="color: green;font-size:30px;">مشترك</strong>
                                        @else
                                            <strong style="color: red;font-size:30px;">غير مشترك</strong>
                                        @endif
                                    </p>
                                    <p><a href="/subscription">الباقات</a></p>
                                @endif

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>

@endsection