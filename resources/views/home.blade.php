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
            <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"/>
            <link rel="stylesheet" type="text/css" href="/css/iziToast.min.css">

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

                        <form action="/search/" style="display: inline-block">
                            @csrf
                            <input id="search_box" type="hidden" name="section" value="all">
                            <li class="search">
                                {{-- <a href="#"><i class="fa fa-search"></i></a> --}}
                                {{-- <input type="submit" value="search" class="fa fa-search"> --}}
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
                    <div class="box1 text-right col-3">
                        <a href="#">
                            <a href="register.html"><i class="fas fa-user-alt"></i></a>
                            <a href="/wishlist"><i class="far fa-heart"></i></a>
                    </div>
                    <div class="col-6">
                        <div class="img-me">
                            <a href="/"><img src="img/AHMED.png" alt=""></a>
                        </div>
                    </div>
                    <div class="box2 text-left col-3">
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
                <li class="active"><a href="index.html"><i class="fas fa-house-damage"></i>الصفحة الرئيسية </a></li>
                <li><a href="products.html"><i class="fas fa-female"></i>فساتين زفاف</a></li>
                <li><a href="products.html"><i class="fas fa-female"></i>فساتين سوارية </a></li>
                <li><a href="products.html"><i class="fas fa-child"></i> فساتين أطفال</a></li>
            </ul>
        </section>

        <!--End NavBar right-->

        <!--Start section-one-->

        <section class="section-one">
                <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                      <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
                      <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
                      <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                      <div class="carousel-item active">
                          <div class="overlay"></div>
                        <img src="img/landing-2.jpg" class="d-block w-100" alt="...">
                      </div>
                     <div class="carousel-item">
                        <div class="overlay"></div>
                        <img src="img/landing-1.jpg" class="d-block w-100" alt="...">
                      </div>
                      <div class="carousel-item">
                        <div class="overlay"></div>
                        <img src="img/landing-0.jpg" class="d-block w-100" alt="...">
                      </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="sr-only">Next</span>
                    </a>
                  </div>
        </section>

        <!--End section-one-->

        <!--Start section-tow-->

        <section class="section-tow">
            <div class="container">
                <div class="row">
                    <div class="col-sm-4 col-12">
                        <div class="img-me">
                            <div class="overlay"></div>
                            <img src="img/1.jpg" class="w-100" alt="">
                        </div>
                        <a href="/wedings">فساتين زفاف</a>
                    </div>
                    <div class="col-sm-4 col-12">
                        <div class="img-me">
                            <div class="overlay"></div>
                            <img src="img/5.jpg" class="w-100" alt="">
                        </div>
                        <a href="/soaris">فساتين سوارية</a>
                    </div>
                    <div class="col-sm-4 col-12">
                        <div class="img-me">
                            <div class="overlay"></div>
                            <img src="img/1.jpg" class="w-100" alt="">
                        </div>
                        <a href="/kids">فساتين أطفال</a>
                    </div>
                </div>
            </div>
        </section>

        <!--End section-tow-->

        <!--End section-three-->

        <section class="section-three">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8 col-12 box2">
                        <img src="img/6.jpg"  alt="">
                    </div>
                    <div class="col-sm-4 col-12 box1 text-right">
                        <h2>حجز موعد</h2>
                        <p>
                            لمشاهدة فساتيننا الجميلة وذات الأسعار المعقولة شخصيًا ، يمكنك زيارتنا في صالة عرض سيدني في الإسكندرية أو صالة عرض ملبورن في كارلتون.لمشاهدة فساتيننا الجميلة وذات الأسعار المعقولة شخصيًا ، يمكنك زيارتنا في صالة عرض سيدني في الإسكندرية أو صالة عرض ملبورن في كارلتون.لمشاهدة فساتيننا الجميلة وذات الأسعار المعقولة شخصيًا ، يمكنك زيارتنا في صالة عرض سيدني في الإسكندرية أو صالة عرض ملبورن في كارلتون.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!--End section-three-->
        {{-- {{ dd(DB::table('most_buy')->limit(1)->get()->count()) }} --}}
        <!--End section-four-->
        @if (DB::table('most_buy')->limit(1)->get()->count() == 1)
            
        <section class="section-four text-center">
            <div class="container">
                <h2>الأكثر مبيعا</h2>
                <div class="row">
                    @foreach ($mostBuyItems as $item)
                    {{-- {{ dd($item) }} --}}
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="box">
                            <div class='img-me'>
                                <div class="overlay"></div>
                               <a href="/item/{{ $item->item_id }}"><img src="{{ $item->image1 }}"  alt=""></a>
                                <i class="far fa-heart"></i>
                            </div>
                            <div class="show-button">
                                <span class="float-right">{{ $item->price }}</span>
                                <button class="float-lift" type="button"><i class="fas fa-cart-arrow-down"></i>عربتي </button>
                            </div>
                        </div>
                    </div>
                        
                    @endforeach
                    

                </div>
            </div>
        </section>
        @endif

        <!--End section-four-->

        <!--End section-five-->

        <section class="secrion-five text-right">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-12 box1">
                        <h2>أفضل يوم <br>من حياتك</h2>
                    </div>
                    <div class="col-lg-9 col-12 box2">
                        <p>نعتقد أن فستانك يجب أن يكون انعكاسًا مثاليًا للعروس المتألقة التي أنت عليها. بفضل مجموعتنا المتنوعة من مصممي فساتين الزفاف بأسعار معقولة ، لدينا مجموعة واسعة من الأساليب في المخزون. ومع ذلك ، إذا كنت تريد شيئًا مميزًا إضافيًا ، فسنعمل وفقًا لرؤيتك ونصنع فستانًا فريدًا مصممًا لك.<br> من السهل طلب فساتين زفاف بأسعار معقولة عبر الإنترنت من خلال عملية الدفع الآمنة والآمنة التي يقدمها أوليج كاسيني. نشحن جميع أنحاء أستراليا في غضون 14 يومًا لجميع العناصر الموجودة في المخزن. ستستغرق الفساتين المصممة حسب الطلب وقتًا أطول قليلاً بسبب العمل الإضافي الذي ينطوي عليه إنشائها.</p>
                    </div>
                </div>
            </div>
        </section>

        <!--End section-five-->

        <!--Start section-six-->

        <section class="section-six text-center">
            <div class="container">
                <div class="row">
                    <div class=" col-lg-3 col-sm-6 col-xs-12 box">
                        <h2>الخدمات</h2>
                        <a href="/subscription"><p>الباقات</p></a>
                        @if (!Auth::check())
                        <a href="/affiliate-program"><p> برنامج التسوق </p></a>
                        @endif
                        <a href="#"><p>مشترياتي</p></a>
                        <a href="#"><p>مصار مشتر</p></a>
                    </div>

                    <div class=" col-lg-3 col-sm-6 col-xs-12 box">
                        <h2>معلومات</h2>
                        <a href="#"><p>معلومات عنا</p></a>
                        <a href="#"><p> تواصل معنا</p></a>
                        <a href="#"><p>سياسة خاصة</p></a>
                        <a href="#"><p> الطلبات</p></a>
                    </div>

                    <div class=" col-lg-3 col-sm-6 col-xs-12 box">
                        <h2>تواصل</h2>
                        <a href="#"><p>صفقات</p></a>
                        <a href="#"><p> موبيل</p></a>
                        <a href="#"><p>لاب توب</p></a>
                        <a href="#"><p> كاميرا</p></a>
                    </div>

                    <div class=" col-lg-3 col-sm-6 col-xs-12 abuot">
                        <h2>معلومات عنا</h2>
                        <p>هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات </p>
                        <ul class="links ">
                            <li><a href="#"><i class="fa fa-phone"></i> 010000000000000</a></li>
                            <li><a href="#"><i class="fas fa-envelope"></i> email@email.com</a></li>
                            <li><a href="#"><i class="fas fa-map-marker-alt"></i> مصر</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!--End section-six-->
        <div class="but-scroll"><i class="fas fa-arrow-alt-circle-up fa-4x"></i></div>
        <!--Start footer-->
        <footer class="text-center">
            <div class="container">
                    <h5>حقوق النشر محفوظة </h5>
                </div>
            </div>
        </footer>
        <!--End footer-->

        <script src="js/jQuery-min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/script.js"></script>
        <script src="/js/iziToast.js"></script>
        <script src="/js/notify-sys.js"></script>
        @include('vendor.lara-izitoast.toast')

    </body>
</html>
