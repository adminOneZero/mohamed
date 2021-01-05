
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
                            
                        </div>
                    </div>
                </div>
            </div>
        </section>

@endsection