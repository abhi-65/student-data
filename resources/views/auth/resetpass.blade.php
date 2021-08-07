@extends('template')

@section('head')
<link rel="stylesheet" href="{{asset('login.css')}}" crossorigin="anonymous">

@endsection
@section('content')
<form action="{{route('reset-password')}}" method="post" onsubmit="return validate(this);">
	@csrf
	@if(Session::has('message'))
		<h3 class="text-danger">{{Session::get('message')}}</h3>
		{{Session::forget('message')}}
	@endif
	<div class="col-lg-6">
	    <div class="card2 card border-0 px-4 py-5">
	    	<input type="hidden" name="id" value="{{$checkUser->id}}">
	        <div class="row px-3"> 
	        	<label class="mb-1">
	                <h6 class="mb-0 text-sm">New Password</h6>
	            </label>
	            <input type="password" name="password" id="password" placeholder="Enter password" class="req" minlength="6"> 
	            <span class="err text-danger">{{ $errors->first('password') }}</span>
	        </div>
	        <div class="row px-3"> 
	        	<label class="mb-1">
	                <h6 class="mb-0 text-sm">Confirm Password</h6>
	            </label>
	            <input type="password" name="newpassword" id="newpassword" placeholder="Confirm password" class="req" minlength="6"> 
	            <span class="err text-danger">{{ $errors->first('password') }}</span>
	        </div>
	        <div class="row mb-3 px-3"> <button type="submit" class="btn btn-blue text-center">Save</button> </div>
	    </div>
	</div>
</form>
@endsection

@section('scripts')

<script type="text/javascript">
	function validate(elem)
	{
		var count = 1;
		var flag = false;
		$('.req').each(function (){
			if($(this).val() == '')
			{
				$(this).parent().find('.err').text('This Field is required.');
				count = count + 1;
			}
			else
			{
				$(this).parent().find('.err').text('');
			}
		});
		if(count == 1)
		{
			if($('#password').val() != $('#newpassword').val())
			{
				$('#newpassword').parent().find('.err').text('Confirm password must be same as password');
				flag = false;
			}
			else
			{
				$('#newpassword').parent().find('.err').text('');
				flag = true;
			}
		}
		return flag;
	}
</script>
@endsection