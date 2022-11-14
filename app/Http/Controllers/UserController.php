<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\{User, UserLogin ,ApplicationData};
use Illuminate\Support\Facades\Auth;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\Session;
use App\Http\Helpers;
use DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = "Category Add Content";
        if ($request->ajax()) {
            $data = User::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct">Edit</a>';
   
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct">Delete</a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
       // $posts =  User::latest()->paginate(5);
        return view('user.index', compact('page'));
      
    }
   
    public function loginForm()
    {
        return view('user.auth.login');
    }

    public function registerForm()
    {
        return view('user.auth.register');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

     public function fetchstudent()
    {
        $students = User::all();
        return response()->json([
            'students'=>$students,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $validator = validator::make($request->all(),[
        //     'firstname'=> 'required|max:191',
        //     'lastname'=> 'required|max:191',
        //     'username'=> 'required|max:191',
        //     'email'=> 'required|max:191',
        //     'password'=> 'required|max:191',

        // ]);

        // if($validator->fails()){
        //     return response()->json([
        //         'status'=>400,
        //         'errors'=> $validator->messages(),
        //                 ]);
        // }
        // else
        // {
        //     $student = new User;
        //     $student->firstname = $request->input('firstname');
        //     $student->lastname = $request->input('lastname'); 
        //     $student->username = $request->input('username');
        //     $student->email = $request->input('email');
        //     $student->password = $request->input('password');
        //     $student->save();
        //     return response()->json([
        //         'status'=>200,
        //         'message'=>'user added successfully'
        //                 ]);
        // }

        User::updateOrCreate(['id' => $request->product_id],
        ['firstname' => $request->fname,'lastname' => $request->lname,'username' => $request->uname, 'email' => $request->email,'password' => $request->password]);        

        return response()->json(['success'=>'User saved successfully.']);
	
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        //$id = $request->id;
		// $student = User::find($id);
        // if($student)
        // {
        //     return response()->json([
        //         'status'=>200,
        //         'student'=>$student
        //                 ]);
        // }
        // else
        // {
        //     return response()->json([
        //         'status'=>404,
        //         'message'=>'user not found '
        //                 ]);
        // }

        $product = User::find($id);
        return response()->json($product);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $validator = validator::make($request->all(),[
        //     'firstname'=> 'required|max:191',
        //     'lastname'=> 'required|max:191',
        //     'username'=> 'required|max:191',
        //     'email'=> 'required|max:191',
        //     'password'=> 'required|max:191',

        // ]);

        // if($validator->fails()){
        //     return response()->json([
        //         'status'=>400,
        //         'errors'=> $validator->messages(),
        //                 ]);
        // }
        // else
        // {
        //     $student = User::find($id);

        //     if($student)
        //     {
        //         $student->firstname = $request->input('firstname');
        //         $student->lastname = $request->input('lastname'); 
        //         $student->username = $request->input('username');
        //         $student->email = $request->input('email');
        //         $student->password = $request->input('password');
        //         $student->update();
        //         return response()->json([
        //             'status'=>200,
        //             'message'=>'user updated successfully'
        //                     ]);
        //     }
        //     else
        //     {
        //         return response()->json([
        //             'status'=>404,
        //             'message'=>'user not found '
        //                     ]);
        //     }
           
            
        // }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $student = User::find($id);
        
        // $student->delete();
        // return response()->json([
        //     'status'=>200,
        //     'message'=>'student deleted successfully'
        //             ]);
        User::find($id)->delete();
     
        return response()->json(['success'=>'User deleted successfully.']);
		
    }
    

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $data = $request->all();
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(),'status'=>'failed']);
        }else{
            $user = User::where('email', $data['email'])->first();
            if($user != null){
                $credentials = $request->only('email', 'password');
                if (Auth::attempt($credentials)) {
                    $user_id = $user->id;
                    dd($user_id); 
                    // $ip = \Request::getClientIp(true); // use for live
                    $ip = "43.240.9.99"; // use for local
                    $currentUserInfo = Location::get($ip);
                    if($currentUserInfo != null){
                        $country = $currentUserInfo->countryName;
                        $state = $currentUserInfo->regionName;
                        $city = $currentUserInfo->cityName;
    
                        $user_agent = $_SERVER['HTTP_USER_AGENT'];
                        $browser_name = Helpers::getBrowserName($user_agent);
    
                        $history = [];
                        $history['user_id'] = $user_id;
                        $history['ip_address'] = $ip;
                        $history['country'] = $country;
                        $history['state'] = $state;
                        $history['city'] = $city;
                        $history['browser'] = $browser_name;
                        
                        $login_user_history = UserLogin::Create($history);
    
                        
                    }
                    return response()->json(['status' => '200', 'message' => 'Login Successfully']);
                }
            }else{
                return response()->json(['status' => '400', 'message' => 'User Not Exits']);
            }
        }
    }

    public function register(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required',
            'password' => 'required|min:8',
            'email' => 'required|email'
        ]);
        $data = $request->all();
        $data['decrypted_password'] = $data['password'];
        $data['password'] = Hash::make($data['password']);
        
        $users = User::Create($data);
        if($users != null){
            return redirect()->intended('/dashboard');
        }
    }

    public function logout() {
        Session::flush();
        Auth::logout();

        return Redirect('/');
    }
}
