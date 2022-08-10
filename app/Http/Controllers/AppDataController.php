<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ {AppData, SubformStructure, FormStructure, SubAppData, ApplicationData, Category};
use App\Http\Helpers;
use Illuminate\Support\Str;

class AppDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $randomString = Str::random(30);
        // dd($data);
        $application_id = (isset($data['application_id']) && $data['application_id']) ? $data['application_id'] : null;
        $category_id = (isset($data['category']) && $data['category']) ? $data['category'] : null;
        $Uuid = (isset($data['UUID']) && $data['UUID']) ? $data['UUID'] : null;
        $main_uuid = "";
        
        foreach($data as $key => $d){
            if (strpos($key, "field_name") !== false) {
                $int_var = (int)filter_var($key, FILTER_SANITIZE_NUMBER_INT);
                $form_strcture = FormStructure::find($int_var);
                if($form_strcture != null){
                    $app_data = new AppData();
                    $app_data->UUID = $randomString;
                    $app_data->app_id = $application_id;
                    $app_data->category_id = $category_id;
                    $app_data->form_structure_id = $form_strcture->id;
                    $app_data->value = $d;
                    $app_data->save();

                    $main_uuid = $app_data->UUID;
                }
                unset($data[$key]);
            }
            if (strpos($key, "files") !== false) {
                $int_var = (int)filter_var($key, FILTER_SANITIZE_NUMBER_INT);
                $form_strcture = FormStructure::find($int_var);
                foreach($d as $ddd){
                    $imageName = Str::random().'.'.$ddd->getClientOriginalExtension();
                    $fff = $ddd->move(public_path().'/app_data_images/', $imageName);  
                    if($form_strcture != null){
                        $app_data = new AppData();
                        $app_data->UUID = $randomString;
                        $app_data->app_id = $application_id;
                        $app_data->category_id = $category_id;
                        $app_data->form_structure_id = $form_strcture->id;
                        $app_data->value = $imageName;
                        $app_data->save();
                    }
                }
                unset($data[$key]);
            }
            if (strpos($key, "single") !== false) {
                $int_var = (int)filter_var($key, FILTER_SANITIZE_NUMBER_INT);
                $form_strcture = FormStructure::find($int_var);

                $path = public_path("app_data_images/");
                $result = Helpers::UploadImage($d[0], $path);

                if($form_strcture != null){
                    $app_data = new AppData();
                    $app_data->UUID = $randomString;
                    $app_data->app_id = $application_id;
                    $app_data->category_id = $category_id;
                    $app_data->form_structure_id = $form_strcture->id;
                    $app_data->value = $result;
                    $app_data->save();
                }
                unset($data[$key]);
            }
        }
        unset($data['_token']);
        unset($data['application_id']);
        // $Uuid = $data['UUID'];

        // dd($main_uuid);
        if($Uuid != null){
            foreach($data as $key => $d){
                if (strpos($key, "subname") !== false) {
                    $int_var = (int)filter_var($key, FILTER_SANITIZE_NUMBER_INT);
                    $sub_form_strcture = SubformStructure::find($int_var);
                    foreach($d as $k => $fff){
                        if($sub_form_strcture != null){
                            $app_data = new SubAppData();
                            $app_data->app_id = $application_id;
                            $app_data->category_id = $category_id;
                            $app_data->app_uuid = $randomString;
                            $app_data->UUID = $Uuid[$k];
                            $app_data->sub_form_structure_id = $sub_form_strcture->id;
                            $app_data->value = $fff;
                            $app_data->save();
                        }
                    }
                    unset($data[$key]);
                }
            }
            foreach($data as $key => $d){
                if (strpos($key, "subfile") !== false) {
                    $int_var = (int)filter_var($key, FILTER_SANITIZE_NUMBER_INT);
                    $sub_form_strcture = SubformStructure::find($int_var);
                    foreach($d as $k => $fff){
                        $path = public_path("app_data_images/");
                        $result = Helpers::UploadImage($fff, $path);
                        if($sub_form_strcture != null){
                            $app_data = new SubAppData();
                            $app_data->app_id = $application_id;
                            $app_data->category_id = $category_id;
                            $app_data->app_uuid = $randomString;
                            $app_data->UUID = $Uuid[$k];
                            $app_data->sub_form_structure_id = $sub_form_strcture->id;
                            $app_data->value = $result;
                            $app_data->save();
                        }
                    }
                    unset($data[$key]);
                }
            }
        }
        return response()->json(['status' => '200']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AppData  $appData
     * @return \Illuminate\Http\Response
     */
    public function show(AppData $appData)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AppData  $appData
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $uuid)
    {
        // $application = ApplicationData::find($id);
        // $app_data = AppData::with('fieldd')->where('UUID', $uuid)->where('app_id', $id)->get();
        // $sub_app_data = SubAppData::with('fieldd')->where('app_id', $id)->get();
        // $categories = Category::where('app_id', $id)->where('status', '1')->get();
        // return view('user.content.edit_content', compact('id','app_data', 'sub_app_data', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AppData  $appData
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AppData $appData)
    {
        $data = $request->all();
        $data1 = [];
        $app_id = (isset($data['app_id']) && $data['app_id']) ? $data['app_id'] : null;
        $category_id = (isset($data['category']) && $data['category']) ? $data['category'] : null;
        $UUID_main = (isset($data['UUID-main']) && $data['UUID-main']) ? $data['UUID-main'] : null;
        $sub_single = [];
        unset($data['app_id']);
        unset($data['category']);
        foreach($data as $key => $val){
            // dump($key);
            if (strpos($key, "field_name") !== false) {
                $int_var = (int)filter_var($key, FILTER_SANITIZE_NUMBER_INT);
                $app_data = AppData::find($int_var);
                if($app_data != null){
                    $app_data->UUID = $UUID_main;
                    $app_data->category_id = $category_id;
                    $app_data->value = $val;
                    $app_data->save();
                }
                unset($data[$key]);
            }
            
            if (strpos($key, "one") !== false) {
                $int_var = (int)filter_var($key, FILTER_SANITIZE_NUMBER_INT);
                $app_data = AppData::find($int_var);
                $path = public_path("app_data_images/");
                $result = Helpers::UploadImage($val[0], $path);
                if($app_data != null){
                    $app_data->UUID = $UUID_main;
                    $app_data->category_id = $category_id;
                    $app_data->value = $result;
                    $app_data->save();
                }
                unset($data[$key]);
            }
            if (strpos($key, "files") !== false) {
                $aaa = explode('_',$key);
                $app_idd = $aaa[0];
                $cat_idd = $aaa[1];
                $structure_idd = $aaa[2];
                foreach($val as $ddd){
                    $imageName = Str::random().'.'.$ddd->getClientOriginalExtension();
                    $fff = $ddd->move(public_path().'/app_data_images/', $imageName);  
                    $app_data = new AppData();
                    $app_data->UUID = $UUID_main;
                    $app_data->app_id = $app_idd;
                    $app_data->category_id = $category_id;
                    $app_data->form_structure_id = $structure_idd;
                    $app_data->value = $imageName;
                    $app_data->save();
                }
                unset($data[$key]);
            }
        }
        $uuid = $data['UUID'];
        $sub_form_data = SubAppData::where('app_id', $app_id)->where('app_uuid', $UUID_main)->whereNotIn('UUID', $uuid)->delete();
        unset($data['UUID']);
        unset($data['_token']);
        unset($data['UUID-main']);
        // dd($data);

        // dd($uuid);
        $rrr = [];
        foreach($data as $key => $ddd){
            if (strpos($key, "sub_single") !== false) {
                $aaa = explode('-',$key);
                $uuuuid = $aaa[0];
                if (($key = array_search($uuuuid, $uuid)) !== false) {
                    unset($uuid[$key]);
                }
                $int_var = (int)filter_var($aaa[1], FILTER_SANITIZE_NUMBER_INT);
                $app_data = SubAppData::where('app_id', $app_id)->where('app_uuid', $UUID_main)->where('UUID', $uuuuid)->where('sub_form_structure_id', $int_var)->first();
                foreach($ddd as $i => $vall){
                    if($app_data != null){
                        $imageName = Str::random().'.'.$vall->getClientOriginalExtension();
                        $fff = $vall->move(public_path().'/app_data_images/', $imageName);  

                        $app_data->value = $imageName;
                        $app_data->app_uuid = $UUID_main;
                        $app_data->category_id = $category_id;
                        $app_data->save();
                        unset($ddd[$i]);
                    }
                    // if($i == 0){
                    //     $imageName = Str::random().'.'.$vall->getClientOriginalExtension();
                    //     $fff = $vall->move(public_path().'/app_data_images/', $imageName);  
                    //     if($app_data != null){
                    //         $app_data->value = $imageName;
                    //         $app_data->app_uuid = $UUID_main;
                    //         $app_data->category_id = $category_id;
                    //         $app_data->save();
                    //     }
                    //     unset($ddd[$i]);
                    // }else{
                    //         $app_datas = SubAppData::where('app_id', $app_id)->where('app_uuid', $UUID_main)->get()->pluck('UUID')->toArray();
                    //         $result = array_diff($uuid,$app_datas);
                    //         $rrr = [];
                    //         foreach($result as $da){
                    //             array_push($rrr, $da);
                    //         }
                    //         $imageName = Str::random().'.'.$vall->getClientOriginalExtension();
                    //         $fff = $vall->move(public_path().'/app_data_images/', $imageName);  
                    //         if(count($result) > 1){
                    //             foreach($rrr as $k => $r){
                    //                 $app_data = SubAppData::where('app_id', $app_id)->where('UUID', $rrr[$k])->where('sub_form_structure_id', $int_var)->first();
                    //                 if($app_data == null){
                    //                     $app_data = new SubAppData();
                    //                     $app_data->app_id = $app_id;
                    //                     $app_data->app_uuid = $UUID_main;
                    //                     $app_data->category_id = $category_id;
                    //                     $app_data->UUID = $rrr[$k];
                    //                     $app_data->sub_form_structure_id = $int_var;
                    //                     $app_data->value = $imageName;
                    //                     $app_data->save();
                    //                 }
                    //             }
                    //         }else if(count($result) == 1){
                    //             $app_data = new SubAppData();
                    //             $app_data->app_id = $app_id;
                    //             $app_data->app_uuid = $UUID_main;
                    //             $app_data->category_id = $category_id;
                    //             $app_data->UUID = $rrr[0];
                    //             $app_data->sub_form_structure_id = $int_var;
                    //             $app_data->value = $imageName;
                    //             $app_data->save();
                    //         }
                    //         else{
                    //             foreach($uuid as $u){
                    //                 $app_datahh = SubAppData::where('app_id', $app_id)->where('UUID', $u)->where('sub_form_structure_id', $int_var)->first();
                    //                 if($app_datahh == null){
                    //                     $app_data = new SubAppData();
                    //                     $app_data->app_id = $app_id;
                    //                     $app_data->app_uuid = $UUID_main;
                    //                     $app_data->category_id = $category_id;
                    //                     $app_data->UUID = $u;
                    //                     $app_data->sub_form_structure_id = $int_var;
                    //                     $app_data->value = $imageName;
                    //                     $app_data->save();
                    //                 }
                    //             }
                    //         }
                    // }
                }
                // dd();
            }
            if (strpos($key, "sub_fieldname") !== false) {
                $aaa = explode('-',$key);
                $uuuuid = $aaa[0];
                
                if (($key = array_search($uuuuid, $uuid)) !== false) {
                    unset($uuid[$key]);
                }
                $int_var = (int)filter_var($aaa[1], FILTER_SANITIZE_NUMBER_INT);
                $app_data = SubAppData::where('app_id', $app_id)->where('app_uuid', $UUID_main)->where('UUID', $uuuuid)->where('sub_form_structure_id', $int_var)->first();
               
                foreach($ddd as $i => $vall){
                    if($app_data != null){
                        $app_data->value = $vall;
                        $app_data->app_uuid = $UUID_main;
                        $app_data->category_id = $category_id;
                        $app_data->save();
                        unset($ddd[$i]);
                    }
                    // unset($data[$key]);
                    // if($i == 0){
                    //     $app_data = SubAppData::where('app_id', $app_id)->where('UUID', $uuuuid)->where('sub_form_structure_id', $int_var)->first();
                    //     $app_data->value = $vall;
                    //     $app_data->app_uuid = $UUID_main;
                    //     $app_data->category_id = $category_id;
                    //     $app_data->save();
                    //     unset($ddd[$i]);
                    // }else{
                    //     $app_data = SubAppData::where('app_id', $app_id)->get()->pluck('UUID')->toArray();
                    //     $result = array_diff($uuid,$app_data);
                    //     $rrr = [];
                    //     foreach($result as $da){
                    //         array_push($rrr, $da);
                    //     }
                    //     if(count($result) > 1){
                    //         foreach($rrr as $k => $r){
                    //             $app_data = SubAppData::where('app_id', $app_id)->where('UUID', $rrr[$k])->where('sub_form_structure_id', $int_var)->first();
                    //             if($app_data == null){
                    //                 $app_data = new SubAppData();
                    //                 $app_data->app_id = $app_id;
                    //                 $app_data->app_uuid = $UUID_main;
                    //                 $app_data->category_id = $category_id;
                    //                 $app_data->UUID = $rrr[$k];
                    //                 $app_data->sub_form_structure_id = $int_var;
                    //                 $app_data->value = $vall;
                    //                 $app_data->save();
                    //             }
                    //         }
                    //     }else if(count($result) == 1){
                    //         $app_data = new SubAppData();
                    //         $app_data->app_id = $app_id;
                    //         $app_data->app_uuid = $UUID_main;
                    //         $app_data->category_id = $category_id;
                    //         $app_data->UUID = $rrr[0];
                    //         $app_data->sub_form_structure_id = $int_var;
                    //         $app_data->value = $vall;
                    //         $app_data->save();
                    //     }
                    // }
                    
                }
            }
            // unset($data[$key]);
        }
        $app_datas = SubAppData::where('app_id', $app_id)->where('app_uuid', $UUID_main)->get()->pluck('UUID')->toArray();
        $result = array_diff($uuid,$app_datas);
        foreach($result as $da){
            array_push($rrr, $da);
        }
        $coount = 0;
        $last_dd = [];
        // foreach($data as $key => $dd){
        //     if (strpos($key, "sub_fieldname") !== false) {
        //         $aaa = explode('-',$key);
        //         $int_var = (int)filter_var($aaa[1], FILTER_SANITIZE_NUMBER_INT);
        //         if($coount == 0){
        //             unset($dd[0]);
        //             $aa = 0;
        //             foreach($dd as $vv){
        //                 $app_data = new SubAppData();
        //                 $app_data->app_id = $app_id;
        //                 $app_data->category_id = $category_id;
        //                 $app_data->app_uuid = $UUID_main;
        //                 $app_data->UUID = $rrr[$aa];
        //                 $app_data->sub_form_structure_id = $int_var;
        //                 $app_data->value = $vv;
        //                 $app_data->save();
        //                 $aa ++;
        //             }
        //         }
        //     }
        //     if (strpos($key, "sub_single") !== false) {
        //         $aaa = explode('-',$key);
        //         $int_var = (int)filter_var($aaa[1], FILTER_SANITIZE_NUMBER_INT);
        //         $bb = 0;
        //         foreach($dd as $tt){
        //             $imageName = Str::random().'.'.$tt->getClientOriginalExtension();
        //             $fff = $tt->move(public_path().'/app_data_images/', $imageName);  

        //             $app_data = new SubAppData();
        //             $app_data->app_id = $app_id;
        //             $app_data->category_id = $category_id;
        //             $app_data->app_uuid = $UUID_main;
        //             $app_data->UUID = $rrr[$bb];
        //             $app_data->sub_form_structure_id = $int_var;
        //             $app_data->value = $result;
        //             $app_data->save();
        //             $bb ++; 
        //         }
        //     }
        //     $coount ++;
        // }
        // dd();
        return response()->json(['status' => '200']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AppData  $appData
     * @return \Illuminate\Http\Response
     */
    public function destroy(AppData $appData)
    {
        //
    }

    public function ApplicationHasCategory(Request $request)
    {
        $data = $request->all();
        $category = Category::where('app_id', $data['app_id'])->where('status', '1')->first();
        
        if($category != null){
            return response()->json(['is_category' => 1]);
        }else{
            return response()->json(['is_category' => 0]); 
        }
    }

    public function SameValueMatch(Request $request)
    {
        $data = $request->all();
        $structure_ids = FormStructure::where('field_name', $data['formData'])
                        ->where('application_id', $data['app_id'])
                        ->first();
        // dd($structure_ids);
        if($structure_ids == null){
            return response()->json(['success' => 1, 'responce' => true]);
        }else{
            return response()->json(['success' => 0, 'responce' => false]); 
        }
    }
}
