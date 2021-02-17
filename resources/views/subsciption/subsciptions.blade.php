@extends('layouts.public')

@section('body')
<section class="section-subscrip text-center">
    <div class="container">
        @if (Auth::check())
            @php
                $subRquStatus = DB::table('subscriptionRequests')->where("user_id","=",Auth::user()->id)->count() == 0 ? "" : DB::table('subscriptionRequests')->where("user_id","=",Auth::user()->id)->first()->status 
                @endphp
        @endif
        
        @if (Auth::user()->account_type == "seller" && $subRquStatus == 0)
        
            <h2>باقات الاشتراك الشهري</h2>
            <p>اختر الباقة الأنسب</p>

            <div class="row">
            <div class="col-sm-4 col-12">
                <div class="box">
                    <div class="head-bouquet">
                        <h3> الباقة الذهبيه <i class="fas fa-money-bill-wave mr-1"></i></h3>
                        <p style="background-color: #fdc500;color:#000;">$100</p>
                    </div>
                    <div class="content-bouquet ">
                        <h5><i class="fas fa-check"></i>يمكنك اضافه 12 صنف</h5>
                        <h5><i class="fas fa-check"></i></h5>
                        <h5><i class="fas fa-check"></i></h5>
                        <form action="/subscribe/plan" method="post">
                            @csrf
                            <button style="background-color: #fdc500;color:#000;" type="submit"><i class="fas fa-arrow-circle-right ml-1"></i>موافق </button>
                            <input type="hidden" name="plan" value="12">
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-sm-4 col-12">
                <div class="box">
                    <div class="head-bouquet">
                        <h3>الباقة الفضيه <i class="fas fa-money-bill-wave"></i></h3>
                        <p style="background-color: #f0efeb;color:#000;">$50</p>
                    </div>
                    <div class="content-bouquet ">
                        <h5><i class="fas fa-check"></i>يمكنك اضافه 5 اصناف</h5>
                        <h5><i class="fas fa-check"></i></h5>
                        <h5><i class="fas fa-check"></i></h5>
                        <form action="/subscribe/plan" method="post">
                            @csrf
                            <button style="background-color: #f0efeb;color:#000" type="submit"><i class="fas fa-arrow-circle-right ml-1"></i>موافق </button>
                            <input type="hidden" name="plan" value="5">
                        </form>
                    </div>
                </div>
            </div>
            
            
                        <div class="col-sm-4 col-12">
                            <div class="box">
                                <div class="head-bouquet">
                                    <h3> الباقة البرونزيه<i class="fas fa-money-bill-wave"></i></h3>
                                    <p style="background-color: rgb(198, 134, 100);color:#fff;">$30</p>
                                </div>
                                <div class="content-bouquet ">
                                    <h5><i class="fas fa-check"></i>يمكنك اضافه صنفين</h5>
                                    <h5><i class="fas fa-check"></i></h5>
                                    <h5><i class="fas fa-check"></i></h5>
                                    <form action="/subscribe/plan" method="post">
                                        @csrf
                                        <button style="background-color: rgb(198, 134, 100);color:#fff;" type="submit"><i class="fas fa-arrow-circle-right ml-1"></i>موافق </button>
                                        <input type="hidden" name="plan" value="2">
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                    </div>
        @endif

                @if (Auth::user()->account_type != "seller")
                
                <h1 class="text-center">الباقات للبائعين فقط</h1>
                @endif
                
                @if ($subRquStatus == 1)
                    <h1>سيتم الاتصال بك لتفعيل الباقه في اقرب وقت</h1>
                @endif
        
    </div>
</section>
@endsection