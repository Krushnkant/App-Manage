<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helpers;
use App\Models\ {ApplicationData, Category, FormStructure, AppData};
// use DataTables;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Str;

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
        // dd($request->all());
        $validated = $request->validate([
            'name' => 'required',
            'icon' => 'required|image|mimes:jpg,jpeg,png',
            'app_id' => 'required|unique:application_data',
            'package_name' => 'required',
        ]);
        $data = $request->all();
        if($data['icon']){
            $path = public_path("app_icons/");
            $public_path = asset('app_icons/');
            $result = Helpers::UploadImage($data['icon'], $path);
            $data['icon'] = $result;
            $data['token'] = Str::random(20);
        }
        $app_data = ApplicationData::Create($data);
        if($app_data != null){
            return redirect('/application');
        }else{
            toastr()->error('Please enter different application id');
            return redirect('/add-application'); 
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
        $ApplicationData = ApplicationData::select(\DB::raw('(SELECT count(*) FROM application_data ) as total_applications'),\DB::raw('(SELECT count(*) FROM application_data where status = "1" ) as total_active_applications'),\DB::raw('(SELECT count(*) FROM application_data where status = "0" ) as total_deactive_applications'))->first();
     
        return view("user.dashboard",compact('ApplicationData'));
    }

    public function ApplicationList(Request $request)
    {
        $request1 = $request->all();
        
        $tab_type = $request->tab_type;
        if ($tab_type == "active_application_tab"){
            $status = 1;
        }
        elseif ($tab_type == "deactive_application_tab"){
            $status = 0;
        }
        $data = ApplicationData::orderBy('id', 'DESC')->get();
        if (isset($status)){
            $s = (string) $status;
            $data = ApplicationData::where('status',$s)->orderBy('id', 'DESC')->get();
        }
        
        foreach($data as $d){
            $d->start_date = $d->created_at->format('d M Y');
            $category_ids = Category::where('app_id', $d->id)->where('status', '1')->get()->pluck('id')->toArray();
            $app_data = AppData::where('app_id', $d->id)->first();
            // $structure_ids = FormStructure::where('application_id', $d->id)->where('status', 1)->where('field_type', 'sub-form')->get()->pluck('id')->toArray();
            $cat_id = implode(',',$category_ids);
            // $structure_id = implode(',',$structure_ids);
            $is_category = Category::where('app_id', $d->id)->where('status', '1')->first();
            if($app_data != null){
                if($is_category != null){
                    $d->is_category = 1;
                    $d->cat_ids = $cat_id;
                }else{
                    $d->is_category = 0;
                    $d->cat_ids = "";
                }
                $d->strcuture_id = $app_data->UUID;
            }else{
                if($is_category != null){
                    $d->is_category = 1;
                    $d->cat_ids = $cat_id;
                }else{
                    $d->is_category = 0;
                    $d->cat_ids = "";
                }
                $d->is_category = 1;
                $d->strcuture_id = null;
            }
        }
        // print_r($data);
        // dd();
        return datatables::of($data)->make(true);
    }

    public function ApplicationListDashboard(Request $request)
    {
        $request1 = $request->all();
        $data = ApplicationData::where('status','1')->whereDate('updated_at', Carbon::today())->orderBy('updated_at', 'DESC')->get();
        foreach($data as $d){
            $d->start_date = $d->created_at->format('d M Y');
        }
        return datatables::of($data)->make(true);
    }

    public function chageapplicationstatus($id){
        $application = ApplicationData::find($id);
        if ($application->status== '1'){
            $application->status = '0';
            $application->save();
            return response()->json(['status' => '200','action' =>'deactive']);
        }
        if ($application->status== '0'){
            $application->status = '1';
            $application->save();
            return response()->json(['status' => '200','action' =>'active']);
        }
    }

    public function CheckAppId(Request $request)
    {
       $data = $request->all();
       $application = ApplicationData::where('app_id', $data['app_id'])->where('status', '1')->first();
       if($application != null){
        return response()->json(['status' => '200','message' => 'false']);  
       }else{
        return response()->json(['status' => '200','message' => 'true']);  
       }
        // dd($application);
    }
}
