@extends('template')

@section('head')
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
@endsection
@section('content')
<h1>Hello</h1>
<table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Image</th>
                <th>Name</th>
                <th>Grade</th>
                <th>Date of birth</th>
                <th>Address</th>
                <th>City</th>
                <th>Country</th>
                <th width="100px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
  $(function () {
    
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('index') }}",
        columns: [
            {data: 'id', name: 'id'},
            { "data":"photo",render:function(data, type, row){
                if(data != null){
                  data = '{{ asset("photo/student") }}/'+data;
                  $html = '<img src="'+data+'" alt="photo" width="50px;heigh:50px;">';
                }else{
                  $html = '-';
                }

                
                return $html;
              },
              "searchable": false, "orderable": false,
            },
            {data: 'student_name', name: 'student_name','orderable': true},
            {data: 'grade', name: 'grade','orderable': true},
            { "data":"date_of_birth",
              render:function(data, type, row){
                return moment(data).format('MM/DD/GGGG');
              },
              "searchable": false, "orderable": true,
            },
            {data: 'address', name: 'address'},
            {data: 'city', name: 'city','orderable': true},
            { "data":"country",render:function(data, type, row){
                if(data == 1){
                  return 'India';
                }
                else if(data == 2){
                  return 'USA';
                }
                else if(data == 3){
                  return 'UK';
                }
                else
                {
                  return '-';
                }
              },
              "searchable": false, "orderable": false,
            },
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    
  });
</script>
@endsection