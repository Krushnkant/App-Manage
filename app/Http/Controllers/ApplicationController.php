<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helpers;
use App\Models\ {ApplicationData};
// use DataTables;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // return view('user.add_application');
        
        return view('user.application_list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        dd("create");
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
        if($data['icon']){
            $path = public_path("app_icons/");
            $public_path = asset('app_icons/');
            $result = Helpers::UploadImage($data['icon'], $path);
            $data['icon'] = $result;
        }
        $app_data = ApplicationData::Create($data);
        if($app_data != null){
            return redirect('/application');
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
        dd("show");
        // return view('user.edit_application');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // dd("edit");//application/1/edit
        $data = ApplicationData::find($id);
        return view('user.edit_application', compact('data'));
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
        $get_data = ApplicationData::find($id);
        $data = $request->all();
        $data['name'] = (isset($data['name']) && $data['name']) ? $data['name'] : $get_data->name;
        $data['app_id'] = (isset($data['app_id']) && $data['app_id']) ? $data['app_id'] : $get_data->app_id;
        $data['package_name'] = (isset($data['package_name']) && $data['package_name']) ? $data['package_name'] : $get_data->package_name;
        if(isset($data['icon'])){
            $path = public_path("app_icons/");
            $public_path = asset('app_icons/');
            $result = Helpers::UploadImage($data['icon'], $path);
            $data['icon'] = $result;
        }
        $data['icon'] = (isset($data['icon']) && $data['icon']) ? $data['icon'] : $get_data->icon;
        $get_data->update($data);
        
        if($get_data != null){
            return redirect('/application');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $get_data = ApplicationData::find($id);
        if($get_data != null){
            $data = $get_data->delete();
            if($data == true){
                return response()->json(['status' => '200']);
            }else{
                return response()->json(['status' => '400']);
            }
        }else{
            return response()->json(['status' => '400']);
        }
    }

    public function AddApplication()
    {
        return view('user.add_application');
    }

    public function dashboard()
    {
        return view('user.dashboard');
    }

    public function ApplicationList(Request $request)
    {
        $request1 = $request->all();
        $data = ApplicationData::get();
        // if (isset($request1['start_date'])) {
        //     $startdate = Carbon::parse($request1['start_date'])->format('Y-m-d H:i:s');
        //     $enddate = Carbon::parse($request1['end_date'])->format('Y-m-d H:i:s');
        //     $ddata = ApplicationData::whereBetween('created_at', [$startdate, $enddate])->get();
        // } else {
        //     $ddata = ApplicationData::get();
        // }
        foreach($data as $d){
            $d->start_date = $d->created_at->format('d M Y');
            // dump($d->created_at);
        }
        return datatables::of($data)->make(true);
    }
}
