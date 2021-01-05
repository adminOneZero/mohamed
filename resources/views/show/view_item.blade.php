@extends('layouts.public')

@section('body')

<!--Start section-img-->
<section class="section-img"></section>
<!--Start section-img-->





<section class="view-img text-right ">
    <div class="container">
        <div class="row">

            <div class="col-md-6 col-12 my-img">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{ $item[0]->image1 }}" class="d-block " style="height: 95vh;width:500px" alt="gomlaDresses">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ $item[0]->image2 }}" class="d-block " style="height: 95vh;width:500px" alt="gomlaDresses">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ $item[0]->image3 }}" class="d-block " style="height: 95vh;width:500px" alt="gomlaDresses">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">السابق</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">التالي</span>
                    </a>
                </div>
            </div>

            <div class="col-md-6 col-12 description">
                {{-- <h3>ايموجين</h3> --}}
                <p>${{ $item[0]->price }}</p>
                <h4>اختر اللون</h4>
                <select>
                    <option value="red">احمر</option>
                </select>
                <h4>اختر الحجم</h4>
                <select>
                    @if ($item[0]->X == 1)
                    <option value="1">X</option>
                        
                    @endif
                    @if ($item[0]->L == 1)
                        
                    <option value="L">L</option>
                    @endif
                    @if ($item[0]->XL == 1)
                    <option value="XL">XL</option>
                    
                    @endif
                    </select>


                <div class="links-des">
                    <ul>
                        <li class="active" data-show="box-one">الوصف</li>
                        <li><i class="fa fa-heart"></i></li>
                    </ul>
                </div>
                <div class="boxs">
                    <div class="box box-one">
                        <p>{{ $item[0]->description }}</p>
                    </div>

                </div>

                <button type="button" data-item_id="{{ $item[0]->id }}" class="but-add addToBasket">اضافة الي العربة</button>
            </div>

        </div>
    </div>
    </div>
</section>













 <!--Start section-products-->

 <section class="view-pro">
    <div class="container">
        <h2 class="text-right">ربما يعجبك أيضاً</h2>
        <div class="row">
            @foreach ($may_like as $item)
                
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="box">
                    <div class='img-me'>
                        <div class="overlay"></div>
                        <a href="/item/{{ $item->id }}"><img src="{{ ($item->image1) }}" alt=""></a>
                        <i class="far fa-heart"></i>
                    </div>
                    <div class="show-button">
                        <span class="float-right">${{ ($item->price) }}</span>
                        <button class="float-lift addToBasket" data-item_id="{{ $item->id }}" type="button"><i class="fas fa-cart-arrow-down "></i>الى السله </button>
                    </div>
                </div>
            </div>
            @endforeach

            
        </div>
    </div>
</section>

<!--End section-products img-->
{{-- {{ $items->links() }} --}}


<!--End porducer -->

<!--Start section-six-->

<section class="section-six text-center">
    <div class="container">
        <div class="row">
            <div class=" col-lg-3 col-sm-6 col-xs-12 box">
                <h2>الخدمات</h2>
                <a href="register.html"><p>تسجيل دخول</p></a>
                <a href="#"><p>بطاقة الا</p></a>
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
<div class="but-scroll"><i class="fas fa-cloud-upload-alt fa-4x"></i></div>
<!--Start footer-->
<footer class="text-center">
    <div class="container">
            <h5>حقوق النشر محفوظة </h5>
        </div>
</footer>
<!--End footer-->


@section('js-page','/js/pages/public/items.js')
@section('js-script','/js/script.js')
@endsection
