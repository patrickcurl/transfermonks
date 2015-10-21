@extends('transfer.frontend')
@section('breadcrumb')
Facebook Registration
@endsection
@section('content')
  <center><h2>Signup with Facebook</h2></center>
  @if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
  <p>User: {{$fbuser['id']}}
  <div class="col-sm-12 col-md-6">
  <form class="form-horizontal" method="post" action="{{ url('/facebook/register') }}">
   {!! csrf_field() !!}
   <input type="hidden" name="facebook_id" value="{{$fbuser['id']}}">
   <input type="hidden" name="facebook_token" value="{{$fbuser['token'] }}">
   <input type="hidden" name="email" value="{{$fbuser['email'] }}">
   <input type="hidden" name="first_name" value="{{ $fbuser['first_name'] }}">
   <input type="hidden" name="last_name" value="{{ $fbuser['last_name'] }}"
  <div class="form-group">
    <label for="password" class="col-sm-2 control-label">Password</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" name="password" id="password" placeholder="Password">
    </div>
  </div>
  <div class="form-group">
    <label for="password_confirmation" class="col-sm-2 control-label">Password Confirmation</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Password Confirmation">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">Sign Up</button>
    </div>
  </div>
</form>
</div>
<div class="col-md-6">
	<ul class="fa-ul" style="color:#000000;">
	  <li style="padding:5px;"><i class="fa-li fa fa-check-square-o fa-2x"></i>No worry, no fuss script migrations.</li>
	  <li style="padding:5px;"><i class="fa-li fa fa-check-square-o fa-2x"></i>All scripts supported.</li>
	  <li style="padding:5px;"><i class="fa-li fa fa-check-square-o fa-2x"></i>If we can't move it - you don't pay!</li>
	  <li style="padding:5px;"><i class="fa-li fa fa-check-square-o fa-2x"></i>Most affordable option out there!</li>
	</ul>
</div>

@endsection