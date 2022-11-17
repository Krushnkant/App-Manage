<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{ApplicationData, Category, FormStructure, AppData, SubAppData, CategoryFields, Settings, User, FormStructureNew, MainContent, ContentField, FormStructureFieldNew, ContentSubField, CategoryField};
use Carbon\Carbon;
use Illuminate\Console\Application;
use Illuminate\Support\Facades\Validator;

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
            $app = $app->makeHidden(['created_at', 'status']);
            if (preg_match('/(\.jpg|\.jpeg|\.png|\.bmp)$/i', $app->icon)) {
                $path = asset('/app_icons');
                $app->icon = $path . "/" . $app->icon;
            }
            if ($app != null) {
                $count = 1;
                $app->total_request += $count;
                $app->save();
                return response()->json([
                    'data' => $app,
                    'responce' => 'success',
                    'sucess' => 1,
                    'message' => 'application request send successfully'
                ]);
            } else {
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
            if ($test_token != null) {
                if ($date >= $start_time && $date <= $end_time) {
                    $app = ApplicationData::where('test_token', $data['test_token'])->first();
                    if ($app != null) {
                        $category = Category::select('id', 'app_id', 'title', 'status', 'created_at')->where('app_id', $app->id)->where('status', '1')->get();
                        $category = $category->makeHidden(['created_at', 'status']);
                        foreach ($category as $key => $cat) {
                            $category_fields = CategoryFields::with('fields')->where('category_id', $cat->id)->where('status', '1')->get();
                            foreach ($category_fields as $d) {
                                $key = $d->key;
                                // if (preg_match('/(\.jpg|\.jpeg|\.png|\.bmp)$/i', $d->value)) {
                                if ($d->fields->type == "file" || $d->fields->type == "multi-file") {
                                    $path = asset('/category_image');
                                    $value = $path . "/" . $d->value;
                                } else {
                                    $value = $d->value;
                                }
                                $cat->$key = $value;
                            }
                        }
                        $app->cat_total_request += 1;
                        $app->save();
                        if ($category != null && count($category) != 0) {
                            return response()->json([
                                'data' => $category,
                                'responce' => 'success',
                                'sucess' => 1,
                                'message' => 'application request send successfully'
                            ]);
                        } else {
                            return response()->json([
                                'data' => [],
                                'responce' => 'success',
                                'sucess' => -1,
                                'message' => 'category not exits'
                            ]);
                        }
                    } else {
                        return response()->json([
                            'data' => [],
                            'responce' => 'error',
                            'sucess' => 0,
                            'message' => 'application dones not exits'
                        ]);
                    }
                } else {
                    return response()->json([
                        'data' => [],
                        'responce' => 'error',
                        'sucess' => 0,
                        'message' => 'Test token is expired'
                    ]);
                }
            } else {
                $app = ApplicationData::where('token', $data['token'])->first();
                if ($app != null) {
                    $category = Category::select('id', 'app_id', 'title', 'status', 'created_at')->where('app_id', $app->id)->where('status', '1')->get();
                    $category = $category->makeHidden(['created_at', 'status']);
                    foreach ($category as $key => $cat) {
                        $category_fields = CategoryFields::with('fields')->where('category_id', $cat->id)->where('status', '1')->get();
                        foreach ($category_fields as $d) {
                            $key = $d->key;
                            // if (preg_match('/(\.jpg|\.jpeg|\.png|\.bmp)$/i', $d->value)) {
                            if ($d->fields->type == "file" || $d->fields->type == "multi-file") {
                                $path = asset('/category_image');
                                $value = $path . "/" . $d->value;
                            } else {
                                $value = $d->value;
                            }
                            $cat->$key = $value;
                        }
                    }
                    $app->cat_total_request += 1;
                    $app->save();
                    if ($category != null && count($category) != 0) {
                        return response()->json([
                            'data' => $category,
                            'responce' => 'success',
                            'sucess' => 1,
                            'message' => 'application request send successfully'
                        ]);
                    } else {
                        return response()->json([
                            'data' => [],
                            'responce' => 'success',
                            'sucess' => -1,
                            'message' => 'category not exits'
                        ]);
                    }
                } else {
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
            if ($test_token != null) {
                if ($date >= $start_time && $date <= $end_time) {
                    $app = ApplicationData::where('test_token', $data['test_token'])->first();
                    if ($app != null) {
                        $cat_id = (isset($data['category_id'])) ? $data['category_id'] : null;
                        $form_structure = AppData::select('*', 'UUID as sub_form_id')
                            ->leftJoin("form_structures", "form_structures.id", "=", "app_data.form_structure_id")
                            ->where("app_id", $app->id)
                            ->where("app_data.status", '1');
                        if ($cat_id != null && $cat_id != 0) {
                            $form_data = $form_structure->where('category_id', $cat_id);
                        } elseif ($cat_id == 0 && $cat_id != null) {
                            $form_data = $form_structure->where('category_id', '!=', null);
                        } elseif ($cat_id == null) {
                            $form_data = $form_structure->where('category_id', null);
                        }
                        $form_structure = $form_data->groupBy('UUID')->get();
                        // dd($form_structure);
                        foreach ($form_structure as $form) {
                            $get_bunch = AppData::select('*')
                                ->leftJoin("form_structures", "form_structures.id", "=", "app_data.form_structure_id")
                                ->where("app_id", $app->id)
                                ->where("app_data.status", '1')
                                ->where('UUID', $form->UUID)
                                ->get();
                            $multi_img = [];
                            foreach ($get_bunch as $vvv) {
                                $key = $vvv->field_name;
                                // if (preg_match('/(\.jpg|\.jpeg|\.png|\.bmp)$/i', $vvv->value) && $vvv->field_type != "multi-file") {
                                if ($vvv->field_type == "file") {
                                    $path = asset('/app_data_images');
                                    $value = $path . "/" . $vvv->value;
                                } else {
                                    $value = $vvv->value;
                                }
                                $form->$key = $value;
                                if ($vvv->field_type == "multi-file") {
                                    if ($vvv->field_type == "multi-file") {
                                        $path = asset('/app_data_images');
                                        $value = $path . "/" . $vvv->value;
                                        array_push($multi_img, $value);
                                        $form->$key = $multi_img;
                                    }
                                }
                            }
                        }
                        foreach ($form_structure as $form) {
                            $form = $form->makeHidden(['id', 'UUID', 'value', 'field_name', 'app_id', 'category_id', 'form_structure_id', 'created_at', 'updated_at', 'deleted_at', 'application_id', 'field_type', 'created_by', 'updated_by']);
                        }

                        $app->total_request += 1;
                        $app->save();
                        if ($form_structure != null && count($form_structure) > 0) {
                            return response()->json([
                                'data' => $form_structure,
                                'responce' => 'success',
                                'sucess' => 1,
                                'message' => 'content data get successfully'
                            ]);
                        } else {
                            return response()->json([
                                'data' => [],
                                'responce' => 'success',
                                'sucess' => -1,
                                'message' => 'content data not exits'
                            ]);
                        }
                    } else {
                        return response()->json([
                            'data' => [],
                            'responce' => 'error',
                            'sucess' => 0,
                            'message' => 'application dones not exits'
                        ]);
                    }
                } else {
                    return response()->json([
                        'data' => [],
                        'responce' => 'error',
                        'sucess' => 0,
                        'message' => 'Test token is expired'
                    ]);
                }
            } else {
                $app = ApplicationData::where('token', $data['token'])->first();
                if ($app != null) {
                    $cat_id = (isset($data['category_id'])) ? $data['category_id'] : null;
                    $form_structure = AppData::select('*', 'UUID as sub_form_id')
                        ->leftJoin("form_structures", "form_structures.id", "=", "app_data.form_structure_id")
                        ->where("app_id", $app->id)
                        ->where("app_data.status", '1');
                    if ($cat_id != null && $cat_id != 0) {
                        $form_data = $form_structure->where('category_id', $cat_id);
                    } elseif ($cat_id == 0 && $cat_id != null) {
                        $form_data = $form_structure->where('category_id', '!=', null);
                    } elseif ($cat_id == null) {
                        $form_data = $form_structure->where('category_id', null);
                    }
                    $form_structure = $form_data->groupBy('UUID')->get();
                    // dd($form_structure);
                    foreach ($form_structure as $form) {
                        $get_bunch = AppData::select('*')
                            ->leftJoin("form_structures", "form_structures.id", "=", "app_data.form_structure_id")
                            ->where("app_id", $app->id)
                            ->where("app_data.status", '1')
                            ->where('UUID', $form->UUID)
                            ->get();
                        $multi_img = [];
                        foreach ($get_bunch as $vvv) {
                            $key = $vvv->field_name;
                            // if (preg_match('/(\.jpg|\.jpeg|\.png|\.bmp)$/i', $vvv->value) && $vvv->field_type != "multi-file") {
                            if ($vvv->field_type == "file") {
                                $path = asset('/app_data_images');
                                $value = $path . "/" . $vvv->value;
                            } else {
                                $value = $vvv->value;
                            }
                            $form->$key = $value;
                            if ($vvv->field_type == "multi-file") {
                                if ($vvv->field_type == "multi-file") {
                                    $path = asset('/app_data_images');
                                    $value = $path . "/" . $vvv->value;
                                    array_push($multi_img, $value);
                                    $form->$key = $multi_img;
                                }
                            }
                        }
                    }
                    foreach ($form_structure as $form) {
                        $form = $form->makeHidden(['id', 'UUID', 'value', 'field_name', 'app_id', 'category_id', 'form_structure_id', 'created_at', 'updated_at', 'deleted_at', 'application_id', 'field_type', 'created_by', 'updated_by']);
                    }

                    $app->total_request += 1;
                    $app->save();
                    if ($form_structure != null && count($form_structure) > 0) {
                        return response()->json([
                            'data' => $form_structure,
                            'responce' => 'success',
                            'sucess' => 1,
                            'message' => 'content data get successfully'
                        ]);
                    } else {
                        return response()->json([
                            'data' => [],
                            'responce' => 'success',
                            'sucess' => -1,
                            'message' => 'content data not exits'
                        ]);
                    }
                } else {
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
            if ($test_token != null) {
                if ($date >= $start_time && $date <= $end_time) {
                    $app = ApplicationData::where('test_token', $data['test_token'])->first();
                    $form_structure = FormStructure::where('application_id', $app->id)->where('field_type', 'sub-form')->first();
                    $field_name_array = $form_structure->field_name;
                    $attrs = [];
                    if ($app != null) {
                        $cat_id = (isset($data['category_id'])) ? $data['category_id'] : null;
                        $form_structure = SubAppData::select("*")
                            ->leftJoin("subform_structures", "subform_structures.id", "=", "sub_app_data.sub_form_structure_id")
                            ->where("app_id", $app->id)
                            ->where("app_uuid", $data['sub_form_id']);
                        $form_structure = $form_structure->groupBy('UUID')->get();
                        foreach ($form_structure as $form) {
                            $get_bunch = SubAppData::select('*')
                                ->leftJoin("subform_structures", "subform_structures.id", "=", "sub_app_data.sub_form_structure_id")
                                ->where("app_id", $app->id)
                                ->where("sub_app_data.status", '1')
                                ->where('UUID', $form->UUID)
                                ->get();
                            foreach ($get_bunch as $vvv) {
                                $key = $vvv->field_name;
                                // dump($vvv->fieldd->field_type);
                                // if (preg_match('/(\.jpg|\.jpeg|\.png|\.bmp)$/i', $vvv->value)) {
                                if ($vvv->field_type == "file") {
                                    $path = asset('/app_data_images');
                                    $value = $path . "/" . $vvv->value;
                                } else {
                                    $value = $vvv->value;
                                }
                                $form->$key = $value;
                            }
                        }
                        // dd();
                        foreach ($form_structure as $form) {
                            $form = $form->makeHidden(['id', 'UUID', 'form_id', 'value', 'field_name', 'app_id', 'category_id', 'sub_form_structure_id', 'created_at', 'updated_at', 'deleted_at', 'application_id', 'field_type', 'created_by', 'updated_by', 'app_uuid', 'status']);
                        }
                        if ($form_structure != null && count($form_structure) > 0) {
                            return response()->json([
                                $field_name_array => $form_structure,
                                // 'data' => $form_structure,
                                'responce' => 'success',
                                'sucess' => 1,
                                'message' => 'content data get successfully'
                            ]);
                        } else {
                            return response()->json([
                                'data' => [],
                                'responce' => 'success',
                                'sucess' => -1,
                                'message' => 'content data not exits'
                            ]);
                        }
                    } else {
                        return response()->json([
                            'data' => [],
                            'responce' => 'error',
                            'sucess' => 0,
                            'message' => 'application dones not exits'
                        ]);
                    }
                } else {
                    return response()->json([
                        'data' => [],
                        'responce' => 'error',
                        'sucess' => 0,
                        'message' => 'Test token is expired'
                    ]);
                }
            } else {
                $app = ApplicationData::where('token', $data['token'])->first();
                $form_structure = FormStructure::where('application_id', $app->id)->where('field_type', 'sub-form')->first();
                $field_name_array = $form_structure->field_name;
                $attrs = [];
                if ($app != null) {
                    $cat_id = (isset($data['category_id'])) ? $data['category_id'] : null;
                    $form_structure = SubAppData::select("*")
                        ->leftJoin("subform_structures", "subform_structures.id", "=", "sub_app_data.sub_form_structure_id")
                        ->where("app_id", $app->id)
                        ->where("app_uuid", $data['sub_form_id']);
                    $form_structure = $form_structure->groupBy('UUID')->get();
                    foreach ($form_structure as $form) {
                        $get_bunch = SubAppData::select('*')
                            ->leftJoin("subform_structures", "subform_structures.id", "=", "sub_app_data.sub_form_structure_id")
                            ->where("app_id", $app->id)
                            ->where("sub_app_data.status", '1')
                            ->where('UUID', $form->UUID)
                            ->get();
                        foreach ($get_bunch as $vvv) {
                            $key = $vvv->field_name;
                            // dump($vvv->fieldd->field_type);
                            // if (preg_match('/(\.jpg|\.jpeg|\.png|\.bmp)$/i', $vvv->value)) {
                            if ($vvv->field_type == "file") {
                                $path = asset('/app_data_images');
                                $value = $path . "/" . $vvv->value;
                            } else {
                                $value = $vvv->value;
                            }
                            $form->$key = $value;
                        }
                    }
                    // dd();
                    foreach ($form_structure as $form) {
                        $form = $form->makeHidden(['id', 'UUID', 'form_id', 'value', 'field_name', 'app_id', 'category_id', 'sub_form_structure_id', 'created_at', 'updated_at', 'deleted_at', 'application_id', 'field_type', 'created_by', 'updated_by', 'app_uuid', 'status']);
                    }
                    if ($form_structure != null && count($form_structure) > 0) {
                        return response()->json([
                            $field_name_array => $form_structure,
                            // 'data' => $form_structure,
                            'responce' => 'success',
                            'sucess' => 1,
                            'message' => 'content data get successfully'
                        ]);
                    } else {
                        return response()->json([
                            'data' => [],
                            'responce' => 'success',
                            'sucess' => -1,
                            'message' => 'content data not exits'
                        ]);
                    }
                } else {
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

    public function GetContentList(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'parent_id' => 'required',
                'application_id' => 'required',
                'token' => 'required',
                // 'test_token' => 'required',
                // 'user_id' => 'required',
                'category_id' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'success'   => false,
                    'message'   => 'Validation errors',
                    'data'      => $validator->errors()
                ]);
            } else {
                $data = $request->all();
                
                $check_application = ApplicationData::where('id', $data['application_id'])
                    ->where('status', '1')
                    ->where('token', $data['token'])
                    ->orWhere('test_token', $data['token'])
                    ->first();
                $all_category = [];
                if ($check_application != null) {
                    if(!isset($data['is_application']) || $data['is_application'] == 0){
                        if ($data['category_id'] == 0 && $data['parent_id'] == 0) {
                            $category = Category::where('app_id', $data['application_id'])->where('status', '1')->get();
                            foreach ($category as $cat) {
                                 
                                

                                // dump($cat);
                                $category_fields = CategoryField::where('app_id', $data['application_id'])
                                    ->where('category_id', $cat->id)->where('field_type', 'multi-file')->get();

                                $category_fields__ = CategoryField::where('app_id', $data['application_id'])
                                    ->where('category_id', $cat->id)->where('field_type', 'multi-file')->first();
                                $multi_image = [];
                                foreach ($category_fields as $img) {
                                    $path = asset('/category_image');
                                    $value = $path . "/" . $img->field_value;
                                    array_push($multi_image, $value);
                                }
                                $category_fields_ = CategoryField::where('app_id', $data['application_id'])
                                    ->where('category_id', $cat->id)->get();
                                $i = 0;
                                foreach ($category_fields_ as $key => $field_) {
                                    $field_->title = $cat->title;
                                    if ($field_->field_type != "multi-file") {
                                        $type = $field_->field_type;
                                        $field_->type = $type;
                                        $key = $field_->field_key;
                                        $field_->$key = $field_->field_value;
                                    }
                                    if ($field_->field_type == "multi-file") {
                                        if ($i == 0) {
                                            $type = $field_->field_type;
                                            $field_->type = $type;
                                            $key = $field_->field_key;
                                            $field_->$key = $multi_image;
                                        }
                                        $i++;
                                    }
                                    unset(
                                        $field_['id'],
                                        $field_['app_id'],
                                        $field_['type'],
                                        // $field_['category_id'],
                                        $field_['field_type'],
                                        $field_['field_key'],
                                        $field_['field_value'],
                                        $field_['file_type'],
                                        $field_['status'],
                                        $field_['created_by'],
                                        $field_['updated_by'],
                                        $field_['deleted_at'],
                                        $field_['created_at'],
                                        $field_['updated_at'],
                                    );
                                }
                                $cat->fields = $category_fields_;
                                array_push($all_category, $category_fields_);
                                unset(
                                    // $cat['id'],
                                    $cat['app_id'],
                                    $cat['status'],
                                    $cat['created_by'],
                                    $cat['updated_by'],
                                    $cat['created_at'],
                                    $cat['updated_at'],
                                    $cat['deleted_at'],
                                );
                            }
                            // dd($all_category);
                            $main_category_ = [];
                            foreach ($all_category as $key => $sub) {
                                if (count($sub) > 0) {
                                    $array = json_decode(json_encode($sub), true);
                                    $result = array();
                                    foreach ($array as $array1) {
                                        $result = array_merge($result, $array1);
                                    }
                                    array_push($main_category_, $result);
                                }
                            }
                            if ($main_category_ != null) {
                                return response()->json([
                                    'data' => $main_category_,
                                    'responce' => 'sucess',
                                    'sucess' => 1,
                                    'message' => "category list get successful"
                                ]);
                            } else {
                                return response()->json([
                                    'data' => [],
                                    'responce' => 'error',
                                    'sucess' => -1,
                                    'message' => "can't fetch category list"
                                ]);
                            }
                        } else {
                            $form_ = FormStructureNew::where('app_id', $check_application->id)
                                ->where('parent_id', $data['parent_id'])
                                ->where('category_id', $data['category_id'])->first();
                            if ($form_ != null) {
                                $content = MainContent::where('form_structure_id', $form_->id)->get();
                                $all_content = array();
                                foreach ($content as $main) {
                                    // dump($main);
                                    $content_field = ContentField::where('form_structure_id', $form_->id)
                                        ->where('main_content_id', $main->id)
                                        ->get();
                                    $content_field_first = ContentField::where('app_id', $check_application->id)
                                        ->where('form_structure_id', $form_->id)
                                        ->where('main_content_id', $main->id)
                                        ->first();

                                    $multi_image = [];
                                    foreach ($content_field as $key => $content) {
                                        if ($key == 0) {
                                            if ($content_field_first != null) {
                                                $content->parent_id = $content_field_first->id;
                                            }
                                        }
                                        $content->title = $main->title;
                                        $form_structure = FormStructureFieldNew::where('app_id', $check_application->id)
                                            ->where('form_structure_id', $form_->id)
                                            ->where('id', $content->form_structure_field_id)
                                            ->where('status', '1')
                                            ->first();
                                        $key = $form_structure->field_name;
                                        $content->type = $form_structure->field_type;
                                        if ($form_structure->field_type == "file") {
                                            $path = asset('/app_data_images');
                                            $value = $path . "/" . $content->field_value;
                                            $content->$key = $value;
                                        } elseif ($form_structure->field_type == "multi-file") {
                                            $get_multi_file_content = ContentSubField::where('app_id', $check_application->id)
                                                ->where('content_field_id', $content->id)
                                                ->get();
                                            foreach ($get_multi_file_content as $multi_files) {
                                                $path = asset('/app_data_images');
                                                $value = $path . "/" . $multi_files->field_value;
                                                array_push($multi_image, $value);
                                            }
                                            $content->$key = $multi_image;
                                        } else {
                                            $content->$key = $content->field_value;
                                        }
                                        unset(
                                            $content['id'],
                                            $content['file_type'],
                                            $content['type'],
                                            $content['app_id'],
                                            $content['main_content_id'],
                                            $content['form_structure_id'],
                                            $content['form_structure_field_id'],
                                            $content['field_value'],
                                            $content['form_structure_id'],
                                            $content['status'],
                                            $content['created_by'],
                                            $content['updated_by'],
                                            $content['deleted_at'],
                                            $content['created_at'],
                                            $content['updated_at'],
                                        );
                                    }
                                    array_push($all_content, $content_field);
                                }
                                // dd();
                                $main_content_ = [];
                                foreach ($all_content as $key => $sub) {
                                    if (count($sub) > 0) {
                                        $array = json_decode(json_encode($sub), true);

                                        $result = array();
                                        foreach ($array as $array1) {
                                            $result = array_merge($result, $array1);
                                        }
                                        array_push($main_content_, $result);
                                    }
                                }
                                return response()->json([
                                    'data' => $main_content_,
                                    'responce' => 'sucess',
                                    'sucess' => 1,
                                    'message' => "content list get successful"
                                ]);
                            } else {
                                return response()->json([
                                    'data' => [],
                                    'responce' => 'sucess',
                                    'sucess' => 1,
                                    'message' => "no data here"
                                ]);
                            }
                        }
                    }else{
                        $category = Category::where('app_id', $data['application_id'])->where('status', '1')->get();
                            foreach ($category as $cat) {
                                // dump($cat);
                                $getcontent = $this->getcontent($cat->id,$data['application_id'],0);
                                $category_fields = CategoryField::where('app_id', $data['application_id'])
                                    ->where('category_id', $cat->id)->where('field_type', 'multi-file')->get();

                                $category_fields__ = CategoryField::where('app_id', $data['application_id'])
                                    ->where('category_id', $cat->id)->where('field_type', 'multi-file')->first();
                                $multi_image = [];
                                foreach ($category_fields as $img) {
                                    $path = asset('/category_image');
                                    $value = $path . "/" . $img->field_value;
                                    array_push($multi_image, $value);
                                }
                                $category_fields_ = CategoryField::where('app_id', $data['application_id'])
                                    ->where('category_id', $cat->id)->get();
                                $i = 0;
                                foreach ($category_fields_ as $key => $field_) {
                                    $field_->title = $cat->title;
                                    $field_->sub_content = $getcontent;
                                    if ($field_->field_type != "multi-file") {
                                        $type = $field_->field_type;
                                        $field_->type = $type;
                                        $key = $field_->field_key;
                                        $field_->$key = $field_->field_value;
                                    }
                                    if ($field_->field_type == "multi-file") {
                                        if ($i == 0) {
                                            $type = $field_->field_type;
                                            $field_->type = $type;
                                            $key = $field_->field_key;
                                            $field_->$key = $multi_image;
                                        }
                                        $i++;
                                    }
                                    unset(
                                        $field_['id'],
                                        $field_['app_id'],
                                        $field_['type'],
                                        // $field_['category_id'],
                                        $field_['field_type'],
                                        $field_['field_key'],
                                        $field_['field_value'],
                                        $field_['file_type'],
                                        $field_['status'],
                                        $field_['created_by'],
                                        $field_['updated_by'],
                                        $field_['deleted_at'],
                                        $field_['created_at'],
                                        $field_['updated_at'],
                                    );
                                }
                                $cat->fields = $category_fields_;
                                array_push($all_category, $category_fields_);
                                unset(
                                    // $cat['id'],
                                    $cat['app_id'],
                                    $cat['status'],
                                    $cat['created_by'],
                                    $cat['updated_by'],
                                    $cat['created_at'],
                                    $cat['updated_at'],
                                    $cat['deleted_at'],
                                );
                            }
                            $main_category_ = [];
                            foreach ($all_category as $key => $sub) {
                                if (count($sub) > 0) {
                                    $array = json_decode(json_encode($sub), true);
                                    $result = array();
                                    foreach ($array as $array1) {
                                        $result = array_merge($result, $array1);
                                    }
                                    array_push($main_category_, $result);
                                }
                            }
                            if ($main_category_ != null) {
                                return response()->json([
                                    'data' => $main_category_,
                                    'responce' => 'sucess',
                                    'sucess' => 1,
                                    'message' => "category list get successful"
                                ]);
                            } else {
                                return response()->json([
                                    'data' => [],
                                    'responce' => 'error',
                                    'sucess' => -1,
                                    'message' => "can't fetch category list"
                                ]);
                            }
                    }
                } else {
                    return response()->json([
                        'data' => [],
                        'responce' => 'error',
                        'sucess' => -1,
                        'message' => 'application not found'
                    ]);
                }
            }
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }

    public function getcontent($cat_id,$app_id,$parent_id)
    {
        $main_content_ = [];
        $form_ = FormStructureNew::where('app_id', $app_id)
                                ->where('parent_id', $parent_id)
                                ->where('category_id', $cat_id)->first();
                               
                            if ($form_ != null) {
                                $content = MainContent::where('form_structure_id', $form_->id)->get();
                                $all_content = array();
                                foreach ($content as $main) {
                                    // dump($main);
                                    $content_field = ContentField::where('form_structure_id', $form_->id)
                                        ->where('main_content_id', $main->id)
                                        ->get();
                                    $content_field_first = ContentField::where('app_id', $app_id)
                                        ->where('form_structure_id', $form_->id)
                                        ->where('main_content_id', $main->id)
                                        ->first();

                                    $multi_image = [];
                                    foreach ($content_field as $key => $content) {
                                        if ($key == 0) {
                                            if ($content_field_first != null) {
                                                $content->parent_id = $content_field_first->id;
                                                
                                            }

                                        }
                                        $content->title = $main->title;
                                        if ($key == 0) {
                                            if ($content_field_first != null) {
                                                $content->sub_content = $this->getcontent($cat_id,$app_id,$content->parent_id);
                                            }
                                        }
                                       
                                        $form_structure = FormStructureFieldNew::where('app_id', $app_id)
                                            ->where('form_structure_id', $form_->id)
                                            ->where('id', $content->form_structure_field_id)
                                            ->where('status', '1')
                                            ->first();
                                        $key = $form_structure->field_name;
                                        $content->type = $form_structure->field_type;
                                        if ($form_structure->field_type == "file") {
                                            $path = asset('/app_data_images');
                                            $value = $path . "/" . $content->field_value;
                                            $content->$key = $value;
                                        } elseif ($form_structure->field_type == "multi-file") {
                                            $get_multi_file_content = ContentSubField::where('app_id', $app_id)
                                                ->where('content_field_id', $content->id)
                                                ->get();
                                            foreach ($get_multi_file_content as $multi_files) {
                                                $path = asset('/app_data_images');
                                                $value = $path . "/" . $multi_files->field_value;
                                                array_push($multi_image, $value);
                                            }
                                            $content->$key = $multi_image;
                                        } else {
                                            $content->$key = $content->field_value;
                                        }
                                        unset(
                                            $content['id'],
                                            $content['file_type'],
                                            $content['type'],
                                            $content['app_id'],
                                            $content['main_content_id'],
                                            $content['form_structure_id'],
                                            $content['form_structure_field_id'],
                                            $content['field_value'],
                                            $content['form_structure_id'],
                                            $content['status'],
                                            $content['created_by'],
                                            $content['updated_by'],
                                            $content['deleted_at'],
                                            $content['created_at'],
                                            $content['updated_at'],
                                        );
                                    }
                                    array_push($all_content, $content_field);
                                }
                                // dd();
                                $main_content_ = [];
                                foreach ($all_content as $key => $sub) {
                                    if (count($sub) > 0) {
                                        $array = json_decode(json_encode($sub), true);

                                        $result = array();
                                        foreach ($array as $array1) {
                                            $result = array_merge($result, $array1);
                                        }
                                        array_push($main_content_, $result);
                                    }
                                }
                                
                            }
                            return $main_content_;

    }
}
