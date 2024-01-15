@extends('front.layouts.app')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Dear {{ $users->name }} your Dashboard.</h1>
            </div>
            <div class="col-sm-6">
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 col-6">
                <div class="small-box card">
                    <div class="inner">
                        <h5> <strong>TK.{{ number_format($toatlcostthisMonth,2)}}</strong></h5>
                        <p>Total Cost Last Month</p>
                    </div>

                </div>
            </div>
            <div class="col-lg-4 col-6">
                <div class="small-box card">
                    <div class="inner">
                        <h5><strong>{{ number_format($totalMeals,2) }}</strong></h5>
                        <p>Total Meals</p>
                    </div>

                </div>
            </div>

            <div class="col-lg-4 col-6">
                <div class="small-box card">
                    <div class="inner">
                        <h5><strong>{{ $totalmessmeMber }}</strong></h5>
                        <p>Total Mess Member</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-6">
                <div class="small-box card">
                    <div class="inner">
                        <h5><strong>TK.{{ number_format($mealRate,2) }}</strong></h5>
                        <p>Meal Rates</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-6">
                <div class="small-box card">
                    <div class="inner">
                        <h5><strong>TK.{{ number_format($lastMonthMealCost,2) }}</strong></h5>
                        <p>Your Last Month Total Meal Cost</p>
                    </div>
                </div>
            </div>

            @if($due < 0) <div class="col-lg-4 col-6">
                <div class="small-box card">
                    <div class="inner">
                        <h5><strong>TK.{{ number_format($due,2) }}</strong></h5>
                        <p>Your Last Month Due</p>
                    </div>
                </div>
        </div>
        @elseif($due > 0)
        <div class="col-lg-4 col-6">
            <div class="small-box card">
                <div class="inner">
                    @elseif($due > 0)
                    <h5><strong>TK.{{ number_format($due,2) }}</strong></h5>
                    <p>Last Month You Receivable</p>

                </div>
            </div>
        </div>
        @endif

        <div class="col-lg-4 col-6">
            <div class="small-box card">
                <div class="inner">
                    <h5><strong>TK.{{ number_format($totalLastMonthMeals,2) }}</strong></h5>
                    <p>Your Last Month Total Meal</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="{{ route('account.meals') }}" class="small-box-footer text-dark">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-4 col-6">
            <div class="small-box card">
                <div class="inner">
                    <h5><strong>TK.{{ number_format($totalAmountLastMonth,2) }}</strong></h5>
                    <p>Your Last Month Total Deposite</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="{{ route('account.deposite') }}" class="small-box-footer text-dark">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
</section>
@endsection