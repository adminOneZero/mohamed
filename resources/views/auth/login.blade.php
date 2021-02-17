<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">

        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title> تسجيل الدخول</title>

            <!-- Google font -->

            <link  rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cairo|Oswald&display=swap">
            <link  rel="stylesheet" href="https://fonts.googleapis.com/css?family=Reem+Kufi&display=swap">

            <!-- Bootstrap -->
            <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"/>

            <!-- normalize -->
            <link type="text/css" rel="stylesheet" href="css/normalize.css"/>

            <!-- Font Awesome Icon -->
            <link rel="stylesheet" href="css/all.min.css">

             <!--  psge Icon -->
             <link rel="icon" href="img/logo-2.png">

            <!-- Custom stlylesheet -->
            <link rel="stylesheet" href="css/stylePage.css"/>
    </head>
    <body>

        <!--Start my-boxs- regstier-->

        <section class="boxs-regstier text-center">
            <div class="container">
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{$error}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                    @endforeach
                @endif
                <div class="boxs">
                
                    <div class="sign-up">
                        <form action="/login" method="post">
                            @csrf

                            <a href="/"><img src="img/logo-2.png" alt=""></a>

                            <h2> تسجيل الدخول <i class="fas fa-user-alt"></i></h2>

                            <input type="email" name="email" placeholder="ادخل البريد الإكتروني">

                            <input type="password" name="password" placeholder=" كلمة المرور ">
                            <button type="submit">تسجيل الدخول</button>

                            <a href="/forgot-password">هل نسيت كلمه المرور؟</a>
                            <a href="/register">انشاء حساب جديد </a>

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
