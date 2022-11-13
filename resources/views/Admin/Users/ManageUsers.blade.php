@extends('Admin.master')
@section('title')

	Manage User

@endsection
@section('content')




<style>
  
  div.dataTables_wrapper div.dataTables_length select {
  width: 60px;
 
}
/*#example1 th{
  text-align: center;
}*/

/*#example1 td{
  text-align: center;
}*/
/*#add_user{
  font-family: poppins;
}*/
</style>

  @error('email')
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
           <strong>{{ $message }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hiddden="true">&times;</span>
        </button>
      </div>
  @enderror
  @error('password')
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ $message }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hiddden="true">&times;</span>
        </button>
      </div>
  @enderror
   @error('password_confirmation')
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ $message }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hiddden="true">&times;</span>
        </button>
      </div>
  @enderror


  <div class="card my-2">
      <div class="card-header">
        <h3 class="card-title" id ="add_user"><b>Manage User</b></h3>
         
            <button type="button" class="btn btn-success btn-sm" style="float: right;" data-bs-toggle="modal" data-bs-target="#add" data-bs-whatever="@fat" id="add_user">
             Add Staff 
          </button>
      </div>   

      <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">

          <!-- add user modal -->
           <div class="modal fade" id="add" tabindex="-1" aria-labelledby="add" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                  <div class="modal-header text-center">
                    <h5 class="modal-title w-100" id="add">Add New Staff</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form action="{{route('save_user')}}" method="post" onsubmit="btn.disabled = true; return true;">

                         @csrf

                        <div class="form-group">
                          <label> First Name</label>
                          <input type="text" class="form-control" name="name" 
                                 placeholder="First Name" 
                                 required>
                        </div>

                       
                        <div class="form-group">
                          <label> Last Name</label>
                          <input type="text" class="form-control" name="lastname"
                                 placeholder="Last Name" 
                                 required>
                        </div>

                        <div class="form-group">
                          <label> Purok</label>
                          <input type="text" class="form-control" name="purok"
                                 placeholder="Purok No." 
                                 required>
                        </div>

                        <div class="form-group">
                          <label> Address</label>
                          <input type="text" class="form-control" name="address"
                                 placeholder="Address" 
                                 required>
                        </div>

                        <div class="form-group">
                          <label> Phone Number</label>
                          <input type="tel" class="form-control" name="phone_number"
                                 placeholder="Ex: 09805******" 
                                 pattern="[0-9]{11}" 
                                 min="11"
                                 max="11" 
                                 required>
                        </div>

                        <div class="form-group">
                          <label> Email</label>
                          <input type="email" class="form-control" name="email" 
                                 placeholder="Email Address">
                       
                        </div>


                        <div class="form-group">
                          <label> Password</label>
                          <input type="Password" class="form-control" name="password" 
                                 placeholder="Password" 
                                 required>
                        </div>

                        <div class="form-group">
                          <label> Confirm Password </label>
                          <input type="Password" class="form-control" name="password_confirmation"
                                 placeholder="Confirm your Password" 
                                 required>
                        </div>
          
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" >Cancel</button> 
                          <button class="btn btn-primary" type="submit" name="btn">Submit</button>
                        </div>

                    </form>
                 </div>
               </div>
             </div>
           </div>
           
              <!-- end of user modal -->

          <thead>
          <tr>
            <th>#</th>
            <th>Full Name</th>
            <th>Purok</th>
            <th>Address</th>
            <th>Phone Number</th>
            <th>Email</th>
            <th>Logged in Using</th>
            <th>Role</th>        
            <th>Date Created</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>
          
        	@php($i = 1)
        	@foreach($users  as $user)
          <tr>
            <td>{{$i++}}</td>
            <td>{{$user->name}} {{$user->middlename}} {{$user->lastname}}</td>
            <td>{{ $user -> purok }}</td>
            <td>

               @if($user->address == null)

                    N/A
                    
                @else
                  {{$user->address}}

                @endif
                
            </td>
            <td>{{ $user -> phone_number }}</td>
            
            <td>{{$user -> email}}</td>
            
            <td>

                @if($user -> google_id)
                   Google Account
                @else
                   Nick's Resto Bar System 
                @endif

            </td >

            <td>

                  @if($user ->role == 1)

                    <p class="text-center">
                     <span class="badge badge-info">Admin</span>
                    </p>

                  @elseif($user ->role == 2)

                    <p class="text-center">
                     <span class="badge badge-secondary">Staff</span>
                    </p>

                  @else
                    <p class="text-center">
                     <span class="badge badge-warning">Customer</span>
                    </p>
                  @endif
                  
            </td>
            
            {{-- <td>{{ \Carbon\Carbon::parse($user -> created_at)->diffForHumans() }}</td> --}}
            <td>{{\Carbon\Carbon::parse($user->created_at)->toFormattedDateString()}}</td>
            <td style="text-align: center;">

                @if($user -> role == 2)

                 <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#edit{{ $user -> id }}" data-bs-whatever="@fat">
                    Edit 
                </button>

                @else
                  . . .
                @endif

            </td>

            </tr>
            
           {{--  edit the staff --}}
           <div class="modal fade" id="edit{{ $user -> id }}" tabindex="-1" aria-labelledby="edit" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                  <div class="modal-header text-center">
                    <h5 class="modal-title w-100" id="add">Edit Staff</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form action="{{ route('update_staff') }}" method="post" onsubmit="btn.disabled = true; return true;">

                         @csrf

                        <input type="hidden" class="form-control"  name="id" value="{{$user->id}}">
                        <div class="form-group">
                          <label> First Name</label>
                          <input type="text" class="form-control" name="name" 
                                 placeholder="First Name" 
                                 value="{{ $user -> name }}" 
                                 required>
                        </div>

                       
                        <div class="form-group">
                          <label> Last Name</label>
                          <input type="text" class="form-control" name="lastname"
                                 placeholder="Last Name" 
                                 value="{{ $user -> lastname }}" 
                                 required>
                        </div>

                        <div class="form-group">
                          <label> Purok</label>
                          <input type="text" class="form-control" name="purok"
                                 placeholder="Purok No." 
                                 value="{{ $user -> purok }}" 
                                 required>
                        </div>

                        <div class="form-group">
                          <label> Address</label>
                          <input type="text" class="form-control" name="address"
                                 placeholder="Address" 
                                 value="{{ $user -> address }}" 
                                 required>
                        </div>

                        <div class="form-group">
                          <label> Phone Number</label>
                          <input type="tel" class="form-control" name="phone_number"
                                 placeholder="Ex: 09805******" 
                                 pattern="[0-9]{11}" 
                                 min="11"
                                 max="11" 
                                 value="{{ $user -> phone_number }}" 
                                 required>
                        </div>

                        <div class="form-group">
                          <label> Email</label>
                          <input type="email" class="form-control" 
                                 name="email" 
                                 value="{{ $user -> email }}" 
                                 placeholder="Email Address">
                       
                        </div>


                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" >Cancel</button> 
                          <button class="btn btn-primary" type="submit" name="btn">Submit</button>
                        </div>

                    </form>
                 </div>
               </div>
             </div>
           </div>

           {{-- end of edit --}}
          @endforeach
          
          </tbody>
        </table>
      </div>
  </div>
            

@endsection
