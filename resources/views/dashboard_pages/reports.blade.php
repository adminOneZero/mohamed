@extends('layouts.dashboard')

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
			@endif

			
		</div>
		
		
@endsection