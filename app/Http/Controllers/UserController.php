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

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
       return view('user.dashboard');
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                $auth = Auth::user();
                $user_id = $auth->id;
                
                // $ip = \Request::getClientIp(true);
                $ip = "43.240.9.99";
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
                // return redirect()->intended('/dashboard');
            }else{
                return response()->json(['status' => '400', 'message' => 'User Not Exits']);
                // return redirect()->intended('/login');
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
