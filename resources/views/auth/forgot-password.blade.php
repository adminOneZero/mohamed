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
                <div class="boxs">
                    <div class="sign-up">
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <a href="/"><img src="img/logo-2.png" alt=""></a>

                            <div class="block">
                                <x-jet-label for="email" value="الايميل" />
                                <x-jet-input placeholder="ادخل الايميل" id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                            </div>
                
                            <div class="flex items-center justify-end mt-2">
                                
                                <x-jet-button class="p-3">
                                    {{ __('Email Password Reset Link') }}
                                </x-jet-button>
                            </div>
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
