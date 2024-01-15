@extends('admin.layouts.app')
@section('content')
<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Manager Dashboard</h1>
			</div>
			<div class="col-sm-6">
			</div>
		</div>
	</div>
	<!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
	<!-- Default box -->
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-4 col-6">
				<div class="small-box card">
					<div class="inner">
						<h3>TK.{{ $toatlcostthisMonth }}</h3>
						<p>Total Cost This Month</p>
					</div>
					<div class="icon">
						<i class="ion ion-bag"></i>
					</div>
					<a href="{{ route('deposite.index') }}" class="small-box-footer text-dark">More info <i
							class="fas fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<div class="col-lg-4 col-6">
				<div class="small-box card">
					<div class="inner">
						<h3>{{ number_format($totalMeals,2) }}</h3>
						<p>Total Meals</p>
					</div>
					<div class="icon">
						<i class="ion ion-stats-bars"></i>
					</div>
					<a href="{{ route('meal.index') }}" class="small-box-footer text-dark">More info <i
							class="fas fa-arrow-circle-right"></i></a>
				</div>
			</div>

			<div class="col-lg-4 col-6">
				<div class="small-box card">
					<div class="inner">
						<h3>{{ $totalmessmeMber }} </h3>
						<p>Total Mess Member</p>
					</div>
					<div class="icon">
						<i class="ion ion-stats-bars"></i>
					</div>
					<a href="{{ route('users.index') }}" class="small-box-footer text-dark">More info <i
							class="fas fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<div class="col-lg-4 col-6">
				<div class="small-box card">
					<div class="inner">
						<h3>TK.{{ number_format($mealRate,3) }}</h3>
						<p>Meal Rates</p>
					</div>
					<div class="icon">
						<i class="ion ion-person-add"></i>
					</div>
					<a href="javascript:void(0);" class="small-box-footer">&nbsp;</a>
				</div>
			</div>
			<div class="col-lg-4 col-6">
				<div class="small-box card">
					<div class="inner">
						<h3>TK.</h3>
						<p>See individual Details</p>
					</div>
					<div class="icon">
						<i class="ion ion-person-add"></i>
					</div>
					<a href="{{ route('lastmonth.details') }}" class="small-box-footer text-dark">More info <i
							class="fas fa-arrow-circle-right"></i></a>
				</div>
			</div>

		</div>
	</div>
	<!-- /.card -->
</section>
<!-- /.content -->
@endsection
@section('customJs')
@endsection