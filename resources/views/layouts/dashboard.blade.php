<!DOCTYPE html>
<html>
<head>
	<title>صفحة التحكم </title>
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
	<link rel="icon" type="image/png" href="/img/logo-2.png"/>

	<!-- Import lib -->
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
    <link  rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cairo|Oswald&display=swap">
    <link  rel="stylesheet" href="https://fonts.googleapis.com/css?family=Reem+Kufi&display=swap">
	<link rel="stylesheet" type="text/css" href="/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="/css/iziModal.min.css">
	<link rel="stylesheet" type="text/css" href="/css/iziToast.min.css">
	<link rel="stylesheet" type="text/css" href="/css/style-control.css">
	<link rel="stylesheet" type="text/css" href="/css/simplegrid.css">
	<!-- End import lib -->
	{{-- token --}}
	<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="overlay-scrollbar">
	<!-- navbar -->
	<div class="navbar">
		<!-- nav left -->
		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="nav-link">
					<i class="fas fa-bars" onclick="collapseSidebar()"></i>
				</a>
			</li>
			<li class="nav-item">
				<a href="/"><img src="/img/logo-2.png" alt="ATPro logo" class="logo logo-light"></a>
			</li>
		</ul>
		<!-- end nav left -->

		<!-- form -->
		<form class="navbar-search">
			{{-- <input type="text" name="Search" class="navbar-search-input" placeholder="ابحث هنا ....">
			<i class="fas fa-search"></i> --}}
		</form>
		<!-- end form -->
		@php
			$adminNotiCount = DB::table('Notifications')->where('group','=',"admin")->where('status','=','1')->count();
			// dd($adminNotiCount);
		@endphp
		<!-- nav right -->
		<ul class="navbar-nav nav-right">
			<li class="nav-item dropdown" >
				<a class="nav-link">
					<i class="fas fa-bell dropdown-toggle" data-toggle="notification-menu"></i>
					@if (Auth::user()->account_type == "admin")
						@if ($adminNotiCount > 0)
						<span id="notiAlert" class="navbar-badge">{{ $adminNotiCount }}</span>
						@endif
						
					@else
						@if (DB::table('Notifications')->where('group','!=',"admin")->where('status','=','1')->where('user_id','=',Auth::user()->id)->count() > 0)
						<span id="notiAlert" class="navbar-badge">{{ DB::table('Notifications')->where('group','!=',"admin")->where('status','=','1')->where('user_id','=',Auth::user()->id)->count() }}</span>
						@endif
					
						
					@endif
				</a>
				<ul id="notification-menu" class="dropdown-menu notification-menu" style="height: 500px;">
					<div class="dropdown-menu-header">
						<span>
							الإشعارات
						</span>
					</div>
					<div class="dropdown-menu-content overlay-scrollbar scrollbar-hover">
						<style>
							.active{
								background-color: aqua;
							}
						</style>
@if (Auth::user()->account_type == "admin")
	
@foreach (DB::table('Notifications')->where('group','=',Auth::user()->account_type)->orderBy('id', 'desc')->limit(100)->get() as $noti)
							
<li data-noti_id="{{ $noti->id }}" class="dropdown-menu-item seeStatus @if ($noti->status == 1) {{ 'active' }} @else {{ '' }} @endif">
	<a href="#" class="dropdown-menu-link">
		<div>
			<i class="fas fa-gift"></i>
		</div>
		<span>
			{{ $noti->message }}
			<br>
			<span>
				{{ $noti->time }}
			</span>
		</span>
	</a>
