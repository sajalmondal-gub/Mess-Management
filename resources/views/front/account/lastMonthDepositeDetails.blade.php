@extends('front.layouts.app')
@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Deposite Details of {{ Carbon\Carbon::now()->subMonth()->format('F Y') }} </h1>
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
                            <th>Amount (TK.)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($deposite->isNotEmpty())
                        @foreach($deposite as  $index=>$deposites)
                        <tr>
                            <td>{{ $index+1 }}</td>
                            <td>{{ $deposites->created_at->format('Y-m-d') }}</td>
                            <td>{{ $deposites->amount }}</td>
                        </tr>
                       @endforeach
                       @endif
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
              {{ $deposite->links() }}
            </div>
        </div>
        <h5>Last Month Total Deposite={{ number_format($totalDeposite) }}TK.</h5>
    </div>
    <!-- /.card -->
</section>
@endsection