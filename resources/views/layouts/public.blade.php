<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">

        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>الصفحة الرئيسية</title>

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
            <link rel="icon" href="/img/logo-2.png">

            <!-- Custom stlylesheet -->
            <link rel="stylesheet" href="/css/stylePage.css"/>
            <link rel="stylesheet" type="text/css" href="/css/iziToast.min.css">
            <link rel="stylesheet" type="text/css" href="/css/iziModal.min.css">

        	<meta name="csrf-token" content="{{ csrf_token() }}">

    </head>
    <body>
       
<!--Start footer Top-->

   <div class="footer-top">
    <div class="container">
        <div class="row">

            <ul class="header-links col-lg-8 col-12">
                @if(Auth::check())
                <li><a href="/dashboard">حساب المستخدم</a></li>
                <span>|</span>
                <li>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                    <a class="dropdown-menu-link" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); this.closest('form').submit();">تسجيل الخروج</a>
                </form>
                </li>
                  @else
                  <li><a href="/register"><i class="fas fa-user-alt"></i>تسجيل حساب</a></li>
                  <span>|</span>
                  <li><a href="/login">تسجيل الدخول </a></li>
                  @endif
                  
                  <form action="/search/" style="display: inline-block" >
                    <input id="search_box" type="hidden" name="section" value="">

                  <li class="search">
                        @csrf
                        <button type="submit" class="search-btn"><i class="fa fa-search"></i></button>
                        <input type="search" name="search_text" class="" placeholder="بحث">
                    </li>
                </form>
            </ul>

            <ul class="header-links-one col-lg-4 col-12">
                <li><a href="/basket"><i class="fas fa-cart-arrow-down"></i></a></li>
                <li><a href="/wishlist"><i class="far fa-heart"></i></a></li>
            </ul>

        </div>
    </div>
</div>

<!--End footer Top-->

<!--Start header-->

<header>
    <div class="container">
        <div class="row">
            <div class="box1 col-3 text-right">
                    <a href="register.html"><i class="fas fa-user-alt"></i></a>
                    <a href="#"><i class="far fa-heart"></i></a>
            </div>

            <div class="col-6 text-center">
                <div class="img-me">
                    <a href="/"><img src="/img/AHMED.png" alt=""></a>
                </div>
            </div>

            <div class="box2 col-3 text-left">
                <a href="#"><i class="fa fa-search"></i></a>
                <a href="#"><i class="fas fa-bars"></i></a>
            </div>

        </div>
    </div>
</header>

<!--End header-->

<!--Start navbar-->

<nav>
    <div class="container">
        <ul class="main-nav">
            <li class="active"><a href="/">الصفحة الرئيسية</a></li>
            <li><a href="/wedings">فساتين زفاف</a></li>
            <li><a href="/soaris">فساتين سوارية </a></li>
            <li><a href="/kids">فساتين أطفال</a></li>
        </ul>
    </div>
</nav>

<!--End navbar-->

<!--Start NavBar right-->

<section class="nav-right">
    <ul class="links text-right">
        <i class="fa fa-times"></i>
        <li class="active"><a href="/">الصفحة الرئيسية</a></li>
        <li><a href="/wedings">فساتين زفاف</a></li>
        <li><a href="products.html">فساتين سوارية </a></li>
        <li><a href="products.html">فساتين أطفال</a></li>
    </ul>
</section>

<!--End NavBar right-->

<div id="messageAlert">
    <div id="q-text"></div>
    <button data-izimodal-close="" data-izimodal-transitionout="bounceOutDown">Close</button>
</div>

        @yield('body')

        {{-- javascript --}}
        <script src="/js/jQuery-min.js"></script>
        <script src="/js/iziModal.min.js"></script>
        <script src="/js/iziToast.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        <script src="/js/control.js"></script>
        <script src="/js/notify-sys.js"></script>
        <script src="/js/public.js"></script>
        <script src="@yield('js-page')"></script>
        <script src="@yield('js-page2')"></script>
        <script src="@yield('js-script')"></script>
        @include('vendor.lara-izitoast.toast')
    </body>
</html>