</li>
@endforeach
@endif


						@foreach (DB::table('Notifications')->where('user_id','=',Auth::user()->id)->where('group','!=',"admin")->orderBy('id', 'desc')->limit(100)->get() as $noti)
							
						<li data-noti_id="{{ $noti->id }}" class="dropdown-menu-item seeStatus @if ($noti->status == 1) {{ 'active' }} @else {{ '' }} @endif">
							<a href="#" class="dropdown-menu-link">
								<div>
									<i class="fas fa-gift"></i>
								</div>
								<span>
									{{ $noti->message }}
									<br>
									<span>
										{{ $noti->time }}
									</span>
								</span>
							</a>
						</li>
						@endforeach
						
					</div>
					<div class="dropdown-menu-footer">
						<form action="/dashboard/clearnoti" method="post">
							@csrf
							<input type="submit" class="btn-base btn1" value="الكل كمقروء">
						</form>
						{{-- <span>
							عرض كل الاشعارات
						</span> --}}
					</div>
				</ul>
			</li>
			<li class="nav-item avt-wrapper">
				<div class="avt dropdown">
					<img src="{{  Auth::user()->image  }}" alt="User image" class="dropdown-toggle" data-toggle="user-menu">
					<ul id="user-menu" class="dropdown-menu">
						<li  class="dropdown-menu-item">
							<a class="dropdown-menu-link" href="/dashboard/profile">
								<div>
									<i class="fas fa-user-tie"></i>
								</div>
								<span> {{ Auth::user()->name }}</span>
							</a>
						</li>
						{{-- <li class="dropdown-menu-item">
							<a href="#" class="dropdown-menu-link">
								<div>
									<i class="fas fa-cog"></i>
								</div>
								<span>الإعدادت</span>
							</a>
						</li> --}}
						
						<li  class="dropdown-menu-item">
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                  <!-- <a href="/logout" class="dropdown-menu-link"> -->
                  <a class="dropdown-menu-link" href="{{ route('logout') }}"
                  onclick="event.preventDefault(); this.closest('form').submit();">
              </form>
								<div>
									<i class="fas fa-sign-out-alt"></i>
								</div>
								<span>خروج</span>
							</a>
						</li>
					</ul>
				</div>
			</li>
		</ul>
		<!-- end nav right -->
	</div>
	<!-- end navbar -->

	<!-- sidebar -->
	<div class="sidebar">
		<ul class="sidebar-nav">
			<li class="sidebar-nav-item">
				<a href="/dashboard" class="sidebar-nav-link @yield('dashboard-reports')">
					<div>
						<i class="fas fa-tachometer-alt"></i>
					</div>
					<span>
						لوحه التحكم
					</span>
				</a>
			</li>
			@if (Auth::user()->account_type == 'admin')
				
			<li  class="sidebar-nav-item">
				<a href="/dashboard/users" class="sidebar-nav-link @yield('active-users')">
					<div>
						<i class="fas fa-users"></i>
					</div>
					<span>ادارة المستخدمين</span>
				</a>
			</li>

			<li  class="sidebar-nav-item">
				<a href="/dashboard/manage-orders" class="sidebar-nav-link @yield('active-mange_orders')">
					<div>
						<i class="fas fa-list"></i>
					</div>
					<span>ادارة الطلبات</span>
				</a>
			</li>
			
			@endif
			
			@if (Auth::user()->account_type == 'admin' || Auth::user()->account_type == 'seller')
				
			<li class="sidebar-nav-item">
				<a href="/dashboard/seller/dresses" class="sidebar-nav-link @yield('active-dresses')">
					<div>
						<i class="fas fa-female"></i>
					</div>
					<span>الفساتين</span>
				</a>
			</li>
			@endif
			
			<li  class="sidebar-nav-item">
				<a href="/dashboard/myorders" class="sidebar-nav-link @yield('myorders')">
					<div>
						<i class="fas fa-shopping-cart"></i>
					</div>
					<span> طلباتي </span>
				</a>
			</li>

			<li  class="sidebar-nav-item">
				<a href="/dashboard/receivied-orders" class="sidebar-nav-link @yield('active-receivied_order')">
					<div>
						<i class="fas fa-shopping-basket"></i>
					</div>
					<span> تم الشراء </span>
				</a>
			</li>
			@if (Auth::user()->account_type == 'seller')
			<li  class="sidebar-nav-item">
				<a href="/subscription" class="sidebar-nav-link @yield('subscription')">
					<div>
						<i class="fas fa-file-signature"></i>
					</div>
					<span> الباقه الشهريه </span>
				</a>
			</li>
				
			@endif

			@if (Auth::user()->account_type == 'marketer')
			<li  class="sidebar-nav-item">
				<a href="/payments" class="sidebar-nav-link @yield('payments')">
					<div>
						<i class="fas fa-dollar-sign"></i>
					</div>
					<span> الدفعات الماليه </span>
				</a>
			</li>
				
			@endif

		</ul>
	</div>
	<!-- end sidebar -->

	<!-- main content -->
	<div class="wrapper">
		@yield('body')
	</div>
	<!-- end main content -->
	<!-- import script -->
	{{-- <script src="/https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script> --}}
	<script src="/js/jQuery-min.js"></script>
	<script src="/js/iziModal.min.js"></script>
	<script src="/js/iziToast.js"></script>
	<script src="/js/control.js"></script>
	<script src="/js/notify-sys.js"></script>
	<script src="/js/dashboard.js"></script>
	<script src="@yield('js-page')"></script>
	@include('vendor.lara-izitoast.toast')


	<!-- end import script -->
</body>
</html>
