@extends('layouts.public')

@section('body')


<!--Start porducer-->

<section class='porducer'>
    <div class="container">
        <div class="row">

            <div class="col-12 porducer-me">
                <!--Start box-one-->
                <div class="porducer-me-box box-one">
                    {{-- {{ dd($items) }} --}}
                    @php
                        $allPrice = 0;
                        $count = 0;
                        foreach ($items as $item) {
                            $allPrice = $allPrice + ($item->price * $item->quantity);
                            $count++;
                        }
                    @endphp

                    <div class="row">
                        
                        @if (DB::table('basket')->where('buyer_id',Auth::user()->id)->count() > 0)
                        
                        <div class="basket-ba tooles-button text-center ">
                            {{-- <span>{{ $allPrice }}</span> --}}
                            <form action="/basket/clear" method="POST" style="display: inline-block">
                                @csrf
                                <button type="submit" class="clear">تنظيف العربه</button>
                            </form>
                            <form id="buyBtnForm" action="/basket/buy" onsubmit="" method="POST" style="display: inline-block">
                                @csrf
                                <button type="button" 
                                id="buyBtn"
                                data-question="ask this q" 
                                class="buy ask">شراء</button>
                            </form>

                            <div class="sub-total">
                                <span class="total-car"><label> اجمالي السلة : </label> <span>${{ $allPrice }}</span></span><span style="color: aliceblue">+</span>
                                <span class="total-shiping"><label>  تكلفة الشحن : </label><span>${{ $count * config('conf.shippingMoney') }}</span></span>
                            </div>
                        </div>

                        

                        @endif

                        @foreach ($items as $item)
                        <div class="col-md-4 col-sm-6  col-12">
                            <div class="box">
                                <div class='img-me'>
                                    <div class="overlay"></div>
                                    <a href="/item/{{ $item->item_id }}"><img src="{{ $item->image1 }}"  alt="gomla-dresses-wideings"></a>
                                    <button class="addToWishList far fa-heart" data-item_id="{{ $item->id }}"></button>
                                </div>
                                <div class="show-button">
                                    <span class="float-right">${{ $item->price }}</span>
                                    <button id="edit__id__{{ $item->id }}" class="edit_basket" data-quantity="{{ $item->quantity }}" style="margin-top:5px;" data-item_id="{{ $item->id }}"><i class="fa fa-list"></i></button>
                                    {{-- <span id="quantity__id__{{ $item->id }}" class="float-right"> الكميه : {{ $item->quantity }}</span> --}}
                                </div>
                            </div>
                        </div>
                        
                        @endforeach
                         

                    </div>
                </div>
                <!--End box-one-->
                
                {{-- modal --}}
                <div id="modal" class="basketQuantityModal iziModal" aria-hidden="true" aria-labelledby="modal" role="dialog">
                    <div class="iziModal-wrap">
                        <div class="iziModal-wrap" style="height: 214px;">
                            <div class="iziModal-content" style="padding: 0px;">
                                <h5 class="header border-bottom-1 text-center">معلومات العنصر</h5>
                                <p>المخزون : <span id="storeQuantity">3</span></p>
                                <p>اللون : <span id="itemColor">Red</span></p>
                                <p>الحجم : <span id="itemSize">X</span></p>
                                <p>الكميه المطلوبه : <span id="itemQuantity">1</span></p>
                                
                                <div>
                                    <h5 class="header text-center">تعديل العنصر</h5>
                                    <h6>الكميه</h6>
                                    <input value="" id="quantity" type="number" onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57">
                                </div>
                                <div>
                                    <h6>اللون</h6>
                                    <select name="color" id="colorsOprions"><option value="Red">Red</option></select>
            
                                </div>
                                <div>
                                    <h6>الحجم</h6>
                                    <select name="size" id="sizeOprions">
                                        <option selected="" value="X">X</option>
                                        <option value="XL">XL</option>
                                    </select>
            
                                </div>
                                <button data-item_id="10" class="btn btn-success mb-2" id="updateQU">تحديث</button>
                            </div>
                        </div>
            
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>


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
    </div>
</footer>
<!--End footer-->


@section('js-page','/js/pages/public/basket.js')
@section('js-page2','/js/pages/public/items.js')

@endsection
