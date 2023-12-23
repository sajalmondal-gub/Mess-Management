@if(Session::has('error'))

<div class="alert alert-danger alert-dismissible p-2">   
     {{ Session::get('error') }}
</div>
@endif
@if(Session::has('success'))
<div class="alert alert-success alert-dismissible" p-2>
   {{ Session::get('success') }}
</div>
@enderror