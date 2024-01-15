@extends('front.layouts.app')
@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Meal Details of {{ Carbon\Carbon::now()->subMonth()->format('F Y') }} </h1>
            </div>
        </div>
        
    </div>
</section>
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">

        <div class="card">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Morning Meal</th>
                            <th>Lunch Meal</th>
                            <th>Dinner Meal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($meal->isNotEmpty())
                        @foreach($meal as $index => $meals)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $meals->created_at->format('Y-m-d') }}</td>
                            <td>{{ $meals->moring_meal }}</td>
                            <td>{{ $meals->lunch_meal }}</td>
                            <td>{{ $meals->dinner_meal }}</td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            
            <div class="card-footer clearfix">
            {{ $meal->links() }}
            </div>
        </div>
        <h5>Last Month Total Meal={{ number_format($totalLastMonthMeals,2) }}</h5>
    </div>
    <!-- /.card -->
</section>
@endsection