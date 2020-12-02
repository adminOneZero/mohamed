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
			@endif

			<div class="col-3 col-m-6 col-sm-6">
				<div class="counter bg-success">
					<p>
						<i class="fas fa-check-circle"></i>
					</p>
					<h3>100+</h3>
					<p>مكتمل</p>
				</div>
			</div>
			<div class="col-3 col-m-6 col-sm-6">
				<div class="counter bg-danger">
					<p>
						<i class="fas fa-bug"></i>
					</p>
					<h3>100+</h3>
					<p>مسائل</p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-8 col-m-12 col-sm-12">
				<div class="card">
					<div class="card-header">
						<h3>
							جدول
						</h3>
						<i class="fas fa-ellipsis-h"></i>
					</div>
					<div class="card-content">
						<table>
							<thead>
								<tr>
									<th>#</th>
									<th>مشروع</th>
									<th>مدير</th>
									<th>الحالة</th>
									<th>البيانات </th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>1</td>
									<td>المشروع 1</td>
									<td>مدير1</td>
									<td>
										<span class="dot">
											<i class="bg-success"></i>
											مكتمل
										</span>
									</td>
									<td>17/07/2020</td>
								</tr>
								<tr>
									<td>2</td>
									<td>مشورع2</td>
									<td>مدير2</td>
									<td>
										<span class="dot">
											<i class="bg-warning"></i>
											متقدم
										</span>
									</td>
									<td>18/07/2020</td>
								</tr>
								<tr>
									<td>3</td>
									<td>مشروع3</td>
									<td>مدير3</td>
									<td>
										<span class="dot">
											<i class="bg-warning"></i>
											متفدم
										</span>
									</td>
									<td>17/07/2020</td>
								</tr>
								<tr>
									<td>4</td>
									<td>مشورع 4</td>
									<td>مدير4</td>
									<td>
										<span class="dot">
											<i class="bg-danger"></i>
											متأخر
										</span>
									</td>
									<td>07/07/2020</td>
								</tr>
								<tr>
									<td>5</td>
									<td>مشروع5</td>
									<td>مدير5</td>
									<td>
										<span class="dot">
											<i class="bg-primary"></i>
											متقدم
										</span>
									</td>
									<td>20/08/2020</td>
								</tr>
								<tr>
									<td>6</td>
									<td>مشورع 6</td>
									<td>مدير6</td>
									<td>
										<span class="dot">
											<i class="bg-primary"></i>
											متقدم
										</span>
									</td>
									<td>20/08/2020</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-4 col-m-12 col-sm-12">
				<div class="card">
					<div class="card-header">
						<h3>
							شريط التقدم
						</h3>
						<i class="fas fa-ellipsis-h"></i>
					</div>
					<div class="card-content">
						<div class="progress-wrapper">
							<p>
								ساعة واحدة
								<span class="float-left">50%</span>
							</p>
							<div class="progress">
								<div class="bg-one" style="width: 50%"></div>
							</div>
						</div>
						<div class="progress-wrapper">
							<p>
								ساعة واحدة
								<span class="float-left">60%</span>
							</p>
							<div class="progress">
								<div class="bg-tow" style="width:60%"></div>
							</div>
						</div>
						<div class="progress-wrapper">
							<p>
								ساعة واحدة
								<span class="float-left">40%</span>
							</p>
							<div class="progress">
								<div class="bg-three" style="width:40%"></div>
							</div>
						</div>
						<div class="progress-wrapper">
							<p>
								ساعة واحدة
								<span class="float-left">20%</span>
							</p>
							<div class="progress">
								<div class="bg-four" style="width:20%"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12 col-m-12 col-sm-12">
				<div class="card">
					<div class="card-header">
						<h3>
							رسم بياني
						</h3>
					</div>
					<div class="card-content">
						<canvas id="myChart"></canvas>
					</div>
				</div>
			</div>
		</div>
@endsection