<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{ApplicationData, Category, FormStructure, AppData, SubAppData, CategoryFields, Settings};
use Carbon\Carbon;


class APIsController extends Controller
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

    public function RequestUpdate(Request $request)
    {
        try {
            $data = $request->all();
            $get_setting = Settings::where('id', 1)->first();
            $start_time = $get_setting->token_start_time;
            $end_time = $get_setting->token_end_time;
            $app = ApplicationData::where('token', $data['token'])->first();
            $app = $app->makeHidden(['created_at','status']);
            if (preg_match('/(\.jpg|\.jpeg|\.png|\.bmp)$/i', $app->icon)) {
                $path = asset('/app_icons');
                $app->icon = $path."/".$app->icon;
            }
            if($app != null){
                $count = 1;
                $app->total_request += $count;
                $app->save();
                return response()->json([
                    'data' => $app,
                    'responce' => 'success',
                    'sucess' => 1,
                    'message' => 'application request send successfully'
                ]);
            }else{
                return response()->json([
                    'data' => [],
                    'responce' => 'error',
                    'sucess' => 0,
                    'message' => 'application dones not exits'
                ]);
            }
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }

    public function CategoryList(Request $request)
    {
        try {
            $data = $request->all();
            $get_setting = Settings::where('id', 1)->first();
            $start_time = $get_setting->token_start_time;
            $end_time = $get_setting->token_end_time;
            $date = Carbon::now();
            $date = $date->format('H:i');
            $test_token = (isset($data['test_token']) && $data['test_token']) ? $data['test_token'] : null;
            if($test_token != null){
                if($date >= $start_time && $date <= $end_time){
                    $app = ApplicationData::where('test_token', $data['test_token'])->first();
                    if($app != null){
                        $category = Category::select('id','app_id','title','status','created_at')->where('app_id', $app->id)->where('status', '1')->get();
                        $category = $category->makeHidden(['created_at','status']);
                        foreach($category as $key => $cat){
                            $category_fields = CategoryFields::with('fields')->where('category_id', $cat->id)->where('status', '1')->get();
                            foreach($category_fields as $d){
                                $key = $d->key;
                                // if (preg_match('/(\.jpg|\.jpeg|\.png|\.bmp)$/i', $d->value)) {
                                if ($d->fields->type == "file" || $d->fields->type == "multi-file") {
                                    $path = asset('/category_image');
                                    $value = $path."/".$d->value;
                                }else{
                                    $value = $d->value;
                                }
                                $cat->$key = $value;
                            }
                        }
                        $app->cat_total_request += 1;
                        $app->save();
                        if($category != null && count($category) != 0){
                            return response()->json([
                                'data' => $category,
                                'responce' => 'success',
                                'sucess' => 1,
                                'message' => 'application request send successfully'
                            ]);
                        }else{
                            return response()->json([
                                'data' => [],
                                'responce' => 'success',
                                'sucess' => -1,
                                'message' => 'category not exits'
                            ]); 
                        }
                    }else{
                        return response()->json([
                            'data' => [],
                            'responce' => 'error',
                            'sucess' => 0,
                            'message' => 'application dones not exits'
                        ]);
                    }
                }else{
                    return response()->json([
                        'data' => [],
                        'responce' => 'error',
                        'sucess' => 0,
                        'message' => 'Test token is expired'
                    ]);
                }
            }else{
                $app = ApplicationData::where('token', $data['token'])->first();
                if($app != null){
                    $category = Category::select('id','app_id','title','status','created_at')->where('app_id', $app->id)->where('status', '1')->get();
                    $category = $category->makeHidden(['created_at','status']);
                    foreach($category as $key => $cat){
                        $category_fields = CategoryFields::with('fields')->where('category_id', $cat->id)->where('status', '1')->get();
                        foreach($category_fields as $d){
                            $key = $d->key;
                            // if (preg_match('/(\.jpg|\.jpeg|\.png|\.bmp)$/i', $d->value)) {
                            if ($d->fields->type == "file" || $d->fields->type == "multi-file") {
                                $path = asset('/category_image');
                                $value = $path."/".$d->value;
                            }else{
                                $value = $d->value;
                            }
                            $cat->$key = $value;
                        }
                    }
                    $app->cat_total_request += 1;
                    $app->save();
                    if($category != null && count($category) != 0){
                        return response()->json([
                            'data' => $category,
                            'responce' => 'success',
                            'sucess' => 1,
                            'message' => 'application request send successfully'
                        ]);
                    }else{
                        return response()->json([
                            'data' => [],
                            'responce' => 'success',
                            'sucess' => -1,
                            'message' => 'category not exits'
                        ]); 
                    }
                }else{
                    return response()->json([
                        'data' => [],
                        'responce' => 'error',
                        'sucess' => 0,
                        'message' => 'application dones not exits'
                    ]);
                }
            }
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }

    public function ContentList(Request $request)
    {
        try {
            $data = $request->all();
            $get_setting = Settings::where('id', 1)->first();
            $start_time = $get_setting->token_start_time;
            $end_time = $get_setting->token_end_time;
            $date = Carbon::now();
            $date = $date->format('H:i');
            $test_token = (isset($data['test_token']) && $data['test_token']) ? $data['test_token'] : null;
            if($test_token != null){
                if($date >= $start_time && $date <= $end_time){
                    $app = ApplicationData::where('test_token', $data['test_token'])->first();
                    if($app != null){
                        $cat_id = (isset($data['category_id'])) ? $data['category_id'] : null ;
                        $form_structure = AppData::select('*','UUID as sub_form_id')
                            ->leftJoin("form_structures", "form_structures.id", "=", "app_data.form_structure_id")
                            ->where("app_id", $app->id)
                            ->where("app_data.status", '1');
                        if($cat_id != null && $cat_id != 0){
                            $form_data = $form_structure->where('category_id', $cat_id);
                        }elseif($cat_id == 0 && $cat_id != null ){
                            $form_data = $form_structure->where('category_id','!=', null);
                        }elseif($cat_id == null){
                            $form_data = $form_structure->where('category_id', null);
                        }
                        $form_structure = $form_data->groupBy('UUID')->get();
                        // dd($form_structure);
                        foreach($form_structure as $form){
                            $get_bunch = AppData::select('*')
                                ->leftJoin("form_structures", "form_structures.id", "=", "app_data.form_structure_id")
                                ->where("app_id", $app->id)
                                ->where("app_data.status", '1')
                                ->where('UUID', $form->UUID)
                                ->get();
                                $multi_img = [];
                                foreach($get_bunch as $vvv){
                                    $key = $vvv->field_name;
                                    // if (preg_match('/(\.jpg|\.jpeg|\.png|\.bmp)$/i', $vvv->value) && $vvv->field_type != "multi-file") {
                                    if ($vvv->field_type == "file") {
                                        $path = asset('/app_data_images');
                                        $value = $path."/".$vvv->value;
                                    }else{
                                        $value = $vvv->value;
                                    }
                                    $form->$key = $value;
                                    if($vvv->field_type == "multi-file"){
                                        if ($vvv->field_type == "multi-file") {
                                            $path = asset('/app_data_images');
                                            $value = $path."/".$vvv->value;
                                            array_push($multi_img, $value);
                                            $form->$key = $multi_img;
                                        }
                                    }
                                }
                        }
                        foreach($form_structure as $form){
                            $form = $form->makeHidden(['id','UUID','value','field_name','app_id', 'category_id','form_structure_id', 'created_at','updated_at', 'deleted_at','application_id', 'field_type','created_by', 'updated_by']);
                        }
    
                        $app->total_request += 1;
                        $app->save();
                        if($form_structure != null && count($form_structure) > 0){
                            return response()->json([
                                'data' => $form_structure,
                                'responce' => 'success',
                                'sucess' => 1,
                                'message' => 'content data get successfully'
                            ]);
                        }else{
                            return response()->json([
                                'data' => [],
                                'responce' => 'success',
                                'sucess' => -1,
                                'message' => 'content data not exits'
                            ]); 
                        }
                    }else{
                        return response()->json([
                            'data' => [],
                            'responce' => 'error',
                            'sucess' => 0,
                            'message' => 'application dones not exits'
                        ]);
                    }
                }else{
                    return response()->json([
                        'data' => [],
                        'responce' => 'error',
                        'sucess' => 0,
                        'message' => 'Test token is expired'
                    ]); 
                }
            }else{
                $app = ApplicationData::where('token', $data['token'])->first();
                if($app != null){
                    $cat_id = (isset($data['category_id'])) ? $data['category_id'] : null ;
                    $form_structure = AppData::select('*','UUID as sub_form_id')
                        ->leftJoin("form_structures", "form_structures.id", "=", "app_data.form_structure_id")
                        ->where("app_id", $app->id)
                        ->where("app_data.status", '1');
                    if($cat_id != null && $cat_id != 0){
                        $form_data = $form_structure->where('category_id', $cat_id);
                    }elseif($cat_id == 0 && $cat_id != null ){
                        $form_data = $form_structure->where('category_id','!=', null);
                    }elseif($cat_id == null){
                        $form_data = $form_structure->where('category_id', null);
                    }
                    $form_structure = $form_data->groupBy('UUID')->get();
                    // dd($form_structure);
                    foreach($form_structure as $form){
                        $get_bunch = AppData::select('*')
                            ->leftJoin("form_structures", "form_structures.id", "=", "app_data.form_structure_id")
                            ->where("app_id", $app->id)
                            ->where("app_data.status", '1')
                            ->where('UUID', $form->UUID)
                            ->get();
                            $multi_img = [];
                            foreach($get_bunch as $vvv){
                                $key = $vvv->field_name;
                                // if (preg_match('/(\.jpg|\.jpeg|\.png|\.bmp)$/i', $vvv->value) && $vvv->field_type != "multi-file") {
                                if ($vvv->field_type == "file") {
                                    $path = asset('/app_data_images');
                                    $value = $path."/".$vvv->value;
                                }else{
                                    $value = $vvv->value;
                                }
                                $form->$key = $value;
                                if($vvv->field_type == "multi-file"){
                                    if ($vvv->field_type == "multi-file") {
                                        $path = asset('/app_data_images');
                                        $value = $path."/".$vvv->value;
                                        array_push($multi_img, $value);
                                        $form->$key = $multi_img;
                                    }
                                }
                            }
                    }
                    foreach($form_structure as $form){
                        $form = $form->makeHidden(['id','UUID','value','field_name','app_id', 'category_id','form_structure_id', 'created_at','updated_at', 'deleted_at','application_id', 'field_type','created_by', 'updated_by']);
                    }

                    $app->total_request += 1;
                    $app->save();
                    if($form_structure != null && count($form_structure) > 0){
                        return response()->json([
                            'data' => $form_structure,
                            'responce' => 'success',
                            'sucess' => 1,
                            'message' => 'content data get successfully'
                        ]);
                    }else{
                        return response()->json([
                            'data' => [],
                            'responce' => 'success',
                            'sucess' => -1,
                            'message' => 'content data not exits'
                        ]); 
                    }
                }else{
                    return response()->json([
                        'data' => [],
                        'responce' => 'error',
                        'sucess' => 0,
                        'message' => 'application dones not exits'
                    ]);
                }
            }
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }

    public function SubContentList(Request $request)
    {
        try {
            $data = $request->all();
            $get_setting = Settings::where('id', 1)->first();
            $start_time = $get_setting->token_start_time;
            $end_time = $get_setting->token_end_time;
            $date = Carbon::now();
            $date = $date->format('H:i');
            $test_token = (isset($data['test_token']) && $data['test_token']) ? $data['test_token'] : null;
            if($test_token != null){
                if($date >= $start_time && $date <= $end_time){
                    $app = ApplicationData::where('test_token', $data['test_token'])->first();
                    $form_structure = FormStructure::where('application_id', $app->id)->where('field_type', 'sub-form')->first();
                    $field_name_array = $form_structure->field_name;
                    $attrs = [];
                    if($app != null){
                        $cat_id = (isset($data['category_id'])) ? $data['category_id'] : null ;
                        $form_structure = SubAppData::select("*")
                            ->leftJoin("subform_structures", "subform_structures.id", "=", "sub_app_data.sub_form_structure_id")
                            ->where("app_id", $app->id)
                            ->where("app_uuid", $data['sub_form_id']);
                        $form_structure = $form_structure->groupBy('UUID')->get();
                        foreach($form_structure as $form){
                            $get_bunch = SubAppData::select('*')
                                ->leftJoin("subform_structures", "subform_structures.id", "=", "sub_app_data.sub_form_structure_id")
                                ->where("app_id", $app->id)
                                ->where("sub_app_data.status", '1')
                                ->where('UUID', $form->UUID)
                                ->get();
                            foreach($get_bunch as $vvv){
                                $key = $vvv->field_name;
                                // dump($vvv->fieldd->field_type);
                                // if (preg_match('/(\.jpg|\.jpeg|\.png|\.bmp)$/i', $vvv->value)) {
                                if ($vvv->field_type == "file") {
                                    $path = asset('/app_data_images');
                                    $value = $path."/".$vvv->value;
                                }else{
                                    $value = $vvv->value;
                                }
                                $form->$key = $value;
                            }
                        }
                        // dd();
                        foreach($form_structure as $form){
                            $form = $form->makeHidden(['id','UUID','form_id','value','field_name','app_id', 'category_id','sub_form_structure_id', 'created_at','updated_at', 'deleted_at','application_id', 'field_type','created_by', 'updated_by','app_uuid','status']);
                        }
                        if($form_structure != null && count($form_structure) > 0){
                            return response()->json([
                                $field_name_array => $form_structure,
                                // 'data' => $form_structure,
                                'responce' => 'success',
                                'sucess' => 1,
                                'message' => 'content data get successfully'
                            ]);
                        }else{
                            return response()->json([
                                'data' => [],
                                'responce' => 'success',
                                'sucess' => -1,
                                'message' => 'content data not exits'
                            ]); 
                        }
                    }else{
                        return response()->json([
                            'data' => [],
                            'responce' => 'error',
                            'sucess' => 0,
                            'message' => 'application dones not exits'
                        ]);
                    }
                }else{
                    return response()->json([
                        'data' => [],
                        'responce' => 'error',
                        'sucess' => 0,
                        'message' => 'Test token is expired'
                    ]); 
                }
            }else{
                $app = ApplicationData::where('token', $data['token'])->first();
                $form_structure = FormStructure::where('application_id', $app->id)->where('field_type', 'sub-form')->first();
                $field_name_array = $form_structure->field_name;
                $attrs = [];
                if($app != null){
                    $cat_id = (isset($data['category_id'])) ? $data['category_id'] : null ;
                    $form_structure = SubAppData::select("*")
                        ->leftJoin("subform_structures", "subform_structures.id", "=", "sub_app_data.sub_form_structure_id")
                        ->where("app_id", $app->id)
                        ->where("app_uuid", $data['sub_form_id']);
                    $form_structure = $form_structure->groupBy('UUID')->get();
                    foreach($form_structure as $form){
                        $get_bunch = SubAppData::select('*')
                            ->leftJoin("subform_structures", "subform_structures.id", "=", "sub_app_data.sub_form_structure_id")
                            ->where("app_id", $app->id)
                            ->where("sub_app_data.status", '1')
                            ->where('UUID', $form->UUID)
                            ->get();
                        foreach($get_bunch as $vvv){
                            $key = $vvv->field_name;
                            // dump($vvv->fieldd->field_type);
                            // if (preg_match('/(\.jpg|\.jpeg|\.png|\.bmp)$/i', $vvv->value)) {
                            if ($vvv->field_type == "file") {
                                $path = asset('/app_data_images');
                                $value = $path."/".$vvv->value;
                            }else{
                                $value = $vvv->value;
                            }
                            $form->$key = $value;
                        }
                    }
                    // dd();
                    foreach($form_structure as $form){
                        $form = $form->makeHidden(['id','UUID','form_id','value','field_name','app_id', 'category_id','sub_form_structure_id', 'created_at','updated_at', 'deleted_at','application_id', 'field_type','created_by', 'updated_by','app_uuid','status']);
                    }
                    if($form_structure != null && count($form_structure) > 0){
                        return response()->json([
                            $field_name_array => $form_structure,
                            // 'data' => $form_structure,
                            'responce' => 'success',
                            'sucess' => 1,
                            'message' => 'content data get successfully'
                        ]);
                    }else{
                        return response()->json([
                            'data' => [],
                            'responce' => 'success',
                            'sucess' => -1,
                            'message' => 'content data not exits'
                        ]); 
                    }
                }else{
                    return response()->json([
                        'data' => [],
                        'responce' => 'error',
                        'sucess' => 0,
                        'message' => 'application dones not exits'
                    ]);
                }
            }
        } catch (Throwable $e) {
            report($e);
            return false;
        }

    }
}
