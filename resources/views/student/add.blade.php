@extends('template')

@section('head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.min.css" integrity="sha512-rxThY3LYIfYsVCWPCW9dB0k+e3RZB39f23ylUYTEuZMDrN/vRqLdaCBo/FbvVT6uC2r0ObfPzotsfKF9Qc5W5g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="{{asset('login.css')}}" crossorigin="anonymous">

@endsection
@section('content')
<form action="{{route('save-student')}}" method="post" onsubmit="return validate(this);" enctype='multipart/form-data'>
	@csrf
	<input type="hidden" name="id" value="{{(isset($student) && !empty($student)) ? $student->id : ''}}">
	<div class="col-lg-6">
	    <div class="card2 card border-0 px-4 py-5">
	        <div class="row px-3"> 
	        	<label class="mb-1">
	                <h6 class="mb-0 text-sm">Name</h6>
	            </label> 
	            <input class="mb-1 req" type="text"  name="student_name" placeholder="Enter name" value="{{(isset($student) && !empty($student)) ? $student->student_name : old('student_name')}}"> 
	            <span class="err text-danger">{{ $errors->first('student_name') }}</span>
	        </div>
	        <div class="row px-3"> 
	        	<label class="mb-1">
	                <h6 class="mb-0 text-sm">Grade</h6>
	            </label> 
	            <input class="mb-1 req" type="text"  name="grade" placeholder="Enter grade" value="{{(isset($student) && !empty($student)) ? $student->grade : old('grade')}}" maxlength="5"> 
	            <span class="err text-danger">{{ $errors->first('grade') }}</span>
	        </div>
	        <div class="row px-3"> 
	        	<label class="mb-1">
	                <h6 class="mb-0 text-sm">Date of Birth</h6>
	            </label> 
				  <input placeholder="Select date" type="text" id="date_of_birth" name="date_of_birth" class="form-control req"  value="{{(isset($student) && !empty($student)) ? date('d-m-Y',strtotime($student->date_of_birth)) : old('date_of_birth')}}">
				  <span class="err text-danger">{{ $errors->first('date_of_birth') }}</span>
	        </div>
	        <div class="row px-3"> 
	        	<label class="mb-1">
	                <h6 class="mb-0 text-sm">Photo</h6>
	            </label>
	         @if(isset($student) && !empty($student) && !empty($student->photo))
	         <img src="{{asset('photo/student/'.$student->photo)}}" width="100px" height="100px">
	         @endif 
	         <input type="hidden" name="photo_name" id="photo_name" value="{{(isset($student) && !empty($student)) ? $student->photo : ''}}">
	        	<input type="file" class="form-control {{(isset($student) && !empty($student)) ? '' : 'req'}}" name="photo" id="photo">
	        	<span class="err text-danger">{{ $errors->first('photo') }}</span>
	        </div>
	        <div class="row px-3"> 
	        	<label class="mb-1">
	                <h6 class="mb-0 text-sm">Address</h6>
	            </label> 
	            <input class="mb-1 req" type="text"  name="address" placeholder="Enter address" value="{{(isset($student) && !empty($student)) ? $student->address : old('address')}}"> 
	            <span class="err text-danger">{{ $errors->first('address') }}</span>
	        </div>
	        <div class="row px-3"> 
	        	<label class="mb-1">
	                <h6 class="mb-0 text-sm">City</h6>
	            </label> 
	            <input class="mb-1 req" type="text"  name="city" placeholder="Enter city" value="{{(isset($student) && !empty($student)) ? $student->city : old('city')}}" maxlength="100"> 
	            <span class="err text-danger">{{ $errors->first('city') }}</span>
	        </div>
	        <div class="row px-3"> 
	        	<label class="mb-1">
	                <h6 class="mb-0 text-sm">Country</h6>
	            </label> 
	        	<select class="form-control req" name="country">
	        			<option value="1" @if(isset($student) && !empty($student) && $student->country == 1) selected @endif>India</option>
	        			<option value="2" @if(isset($student) && !empty($student) && $student->country == 2) selected @endif>USA</option>
	        			<option value="3" @if(isset($student) && !empty($student) && $student->country == 3) selected @endif>UK</option>	        		
	        	</select>
	        	<span class="err text-danger">{{ $errors->first('country') }}</span>
	        </div>
	        <br>
	        <br>
	        <div class="row mb-3 px-3"> <button type="submit" class="btn btn-blue text-center">Save</button> </div>
	    </div>
	</div>
</form>
@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">
	$('#date_of_birth').datepicker({
	    format: "dd-m-yyyy",
	    endDate: "yesterday"
	});
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
		//alert(count);
		if(count == 1)
		{
			if($('#photo_name').val() == '')
			{
				var fileObj =  $('#photo');
				var filePath = fileObj.val();
	          
	            // Allowing file type
	            var allowedExtensions = 
	                    /(\.jpg|\.jpeg|\.png)$/i;
	              //alert(filePath);
	            if (!allowedExtensions.exec(filePath)) {
	                $('#photo').parent().find('.err').text('Enter valid image file');
	                count = count + 1;
	            } 
					else
					{
						if(count != 1)
						{
							count = count - 1;
						}
						$('#photo').parent().find('.err').text('');
					}
			}
			

			if(count == 1)
			{
				flag = true;
			}
		}
		return flag;
	}
</script>
@endsection
