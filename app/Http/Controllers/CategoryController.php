<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Field, Category, CategoryFields, ApplicationData, CategoryField};
use App\Http\Helpers;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return view('category.add');
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
       $app_id = (isset($data['app_id']) && $data['app_id']) ? $data['app_id'] : null;
       $name = (isset($data['name']) && $data['name']) ? $data['name'] : null;
       $field_key1 = (isset($data['1field_key']) && $data['1field_key']) ? $data['1field_key'] : null;
       $field_value1 = (isset($data['1field_value']) && $data['1field_value']) ? $data['1field_value'] : null;
       $field_key2 = (isset($data['2field_key']) && $data['2field_key']) ? $data['2field_key'] : null;
       $field_value2 = (isset($data['2field_value']) && $data['2field_value']) ? $data['2field_value'] : null;
       $field_key3 = (isset($data['3field_key']) && $data['3field_key']) ? $data['3field_key'] : null;
       $field_value3 = (isset($data['3field_value']) && $data['3field_value']) ? $data['3field_value'] : null;

    //    dd($data);

        $category = new Category();
        $category->app_id = (int)$app_id;
        $category->title = $name;
        $category->save();

        if($category != null){
            if($field_key1 != null){
                foreach($field_key1 as $key => $field1){
                    $CategoryFields = new CategoryFields();
                    $CategoryFields->app_id = (int)$app_id;
                    $CategoryFields->category_id = $category->id;
                    $CategoryFields->field_id = "1";
                    $CategoryFields->key = $field1;
                    $CategoryFields->value = $field_value1[$key];
                    $CategoryFields->save();
                }
            }
            if($field_key2 != null){
                foreach($field_key2 as $key => $field2){
                    $path = public_path("category_image/");
                    $result = Helpers::UploadImage($field_value2[$key], $path);
                    $CategoryFields = new CategoryFields();
                    $CategoryFields->app_id = (int)$app_id;
                    $CategoryFields->category_id = $category->id;
                    $CategoryFields->field_id = "2";
                    $CategoryFields->key = $field2;
                    $CategoryFields->value = $result;
                    $CategoryFields->save();
                }
            }
            // dump($field_value3);
            // dump($field_key3);
            if($field_key3 != null){
                foreach($field_key3 as $key => $field3){
                    // dump($field3);
                    $path = public_path("category_image/");
                    $result = Helpers::UploadImage($field_value3[$key], $path);
                    $CategoryFields = new CategoryFields();
                    $CategoryFields->app_id = (int)$app_id;
                    $CategoryFields->category_id = $category->id;
                    $CategoryFields->field_id = "3";
                    $CategoryFields->key = $field3;
                    $CategoryFields->value = $result;
                    $CategoryFields->save();
                }
            }
            // dd();
            return response()->json(['status' => '200']);
        }else{
            return response()->json('status', '400');
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
        $page = "Edit Category";
        $data = Category::with(['category' => function($query){
            $query->with('fields');
        }])->where('id', $id)->first();
        $fields = Field::where('estatus', 1)->get();
        $app_data = ApplicationData::where('id', $data->app_id)->where('status', '1')->first();
        return view('user.category.edit', compact('data','fields','id','app_data','page'));
        // dd($get_category);
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
        $data = $request->all();
        
        $app_id = (isset($data['app_id']) && $data['app_id']) ? $data['app_id'] : null;
        $category_id = (isset($data['category_id']) && $data['category_id']) ? $data['category_id'] : null;
        $main_category = Category::where('id', $category_id)->first();
        $name = (isset($data['name']) && $data['name']) ? $data['name'] : $main_category->title;
        unset($data['name']);
        unset($data['val-skill']);
        unset($data['_token']);
        unset($data['app_id']);
        unset($data['category_id']);
        $check_array = [];
        
        $main_category->title = $name;
        $main_category->save();

        $field_key1 = (isset($data['1field_key']) && $data['1field_key']) ? $data['1field_key'] : null;
        $field_value1 = (isset($data['1field_value']) && $data['1field_value']) ? $data['1field_value'] : null;
        $field_key2 = (isset($data['2field_key']) && $data['2field_key']) ? $data['2field_key'] : null;
        $field_value2 = (isset($data['2field_value']) && $data['2field_value']) ? $data['2field_value'] : null;
        $field_key3 = (isset($data['3field_key']) && $data['3field_key']) ? $data['3field_key'] : null;
        $field_value3 = (isset($data['3field_value']) && $data['3field_value']) ? $data['3field_value'] : null;

       if($field_key1 != null){
            foreach($field_key1 as $key => $field1){
                $CategoryFields = new CategoryFields();
                $CategoryFields->app_id = (int)$app_id;
                $CategoryFields->category_id = $category_id;
                $CategoryFields->field_id = "1";
                $CategoryFields->key = $field1;
                $CategoryFields->value = $field_value1[$key];
                $CategoryFields->save();

                array_push($check_array, $CategoryFields->id);
            }
        }
        if($field_key2 != null){
            foreach($field_key2 as $key => $field2){
                $path = public_path("category_image/");
                $result = Helpers::UploadImage($field_value2[$key], $path);
                $CategoryFields = new CategoryFields();
                $CategoryFields->app_id = (int)$app_id;
                $CategoryFields->category_id = $category_id;
                $CategoryFields->field_id = "2";
                $CategoryFields->key = $field2;
                $CategoryFields->value = $result;
                $CategoryFields->save();

                array_push($check_array, $CategoryFields->id);
            }
        }
        if($field_key3 != null){
            foreach($field_key3 as $key => $field3){
                $path = public_path("category_image/");
                $result = Helpers::UploadImage($field_value3[$key], $path);
                $CategoryFields = new CategoryFields();
                $CategoryFields->app_id = (int)$app_id;
                $CategoryFields->category_id = $category_id;
                $CategoryFields->field_id = "3";
                $CategoryFields->key = $field3;
                $CategoryFields->value = $result;
                $CategoryFields->save();

                array_push($check_array, $CategoryFields->id);
            }
        }
        unset($data['1field_key']);
        unset($data['1field_value']);
        unset($data['2field_key']);
        unset($data['2field_value']);
        unset($data['3field_key']);
        unset($data['3field_value']);

        foreach($data as $key => $dd){
            $splitd = explode("_",$key);
            $rocord_id = $splitd[0];
            array_push($check_array, $rocord_id);
        }
        
        $cat_fields = CategoryFields::where('app_id', $app_id)
                                        ->where('category_id', $category_id)
                                        ->whereNotIn('id', $check_array)
                                        ->delete();
        foreach($data as $key => $dd){
            $splitd = explode("_",$key);
            $rocord_id = $splitd[0];
            array_push($check_array, $rocord_id);
            $field_id = $splitd[1];
            $match = $splitd[2];
            $cat_fields = CategoryFields::where('field_id', $field_id)->where('id', $rocord_id)->first();
            if($match == "key"){
                $cat_fields->key = $dd[0];
            }
            if($match == "value"){
                $cat_fields->value = $dd[0];
            }
            if($match == "file"){
                $path = public_path("category_image/");
                $result = Helpers::UploadImage($dd[0], $path);
                $cat_fields->value = $result;
            }
            $cat_fields->save();
        }
        
        return response()->json(['status' => '200']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $main_category = Category::where('id', $id)->first();
        if($main_category != null){
            $cat_fields = CategoryFields::where('category_id', $main_category->id)->delete();
            $data = $main_category->delete();
            if($data == true){
                return response()->json(['status' => '200']);
            }else{
                return response()->json(['status' => '400']);
            }
        }else{
            return response()->json(['status' => '400']);
        }
    }

    public function AddCategory($id)
    {
        $page = "Add Category";
        $fields = Field::where('estatus', 1)->get();
        $app_data = ApplicationData::where('id', $id)->where('status', '1')->first();
        return view('user.category.add', compact('id', 'fields', 'app_data','page'));
    }

    public function CategoryList(Request $request)
    {
        $table = $request->all();
        // $data = CategoryFields::with('category','application')->where('app_id', $table['app_id'])->get();
        $data = Category::with(['category' => function($query){
            $query->with('fields');
        }])->where('app_id', $table['app_id'])->get();
        foreach($data as $d){
            $d->start_date = $d->created_at->format('d M Y');
            // dump($d->created_at);
        }
        // dd();
        return datatables::of($data)->make(true);
    }

    public function ChageCategoryStatus($id)
    {
        $category = Category::find($id);
        if ($category->status== '1'){
            $category->status = '0';
            $category->save();
            return response()->json(['status' => '200','action' =>'deactive']);
        }
        if ($category->status== '0'){
            $category->status = '1';
            $category->save();
            return response()->json(['status' => '200','action' =>'active']);
        }
    }

    public function AddCategoryNew($id)
    {
        $page = "Add Category";
        $fields = Field::where('estatus', 1)->get();
        $app_data = ApplicationData::where('id', $id)->where('status', '1')->first();
        return view('user.category.add_new', compact('id', 'fields', 'app_data', 'page'));
    }

    public function InsertCategoryNew(Request $request)
    {
        $data = $request->all();
        $auth = Auth()->user();
        $app_id = (isset($data['app_id']) && $data['app_id']) ? $data['app_id'] : null;
        $name = (isset($data['name']) && $data['name']) ? $data['name'] : null;
        $field_key1 = (isset($data['1field_key']) && $data['1field_key']) ? $data['1field_key'] : null;
        $field_value1 = (isset($data['1field_value']) && $data['1field_value']) ? $data['1field_value'] : null;
        $field_key2 = (isset($data['2field_key']) && $data['2field_key']) ? $data['2field_key'] : null;
        $field_value2 = (isset($data['2field_value']) && $data['2field_value']) ? $data['2field_value'] : null;
        $field_key3 = (isset($data['3field_key']) && $data['3field_key']) ? $data['3field_key'] : null;
        //    $field_value3 = (isset($data['3field_value']) && $data['3field_value']) ? $data['3field_value'] : null;

        // dump($data);
        $category = new Category();
        $category->app_id = (int)$app_id;
        $category->title = $name;
        $category->created_by = $auth->id;
        $category->save();

        if ($category != null) {
            if ($field_key1 != null) {
                foreach ($field_key1 as $key => $field1) {
                    $CategoryFields = new CategoryField();
                    $CategoryFields->app_id = (int)$app_id;
                    $CategoryFields->category_id = $category->id;
                    $CategoryFields->field_type = "textbox";
                    $CategoryFields->field_key = $field1;
                    $CategoryFields->field_value = $field_value1[$key];
                    $CategoryFields->created_by = $auth->id;
                    $CategoryFields->save();
                }
            }
            if ($field_key2 != null) {
                foreach ($field_key2 as $key => $field2) {
                    $path = public_path("category_image/");
                    $extension = $field_value2[$key]->extension();
                    $type = null;
                    if (str_contains($extension, 'png') || str_contains($extension, 'jpg') || str_contains($extension, 'jpeg')) {
                        $type = 'image';
                    } else {
                        $type = 'video';
                    }
                    // dump($type);
                    $result = Helpers::UploadImage($field_value2[$key], $path);
                    $CategoryFields = new CategoryField();
                    $CategoryFields->app_id = (int)$app_id;
                    $CategoryFields->category_id = $category->id;
                    $CategoryFields->field_type = "file";
                    $CategoryFields->field_key = $field2;
                    $CategoryFields->field_value = $result;
                    $CategoryFields->file_type = $type;
                    $CategoryFields->created_by = $auth->id;
                    $CategoryFields->save();
                }
            }
            if ($field_key3 != null) {
                foreach ($field_key3 as $key1 => $field3) {
                    // $name__ = $key1 . "_3_field_value";
                    $name__ = "3field_value";
                    // dump($data[$name__]);
                    if (isset($data[$name__]) && $data[$name__] != null) {
                        foreach ($data[$name__] as $key2 => $image) {
                            $path = public_path("category_image/");
                            $extension = $image->extension();
                            $type = null;
                            if (str_contains($extension, 'png') || str_contains($extension, 'jpg') || str_contains($extension, 'jpeg')) {
                                $type = 'image';
                            } else {
                                $type = 'video';
                            }
                            $result = Helpers::UploadImage($image, $path);
                            $CategoryFields = new CategoryField();
                            $CategoryFields->app_id = (int)$app_id;
                            $CategoryFields->category_id = $category->id;
                            $CategoryFields->field_type = "multi-file";
                            $CategoryFields->field_key = $field3;
                            $CategoryFields->field_value = $result;
                            $CategoryFields->file_type = $type;
                            $CategoryFields->created_by = $auth->id;
                            $CategoryFields->save();
                        }
                    } else {
                    }
                }
            }
            // dd("opopop");
            return response()->json(['status' => '200']);
        } else {
            return response()->json(['status' => '400']);
        }
    }

    public function EditCategoryNew($id)
    {
        $page = "Edit Category";
        $data = Category::with(['category_field' => function ($query) {
            $query->groupBy('field_key');
        }])->where('id', $id)->first();
        $fields = Field::where('estatus', 1)->get();
        $app_data = ApplicationData::where('id', $data->app_id)->where('status', '1')->first();
        return view('user.category.edit_new', compact('data', 'fields', 'id', 'app_data', 'page'));
    }

    public function UpdateCategoryNew(Request $request, $id)
    {
        $data = $request->all();
        $auth = Auth()->user();
        // dd($data);
        $app_id = (isset($data['app_id']) && $data['app_id']) ? $data['app_id'] : null;
        $all_id = (isset($data['all_id']) && $data['all_id']) ? $data['all_id'] : null;
        $delete_id = (isset($data['delete_id']) && $data['delete_id']) ? $data['delete_id'] : null;
        $category_id = (isset($data['category_id']) && $data['category_id']) ? $data['category_id'] : null;
        $main_category = Category::where('id', $category_id)->first();
        $name = (isset($data['name']) && $data['name']) ? $data['name'] : $main_category->title;
        $all_id_array = [];
        $all_id_array = explode(",",$all_id);
        unset($data['name']);
        unset($data['val-skill']);
        unset($data['_token']);
        unset($data['app_id']);
        unset($data['category_id']);
        $check_array = [];

        $main_category->title = $name;
        $main_category->save();

        $field_key1 = (isset($data['1field_key']) && $data['1field_key']) ? $data['1field_key'] : null;
        $field_value1 = (isset($data['1field_value']) && $data['1field_value']) ? $data['1field_value'] : null;
        $field_key2 = (isset($data['2field_key']) && $data['2field_key']) ? $data['2field_key'] : null;
        $field_value2 = (isset($data['2field_value']) && $data['2field_value']) ? $data['2field_value'] : null;
        $field_key3 = (isset($data['3field_key']) && $data['3field_key']) ? $data['3field_key'] : null;
        $field_value3 = (isset($data['3field_value']) && $data['3field_value']) ? $data['3field_value'] : null;

        foreach($all_id_array as $id){
            $field_name_key = $id."_oldkey";
            $field_name_value = $id."_oldvalue";
            $CategoryFields = CategoryField::find($id);
            $CategoryFields->app_id = (int)$app_id;
            $CategoryFields->category_id = $category_id;
            // $CategoryFields->field_type = "multi-file";
            // $CategoryFields->file_type = $type;
            $CategoryFields->updated_by = $auth->id;
            // $CategoryFields->save();
            if(isset($data[$field_name_key]) && $data[$field_name_key] != null){
                $old_ = CategoryField::where('app_id', $app_id)
                                ->where('category_id',$category_id)
                                ->where('field_type', 'multi-file')
                                ->where('id', $id)
                                ->first();
                // dump($old_);
                if($old_ != null){
                    $old_ = CategoryField::where('app_id', $app_id)
                                    ->where('category_id',$category_id)
                                    ->where('field_type', 'multi-file')
                                    ->where('field_key', $old_->field_key)
                                    ->get();
                    foreach($old_ as $old___){
                        $old___->field_key = $data[$field_name_key];
                        $old___->save();
                    }
                }else{
                    $CategoryFields->field_key = $data[$field_name_key];
                    $CategoryFields->save();
                }
            }
            if(isset($data[$field_name_value]) && $data[$field_name_value] != null){
                if(is_string($data[$field_name_value])){
                    $CategoryFields->field_value = $data[$field_name_value];
                    $CategoryFields->save();
                }else{
                    $path = public_path("category_image/");
                    if(is_array($data[$field_name_value]) == true){
                        // $CategoryFields = CategoryField::where('app_id', $app_id)->where('category_id',$category_id)->where('field_type', 'multi-file')->get();
                        foreach($data[$field_name_value] as $file){
                            $extension = $file->extension();
                            $type = null;
                            if (str_contains($extension, 'png') || str_contains($extension, 'jpg') || str_contains($extension, 'jpeg')) {
                                $type = 'image';
                            } else {
                                $type = 'video';
                            }
                            $result = Helpers::UploadImage($file, $path);
                            $CategoryFields1 = new CategoryField();
                            $CategoryFields1->app_id = (int)$app_id;
                            $CategoryFields1->category_id = $category_id;
                            $CategoryFields1->field_type = "multi-file";
                            $CategoryFields1->field_key = $data[$field_name_key];
                            $CategoryFields1->field_value = $result;
                            $CategoryFields1->file_type = $type;
                            $CategoryFields1->created_by = $auth->id;
                            $CategoryFields1->save();
                        }
                    }else{
                        $extension = $data[$field_name_value]->extension();
                        $type = null;
                        if (str_contains($extension, 'png') || str_contains($extension, 'jpg') || str_contains($extension, 'jpeg')) {
                            $type = 'image';
                        } else {
                            $type = 'video';
                        }
                        $extension = $data[$field_name_value]->extension();
                        $result = Helpers::UploadImage($data[$field_name_value], $path);
                        $CategoryFields->field_value = $result;
                        $CategoryFields->file_type = $type;
                        $CategoryFields->save();
                    }
                }
            }
        }
        foreach($data as $key => $d){
            if (strpos($key, "field_key") !== false) {
                $int_var = (int)filter_var($key, FILTER_SANITIZE_NUMBER_INT);
                $get_value = $int_var."field_value";
                $get_key = $int_var."field_key";
                // dump($data[$get_value]);
                // dump($data[$get_key]);
                foreach($data[$get_value] as $key_ => $value_){
                    if(is_string($value_)){
                        // dump("string");
                        // dump($value_);
                        // dump($data[$get_key][$key_]);
                            $CategoryFields1 = new CategoryField();
                            $CategoryFields1->app_id = (int)$app_id;
                            $CategoryFields1->category_id = $category_id;
                            $CategoryFields1->field_type = "textbox";
                            $CategoryFields1->field_key = $data[$get_key][$key_];
                            $CategoryFields1->field_value = $value_;
                            $CategoryFields1->created_by = $auth->id;
                            $CategoryFields1->save();
                    }else{
                        // dump("array");
                        // dump($value_);
                        // dump($data[$get_key][$key_]);
                        $path = public_path("category_image/");
                        $extension = $value_->extension();
                        $type = null;
                        if (str_contains($extension, 'png') || str_contains($extension, 'jpg') || str_contains($extension, 'jpeg')) {
                            $type = 'image';
                        } else {
                            $type = 'video';
                        }
                        $result = Helpers::UploadImage($value_, $path);
                        $CategoryFields1 = new CategoryField();
                        $CategoryFields1->app_id = (int)$app_id;
                        $CategoryFields1->category_id = $category_id;
                        $CategoryFields1->field_type = "file";
                        $CategoryFields1->field_key = $data[$get_key][$key_];
                        $CategoryFields1->field_value = $result;
                        $CategoryFields1->file_type = $type;
                        $CategoryFields1->created_by = $auth->id;
                        $CategoryFields1->save();
                    }
                }
            }
        }

        if(isset($delete_id) && $delete_id != null){
            $delete_id_array = [];
            $delete_id_array = explode(",",$delete_id);
            foreach($delete_id_array as $del_){
                $del_idd = (int)$del_;
                $new_del = CategoryField::where('app_id', $app_id)->where('category_id',$category_id)->where('id', $del_idd)->first();
                // dump($new_del);
                if($new_del->field_type == "multi-file"){
                    // dump('multi');
                    // $get_all = CategoryField::where('app_id', $app_id)->where('field_key', $new_del->field_key)->where('category_id',$category_id)->where('id', $del_idd)->delete();
                    $get_all = CategoryField::where('app_id', $app_id)
                                            ->where('field_key', $new_del->field_key)
                                            ->where('category_id',$category_id)->delete();
                    // dump($get_all);
                }else{
                    // dump("single");
                    $new_del->delete();
                }
                // dump($new_del);
            }
        }
        return response()->json(['status' => '200']);
    }
}
