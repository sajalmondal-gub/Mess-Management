@extends('admin.layouts.app')
@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Details of {{ Carbon\Carbon::now()->subMonth()->format('F Y') }} Month </h1>
            </div>
        </div>
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        @include('admin.message')
        <div class="card">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th width="60">#</th>
                            <th>Name</th>
                            <th>Total Deposit(TK.)</th>
                            <th>Total Meal</th>
                            <th>Total Amount(TK.)</th>
                            <th>Due(TK.)</th>
                            <th>Receivable(TK.)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($userSums->isNotEmpty() || $usermeals->isNotEmpty())
                        @foreach($userSums as $userSum)
                        @php
                        // Find the corresponding usermeal for the current userSum
                        $usermeal = $usermeals->where('user_id', $userSum->user_id)->first();
                        $user = $users->where('id', $userSum->user_id)->first();
                        $morningSum = optional($usermeal)->moring_sum ?? 0;
                        $lunchSum = optional($usermeal)->lunch_sum ?? 0;
                        $dinnerSum = optional($usermeal)->dinner_sum ?? 0;
                        $due = $userSum->total_amount - ($morningSum + $lunchSum + $dinnerSum) * $lastmonthmealtrate;
                        @endphp
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $userSum->total_amount }}</td>
                            <td>{{ number_format(optional($usermeal)->moring_sum + optional($usermeal)->lunch_sum +
                                optional($usermeal)->dinner_sum, 2) }}</td>
                            <td>{{ number_format((optional($usermeal)->moring_sum + optional($usermeal)->lunch_sum +
                                optional($usermeal)->dinner_sum)*$lastmonthmealtrate, 2) }}</td>
                            @if($due<=0) <td>{{ abs($due) }}</td>
                                @else
                                <td>0</td>
                                @endif
                                @if($due>=0)
                                <td>{{ $due }}</td>
                                @else
                                <td>0</td>
                                @endif
                        </tr>

                        @endforeach
                        @else
                        <tr>
                            <td colspan="7">Records Not Found</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">

            </div>
        </div>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection
@section('customJs')
<script>
</script>
@endsection