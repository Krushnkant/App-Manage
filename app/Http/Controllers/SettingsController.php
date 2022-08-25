<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ { Settings };

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $get_settings = Settings::where('id', 1)->first();
        $page = "Add Setting";
        if($get_settings != null){
            return view('user.settings.add', compact('get_settings', 'page'));
        }else{
            return view('user.settings.add',compact('page'));
        }
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
        $data = $request->all();
        $settings = Settings::where('user_id', $data['user_id'])->first();

        if($settings != null){
            $settings->user_id = $data['user_id'];
            $settings->token_start_time = $data['token_start_time'];
            $settings->token_end_time = $data['token_end_time'];
        }else{
            $settings = New Settings();
            $settings->user_id = $data['user_id'];
            $settings->token_start_time = $data['token_start_time'];
            $settings->token_end_time = $data['token_end_time'];  
        }
        $settings->save();

        if($settings != null){
            return response()->json(['status' => '200']);
        }else{
            return response()->json(['status' => '400']);
        }
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
}
