@extends('admin.layouts.app')
@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Deposite Money</h1>
            </div>
            <div class="col-sm-6 text-right">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                    Add Money
                </button>
                <!-- Modal -->
                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Add Money</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-left">
                                <form action="" method="post" id="AddDeposite" name="AddDeposite">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="col-mb-3">
                                                        <label for="user">Name</label>
                                                        <select name="user" id="user" class="form-control">
                                                            <option value="">Select a Name</option>
                                                            @if($users->isNotEmpty())
                                                            @foreach($users as $user)
                                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                        <p></p>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="amount">Amount</label>
                                                        <input type="text" name="amount" id="amount"
                                                            placeholder="Amount" class="form-control">
                                                        <p></p>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="date">Date</label>
                                                        <input autocomplete="off" type="date" name="date" id="date"
                                                            class="form-control">
                                                        <p></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Add</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
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
                            <th width="60">ID</th>
                            <th>Name</th>
                            <th>Amount</th>
                            <th>Deposite Date</th>
                            <th width="100">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($deposites->isNotEmpty())
                        @foreach($deposites as $deposite)
                        <tr>
                            <td>{{ $deposite->id }}</td>
                            <td>{{ $deposite->user->name }}</td>
                            <td>{{ $deposite->amount }}</td>
                            <td>{{ \Carbon\Carbon::parse($deposite->date)->format('d-m-Y') }}</td>
                            <td>
                                <a href="" onclick="DeleteDeposties({{ $deposite->id }})"
                                    class="text-danger w-4 h-4 mr-1">
                                    <svg wire:loading.remove.delay="" wire:target=""
                                        class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path ath fill-rule="evenodd"
                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="5">Records Not Found</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                {{ $deposites->links() }}
            </div>
        </div>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection
@section('customJs')
<script>
    $("#AddDeposite").submit(function (even) {
        event.preventDefault();
        var element = $(this);
        $("button[type='submit']").prop('disabled', true);
        $.ajax({
            url: '{{ route("deposite.store") }}',
            type: 'post',
            data: element.serializeArray(),
            dataType: 'json',
            success: function (response) {
                $("button[type='submit']").prop('disabled', false);
                if (response["status"] == true) {

                    $('#user').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                    $('#amount').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                    $('#date').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                    window.location.href = "{{ route('deposite.index') }}";
                } else {
                    var errors = response['errors'];
                    if (errors['user']) {
                        $("#user").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['user']);
                    } else {
                        $("#user").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                    }
                    if (errors['amount']) {
                        $("#amount").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['amount']);
                    } else {
                        $("#amount").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                    }
                    if (errors['date']) {
                        $("#date").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['date']);
                    } else {
                        $("#date").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                    }
                }
            }
        });
    });
    function DeleteDeposties(id) {
        var url = '{{ route("deposite.delete","ID") }}';
        var newUrl = url.replace("ID", id);

        if (confirm("Are you sure. you want to delete")) {
            $.ajax({
                url: newUrl,
                type: 'delete',
                data: {},
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                }
            });
        }
    }

    //search
</script>
@endsection