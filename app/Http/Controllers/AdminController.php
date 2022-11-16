<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\order;
use App\Models\OrderDetail;
use App\Models\category;
use App\Models\Dish;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    
    function index()
    {
      $categories = Category::count();
      $dishes = Dish::count();
      $orders = Order::count();
      $pending_orders = Order::where('order_status','pending')->count();
      $cancelled_orders = Order::where('order_status','Cancelled')->count();
      $OnProcess_orders = Order::where('order_status','On Process')->count();
      $delivered_orders = Order::where('order_status','Delivered')->count();
      $out_orders = Order::where('order_status','Out of Delivery')->count();
      $admin = User::where('role','1')->count();
      $staff = User::where('role','2')->count();
      $customers = User::where('role','0')->count();
      $newuser = User::where('created_at', '>', today())->count();



      // $most_sold = DB::table('dishes')
      // ->leftJoin('order_details','dishes.id', '=', 'order_details.dish_id')
      // ->selectRaw('dishes.id, SUM(order_details.dish_qty) as total')
      // ->groupBy('dishes.id')
      // ->orderBy('total','desc')
      // ->take(10)
      // ->get();



      return view('Admin.Home.index', compact('categories','dishes','admin','staff','customers','orders','newuser','pending_orders','cancelled_orders','OnProcess_orders','delivered_orders','out_orders'));  
    }
  

    public function manage()
    {
        $users = user::all();
        return view('Admin.Users.ManageUsers', compact('users'));   
    }

    public function create (Request $request)
    {

      $validated = $request->validate([
        'email' => 'required|email|string|unique:users|max:255',
        'password' => 'required|confirmed|min:8|max:255',
        'password_confirmation' => 'required',
      ]);

        $user = new User();

        $user -> name = $request-> name;
        // $user -> middlename = $request-> middlename;
        $user -> lastname = $request-> lastname;
        $user -> purok = $request-> purok;
        $user -> address = $request-> address;
        $user -> phone_number = $request-> phone_number;
        $user -> email = $request-> email;
        $user -> password = bcrypt($request-> password);
        $user -> role = 2;
        $user -> save();

        $notification = array (

            'message' => 'New User Added Sucessfully',
            'alert-type' =>'success'
        );

        return redirect()-> back()->with($notification);

        // return back()->with('added_msg','New User Added Sucessfully');
      
    }

    public function profile(){
    
        $admin = User::find(Auth::id());
        return view('Admin.Users.UserProfile',compact(var_name:'admin')); 
    }

    public function profile_update(Request $request){

     $validated = $request->validate([

        'email' => 'required|email|string|unique:users,email,'.$request->id,

      ]);

    	$profile = User::find($request->id);
    	$profile->name = $request->name;
    	// $profile->middlename = $request->middlename;
    	$profile->lastname = $request->lastname;
    	$profile -> purok = $request -> purok;
      $profile -> address = $request -> address;
      $profile -> phone_number = $request -> phone_number;
      $profile -> email = $request -> email;
    	$profile->save();

        $notification = array (

            'message' => 'Profile Updated Successfully',
            'alert-type' =>'info'
        );

        return back()->with($notification);
    }  

    public function change_pass(){

        return view('Admin.Users.UserPass');
    }
    
    public function update_pass(Request $request){

      $validated = $request->validate([
       
        'oldpassword' => 'required|password',
        'password' => 'required|confirmed|min:8|max:255',
        'password_confirmation' => 'required',

      ]);

      $hashedPassword = Auth::user()->password;

      if(Hash::check($request -> oldpassword,$hashedPassword)){

          $user = User::find(Auth::id());
          $user -> password = Hash::make($request-> password);
          $user->save();
          Auth::logout();
         
          return redirect()->route('login')->with('sms','Password Successfully Change. You need to login with new password');
      }
      else{      

          return redirect()->back();

      }

    }

    public function update_staff(Request $request){

       $validated = $request->validate([

        'email' => 'required|email|string|unique:users,email,'.$request->id,

      ]);

      // if($request -> id){

      //   $this -> validate($request,[

      //     'email' => 'required|unique:users,email,'.$request->id,
      //   ]);

      // }
      $staff_profile = user::find($request -> id);
      $staff_profile->name = $request->name;
      $staff_profile->lastname = $request->lastname;
      $staff_profile -> purok = $request -> purok;
      $staff_profile -> address = $request -> address;
      $staff_profile -> phone_number = $request -> phone_number;
      $staff_profile -> email = $request -> email;
      $staff_profile->save();

        $notification = array (

            'message' => 'Profile Updated Successfully',
            'alert-type' =>'info'
        );

        return back()->with($notification);

    }

    public function change_staff_password(Request $request){
        
       $validated = $request->validate([
     
        'password' => 'required|confirmed|min:8|max:255',
        'password_confirmation' => 'required',

      ]);

       

        $staff_password = User::find($request -> id);
        $staff_password -> password = Hash::make($request-> password);
        $staff_password->save();
        
         $notification = array (

            'message' => 'Password Successfully Change',
            'alert-type' =>'info'
        );

        return back()->with($notification);
       
    }


    

    

}
