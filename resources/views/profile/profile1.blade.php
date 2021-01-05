<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">

        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ Auth::user()->name }}</title>

            <!-- Google font -->

            <link  rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cairo|Oswald&display=swap">
            <link  rel="stylesheet" href="https://fonts.googleapis.com/css?family=Reem+Kufi&display=swap">

            <!-- Bootstrap -->
            <link type="text/css" rel="stylesheet" href="/css/bootstrap.min.css"/>

            <!-- normalize -->
            <link type="text/css" rel="stylesheet" href="/css/normalize.css"/>

            <!-- Font Awesome Icon -->
            <link rel="stylesheet" href="/css/all.min.css">

             <!--  psge Icon -->
             <link rel="icon" href="img/logo-2.png">

            <!-- Custom stlylesheet -->
            <link rel="stylesheet" href="/css/stylePage.css"/>
    </head>
    <body>

        <!--Start my-boxs- regstier-->

        <section class="boxs-regstier text-center">
            <div class="container">
                <div class="boxs">
                    <div class="sign-up">
                        <form action="post">
                            <a href="index.html"><img src="/img/logo-2.png" alt=""></a>
                            <input type="file">
                            <button type="submit"> تحميل الصوره الشخصيه </button>

                        </form>
                        {{-- <h2> تسجيل الدخول <i class="fas fa-user-alt"></i></h2> --}}
                        
                        {{-- <input type="email" name="email" placeholder="ادخل البريد الإكتروني"> --}}
                        
                        <form action="/login" method="post">
                            <input type="password" name="password" placeholder="  كلمة المرور القديمه ">
                            <input type="password" name="password" placeholder=" كلمة المرور الجديده ">
                            <input type="password" name="password" placeholder=" اعد كلمة المرور الجديده ">
                            @csrf
                            <button type="submit">اعادة تعين كلمه المرور</button>

                        </form>
                    </div>
                </div>
            </div>
        </section>

        <!--End my-boxs- regstier-->

        <script src="js/jQuery-min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/script.js"></script>
    </body>
</html>
