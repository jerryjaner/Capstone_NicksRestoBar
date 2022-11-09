<!DOCTYPE html>
<html>
<head>
  <title></title>
  <style>
    #example1{
      font-family: arial ,helvetica, sans-serif;
      border-collapse: collapse;
      width: 100%;

    }
    #example1 td, #example1 th {
      border: 1px solid #ddd;
      padding: 8px;
    }
    #example1 tr:nth-child(even){
      background-color: #ddd;
    }

    #example1 th{
      padding-top: 12px;
      padding-bottom: 12px;
      text-align: center;
      background-color: #E74844;
      color:white;
    }
  </style>
</head>
<body>
    <div class="card my-2">
        <div class="card-body">
          <center>
            <h1 style="margin:50px;">Customer Report</h1>
            <hr>
          <table id="example1">
            <thead>
              <tr>
                <th>#</th>
                <th>Full Name</th>
                <th>Purok No.</th>
                <th>Address</th>
                <th>Phone Number</th>
                <th>Email</th>
                <th>Role</th>
              
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
                    {{$user->name}}

                  @endif
              </td>
              <td>{{$user -> email}}</td>
              <td> {{ $user -> phone_number }}</td>
              <td> Customer </td>
           </tr>
      
             
            @endforeach
           
            </tbody>                 
          </table>               
        </div>
    </div>   
</body>
</html>
