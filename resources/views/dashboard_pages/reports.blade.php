@extends('layouts.dashboard')
@section('dashboard-reports','active')

@section('body')
    
		<div class="row">


			@if (Auth::user()->account_type == 'admin')
				
			<div class="col-3 col-m-6 col-sm-6">
				<div class="counter bg-primary">
					<p>
						<i class="fas fa-users"></i>
					</p>
					<h3>{{ DB::table('users')->where('account_type','!=','admin')->count() }}</h3>
					<p>عدد المستخدمين</p>
				</div>
			</div>

			<div class="col-3 col-m-6 col-sm-6">
				<div class="counter bg-warning">
					<p>
						<i class="fas fa-box"></i>
					</p>
					<h3>{{ DB::table('Items')->count() }}</h3>
					<p>عدد المنتجات</p>
				</div>
			</div>

			<div class="col-3 col-m-6 col-sm-6">
				<div class="counter bg-warning">
					<p>
						<i class="fas fa-box"></i>
					</p>
					<h3>{{ DB::table('orders')->where('status','تم التسليم')->count() }}</h3>
					<p>تم التسليم</p>
				</div>
			</div>

			<div class="col-3 col-m-6 col-sm-6">
				<div class="counter bg-warning">
					<p>
						<i class="fas fa-box"></i>
					</p>
					<h3>{{ DB::table('orders')->where('status','الشحن')->count() }}</h3>
					<p>تم الشحن</p>
				</div>
			</div>

			<div class="col-3 col-m-6 col-sm-6">
				<div class="counter bg-warning">
					<p>
						<i class="fas fa-box"></i>
					</p>
					<h3>{{ DB::table('Items')
						->where('seller_id','=',Auth::user()->id)
						->where('storeQuantity','<=',config('conf.almost_done_items'))
						->count() }}</h3>
					<p>منتجات اوشكت على الانتهاء</p>
				</div>
			</div>

			<div class="col-3 col-m-6 col-sm-6">
				<div class="counter bg-warning">
					<p>
						<i class="fas fa-box"></i>
					</p>
					<h3>{{ DB::table('Items')
						->where('seller_id','=',Auth::user()->id)
						->where('storeQuantity','<=',0)
						->count() }}</h3>
					<p>منتجات انتهت</p>
				</div>
			</div>
			@endif


			@if (Auth::user()->account_type == 'marketer')

			@php
				if(DB::table('marketers_wallet')->where('marketer_id','=',Auth::user()->id)->count() == 1){
					$wallet = DB::table('marketers_wallet')->where('marketer_id','=',Auth::user()->id)->pluck('wallet')[0];
				}else{
					$wallet = 0;
				}
			@endphp

			<div class="col-3 col-m-6 col-sm-6">
				<div class="counter bg-warning">
					<p>
						<i class="fas fa-wallet"></i>
					</p>
					<h3>{{ $wallet }}</h3>
					<p>المحفظه</p>
				</div>
			</div>
			
			<div class="col-3 col-m-6 col-sm-6">
				<div class="counter bg-warning">
					<p>
						<i class="fas fa-box"></i>
					</p>
					<h3>{{ DB::table('orders')->where('status','تم التسليم')->where('buyer_id','=',Auth::user()->id)->count() }}</h3>
					<p>الطلبات المستلمه</p>
				</div>
			</div>


			<div class="col-3 col-m-6 col-sm-6">
				<div class="counter bg-warning">
					<p>
						<i class="fas fa-box"></i>
					</p>
					<h3>{{ DB::table('orders')->where('status','!=','تم التسليم')->where('buyer_id','=',Auth::user()->id)->count() }}</h3>
					<p>طلبات قيد الشحن</p>
				</div>
			</div>

			{{-- <div class="col-3 col-m-6 col-sm-6">
				<div class="counter bg-warning">
					<p>
						<i class="fas fa-box"></i>
					</p>
					<h3>{{ DB::table('orders')->where('status','الشحن')->where('buyer_id','=',Auth::user()->id)->count() }}</h3>
					<p>تم الشحن</p>
				</div>
			</div> --}}
			@endif
			
		</div>
		
		
@endsection