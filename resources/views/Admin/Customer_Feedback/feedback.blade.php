@extends('Admin.master')
  @section('title')

  Customer Feedback
 @endsection
@section('content')


  <div class="card my-2">
    <div class="card-header">
      <h3 class="card-title"><b>Customer Feedback</b></h3>
    </div>

    <div class="card-body">
      <table id="example1" class="table table-bordered table-striped">
	    <thead>
	      <tr>
	        <th>#</th>
	        <th>Name</th>
	        <th>Phone Number</th>
	        <th>Email</th>
	        <th>Message</th>
	        <th>Action</th>
	      </tr>
	    </thead>
	    <tbody>
	     @php($i=1)
	     @foreach ($customers_feedback as $data) 
	     <tr>
	     	<td>{{ $i++ }}</td>
	     	<td>{{ $data -> name }}</td>
	     	<td>{{ $data -> contact }}</td>
	     	<td>{{ $data -> email }}</td>
	     	<td>{{ $data -> message }}</td>
	     	<td>
	     		<a type="button" class="btn btn-danger btn-sm"  href="{{route('feedback_delete',['id'=>$data->id])}}">Delete</a>
	     	</td>
	     </tr>    
	     @endforeach
	     
       </tbody>    
      </table>
    </div>
  </div>
 @endsection