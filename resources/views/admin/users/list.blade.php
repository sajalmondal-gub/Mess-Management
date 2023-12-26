@extends('admin.layouts.app')
@section('content')
@include('admin.message')
<div class="card border-0">

    <div class="card-body table-responsive p-0">
        <table class="table  table-hover text-nowrap">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th width="100">Action</th>
                </tr>
            </thead>
            <tbody>
                @if($users->isNotEmpty())
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>
                   <a href=""  onclick="deleteCategory({{ $user->id }})"><i class="fa fa-trash" aria-hidden="true"></i></a>
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('customJs')
<script>
	function deleteCategory(id){
		var url='{{ route("users.delete","ID") }}';
		var newUrl = url.replace("ID",id)
		if (confirm("Are you sure. you want to delete")) {
			$.ajax({
				url: newUrl,
				type: 'delete',
				data: {},
				dataType: 'json',
				headers: {
					      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				         },
				success: function(response){
					if (response["status"]==true) {
						window.location.href="{{ route('users.index') }}";
					}
				}	
		   });	
		}	
	}
</script>
@endsection