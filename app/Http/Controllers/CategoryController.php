<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Field, Category, CategoryFields, ApplicationData, CategoryField, FormStructureNew, FormStructureFieldNew, ContentField, ContentSubField, MainContent};
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

        if ($category != null) {
            if ($field_key1 != null) {
                foreach ($field_key1 as $key => $field1) {
                    $CategoryFields = new CategoryFields();
                    $CategoryFields->app_id = (int)$app_id;
                    $CategoryFields->category_id = $category->id;
                    $CategoryFields->field_id = "1";
                    $CategoryFields->key = $field1;
                    $CategoryFields->value = $field_value1[$key];
                    $CategoryFields->save();
                }
            }
            if ($field_key2 != null) {
                foreach ($field_key2 as $key => $field2) {
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
            if ($field_key3 != null) {
                foreach ($field_key3 as $key => $field3) {
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
        } else {
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
        $data = Category::with(['category' => function ($query) {
            $query->with('fields');
        }])->where('id', $id)->first();
        $fields = Field::where('estatus', 1)->get();
        $app_data = ApplicationData::where('id', $data->app_id)->where('status', '1')->first();
        return view('user.category.edit', compact('data', 'fields', 'id', 'app_data', 'page'));
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

        if ($field_key1 != null) {
            foreach ($field_key1 as $key => $field1) {
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
        if ($field_key2 != null) {
            foreach ($field_key2 as $key => $field2) {
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
        if ($field_key3 != null) {
            foreach ($field_key3 as $key => $field3) {
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

        foreach ($data as $key => $dd) {
            $splitd = explode("_", $key);
            $rocord_id = $splitd[0];
            array_push($check_array, $rocord_id);
        }

        $cat_fields = CategoryFields::where('app_id', $app_id)
            ->where('category_id', $category_id)
            ->whereNotIn('id', $check_array)
            ->delete();
        foreach ($data as $key => $dd) {
            $splitd = explode("_", $key);
            $rocord_id = $splitd[0];
            array_push($check_array, $rocord_id);
            $field_id = $splitd[1];
            $match = $splitd[2];
            $cat_fields = CategoryFields::where('field_id', $field_id)->where('id', $rocord_id)->first();
            if ($match == "key") {
                $cat_fields->key = $dd[0];
            }
            if ($match == "value") {
                $cat_fields->value = $dd[0];
            }
            if ($match == "file") {
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
        if ($main_category != null) {
            $cat_fields = CategoryFields::where('category_id', $main_category->id)->delete();
            $data = $main_category->delete();
            if ($data == true) {
                return response()->json(['status' => '200']);
            } else {
                return response()->json(['status' => '400']);
            }
        } else {
            return response()->json(['status' => '400']);
        }
    }

    public function AddCategory($id)
    {
        $page = "Add Category";
        $fields = Field::where('estatus', 1)->get();
        $app_data = ApplicationData::where('id', $id)->where('status', '1')->first();
        return view('user.category.add', compact('id', 'fields', 'app_data', 'page'));
    }

    public function CategoryList(Request $request)
    {
        $table = $request->all();
        // $data = CategoryFields::with('category','application')->where('app_id', $table['app_id'])->get();
        $data = Category::with(['category' => function ($query) {
            $query->with('fields');
        }])->where('app_id', $table['app_id'])->get();
        foreach ($data as $d) {
            $d->start_date = $d->created_at->format('d M Y');
            // dump($d->created_at);
        }
        // dd();
        return datatables::of($data)->make(true);
    }

    public function ChageCategoryStatus($id)
    {
        $category = Category::find($id);
        if ($category->status == '1') {
            $category->status = '0';
            $category->save();
            return response()->json(['status' => '200', 'action' => 'deactive']);
        }
        if ($category->status == '0') {
            $category->status = '1';
            $category->save();
            return response()->json(['status' => '200', 'action' => 'active']);
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
        $all_id_array = explode(",", $all_id);
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

        foreach ($all_id_array as $id) {
            $field_name_key = $id . "_oldkey";
            $field_name_value = $id . "_oldvalue";
            $CategoryFields = CategoryField::find($id);
            $CategoryFields->app_id = (int)$app_id;
            $CategoryFields->category_id = $category_id;
            // $CategoryFields->field_type = "multi-file";
            // $CategoryFields->file_type = $type;
            $CategoryFields->updated_by = $auth->id;
            // $CategoryFields->save();
            if (isset($data[$field_name_key]) && $data[$field_name_key] != null) {
                $old_ = CategoryField::where('app_id', $app_id)
                    ->where('category_id', $category_id)
                    ->where('field_type', 'multi-file')
                    ->where('id', $id)
                    ->first();
                // dump($old_);
                if ($old_ != null) {
                    $old_ = CategoryField::where('app_id', $app_id)
                        ->where('category_id', $category_id)
                        ->where('field_type', 'multi-file')
                        ->where('field_key', $old_->field_key)
                        ->get();
                    foreach ($old_ as $old___) {
                        $old___->field_key = $data[$field_name_key];
                        $old___->save();
                    }
                } else {
                    $CategoryFields->field_key = $data[$field_name_key];
                    $CategoryFields->save();
                }
            }
            if (isset($data[$field_name_value]) && $data[$field_name_value] != null) {
                if (is_string($data[$field_name_value])) {
                    $CategoryFields->field_value = $data[$field_name_value];
                    $CategoryFields->save();
                } else {
                    $path = public_path("category_image/");
                    if (is_array($data[$field_name_value]) == true) {
                        // $CategoryFields = CategoryField::where('app_id', $app_id)->where('category_id',$category_id)->where('field_type', 'multi-file')->get();
                        foreach ($data[$field_name_value] as $file) {
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
                    } else {
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
        foreach ($data as $key => $d) {
            if (strpos($key, "field_key") !== false) {
                $int_var = (int)filter_var($key, FILTER_SANITIZE_NUMBER_INT);
                $get_value = $int_var . "field_value";
                $get_key = $int_var . "field_key";
                // dump($data[$get_value]);
                // dump($data[$get_key]);
                foreach ($data[$get_value] as $key_ => $value_) {
                    if (is_string($value_)) {
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
                    } else {
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

        if (isset($delete_id) && $delete_id != null) {
            $delete_id_array = [];
            $delete_id_array = explode(",", $delete_id);
            foreach ($delete_id_array as $del_) {
                $del_idd = (int)$del_;
                $new_del = CategoryField::where('app_id', $app_id)->where('category_id', $category_id)->where('id', $del_idd)->first();
                // dump($new_del);
                if ($new_del->field_type == "multi-file") {
                    // dump('multi');
                    // $get_all = CategoryField::where('app_id', $app_id)->where('field_key', $new_del->field_key)->where('category_id',$category_id)->where('id', $del_idd)->delete();
                    $get_all = CategoryField::where('app_id', $app_id)
                        ->where('field_key', $new_del->field_key)
                        ->where('category_id', $category_id)->delete();
                    // dump($get_all);
                } else {
                    // dump("single");
                    $new_del->delete();
                }
                // dump($new_del);
            }
        }
        return response()->json(['status' => '200']);
    }

    public function SubContent($app_id, $cat_id, $parent_id)
    {

        // dump($app_id);
        // dump($cat_id);
        // dd($parent_id);
        $page = "Category Sub Content";
        $content = null;
        $category = Category::find($cat_id);
        $application = ApplicationData::find($app_id);
        $form_structure = FormStructureNew::where('app_id', $app_id)
            ->where('parent_id', $parent_id)
            ->where('category_id', $cat_id)
            ->first();
        if ($form_structure != null) {
            $content = ContentField::where('app_id', $app_id)->where('form_structure_id', $form_structure->id)->get();
        }
        // dump($app_id);
        // dump($cat_id);
        // dd($parent_id);
        return view('user.sub_content.list', compact('page', 'cat_id', 'app_id', 'parent_id', 'content'));
    }

    public function AddContent($cat_id, $app_id, $parent_id)
    {
        $page = "Category Add Content";
        return view('user.sub_content.list', compact('page', 'cat_id', 'app_id', 'parent_id'));
    }

    public function SubFormStructure($app_id, $cat_id, $parent_id)
    {
        // dump($cat_id);
        // dump($app_id);
        // dd($parent_id);
        $page = "Sub Form Structure";
        $fields = Field::get();
        $already_form = 0;
        $form_structure_field = null;
        $form_structure = FormStructureNew::where('app_id', $app_id)
            ->where('parent_id', $parent_id)
            ->where('category_id', $cat_id)
            ->first();
        if ($form_structure != null) {
            $already_form = 1;
            $form_structure_field = FormStructureFieldNew::where('app_id', $app_id)
                ->where('form_structure_id', $form_structure->id)->get();
        }
        // dd($form_structure);
        return view('user.form_structure.add', compact('page', 'cat_id', 'app_id', 'parent_id', 'fields', 'already_form', 'form_structure_field'));
    }

    public function SubContentStore(Request $request, $app_id, $cat_id, $parent_id)
    {
        $data = $request->all();
        // dd($data);
        $auth = Auth()->user();
        $field_names = (isset($data['field_name']) && $data['field_name']) ? $data['field_name'] : null;
        $field_type = (isset($data['field_type']) && $data['field_type']) ? $data['field_type'] : null;
        $application_id = (isset($data['application_id']) && $data['application_id']) ? $data['application_id'] : null;
        $form_title = (isset($data['form_title']) && $data['form_title']) ? $data['form_title'] : null;
        // $sub_field_names = (isset($data['sub_field_name']) && $data['sub_field_name']) ? $data['sub_field_name'] : null;

        if ($parent_id != 0) {
        }
        if ($field_names != "") {
            $FormStructures = new FormStructureNew();
            $FormStructures->app_id = $application_id;
            $FormStructures->parent_id = $request->parent_id;
            $FormStructures->category_id = $request->category_id;
            $FormStructures->form_title = $form_title;
            $FormStructures->created_by = $auth->id;
            $FormStructures->save();

            foreach ($field_names as $key => $field_name) {
                $FormStructuresField = new FormStructureFieldNew();
                $FormStructuresField->app_id = $application_id;
                $FormStructuresField->form_structure_id = $FormStructures->id;
                $FormStructuresField->field_type = $field_type[$key];
                $FormStructuresField->field_name = $field_name;
                $FormStructuresField->created_by = $field_type[$key];
                $FormStructuresField->save();
            }
        }
        // dump($id);
        // dd($request->all());
        return response()->json(['status' => '200', 'action' => 'done']);
    }

    public function SubContentAdd($app_id, $cat_id, $parent_id)
    {
        // dump($app_id);
        // dump($cat_id);
        // dd($parent_id);
        $page = "Add Content";
        $is_category = 0;
        $selected_cat = 0;
        $is_sub_formm = 0;
        $form_structure_field = null;
        $application = ApplicationData::find($app_id);
        $categories_ = Category::where('id', $cat_id)->first();
        if ($categories_ != null) {
            $is_category = 1;
            $selected_cat = $categories_->id;
        }
        $categories = Category::get();
        $main_form = FormStructureNew::where('app_id', $app_id)
                                ->where('parent_id', $parent_id)
                                ->where('category_id', $cat_id)
                                ->first();
        // dd($main_form);
        if ($main_form != null) {
            $form_structure_field = FormStructureFieldNew::where('app_id', $app_id)
                ->where('form_structure_id', $main_form->id)
                ->get();
        }
        // return view('user.content.add_content', compact('application_id', 'main_form', 'sub_form', 'categories', 'is_category', 'is_sub_formm','application', 'page'));
        return view('user.sub_content.add', compact('application', 'app_id', 'cat_id', 'parent_id', 'main_form', 'form_structure_field', 'categories', 'page', 'is_category', 'selected_cat'));
    }

    public function SubContentInsert(Request $request, $cat_id, $app_id, $parent_id)
    {
        // dump($cat_id);
        // dump($app_id);
        // dd($parent_id);
        $data = $request->all();
        $auth = Auth()->user();
        $content_id = 0;
        $category_new = (isset($data['category']) && $data['category']) ? $data['category'] : null;
        $title = (isset($data['title']) && $data['title']) ? $data['title'] : null;
        $form_structure_id = (isset($data['form_structure_id']) && $data['form_structure_id']) ? $data['form_structure_id'] : null;
        unset($data['application_id']);
        unset($data['form_structure_id']);
        unset($data['category_id']);
        unset($data['parent_id']);
        unset($data['category']);
        unset($data['title']);
        unset($data['_token']);
        
        $main_content = New MainContent();
        $main_content->form_structure_id = $form_structure_id;
        $main_content->save();

        foreach ($data as $key => $dd_) {
            if (strpos($key, "_form") !== false) {
                $int_var = (int)filter_var($key, FILTER_SANITIZE_NUMBER_INT);
                // dump($int_var);

                $content = new ContentField();
                $content->app_id = $app_id;
                $content->main_content_id = $main_content->id;
                $content->form_structure_id = $form_structure_id;
                if (is_string($dd_)) {
                    // dump("string value");
                    // dump($dd_);
                    $content->form_structure_field_id = $int_var;
                    $content->field_value = $dd_;
                    $content->created_by = $auth->id;
                    $content->save();
                    $content_id = $content->id;
                } else {
                    if (is_array($dd_) == true) {
                        // dump("multi image");
                        // dump($dd_);
                        $content->form_structure_field_id = $int_var;
                        $content->field_value = null;
                        $content->file_type = 'image';
                        $content->created_by = $auth->id;
                        $content->save();

                        foreach ($dd_ as $img) {
                            $path = public_path("app_data_images/");
                            $extension = $img->extension();
                            $type = null;
                            if (str_contains($extension, 'png') || str_contains($extension, 'jpg') || str_contains($extension, 'jpeg') || str_contains($extension, 'webp')) {
                                $type = 'image';
                            } else {
                                $type = 'video';
                            }
                            $result = Helpers::UploadImage($img, $path);
                            $content_sub = new ContentSubField();
                            $content_sub->app_id = $app_id;
                            $content_sub->content_field_id = $content->id;
                            $content_sub->field_value = $result;
                            $content_sub->file_type = $type;
                            $content_sub->created_by = $auth->id;
                            $content_sub->save();
                            $content_id = $content->id;
                        }
                    } else {
                        // dump("image");
                        // dump($dd_);
                        $path = public_path("app_data_images/");
                        $extension = $dd_->extension();
                        $type = null;
                        if (str_contains($extension, 'png') || str_contains($extension, 'jpg') || str_contains($extension, 'jpeg')) {
                            $type = 'image';
                        } else {
                            $type = 'video';
                        }
                        $result = Helpers::UploadImage($dd_, $path);
                        $content->form_structure_field_id = $int_var;
                        $content->field_value = $result;
                        $content->file_type = $type;
                        $content->created_by = $auth->id;
                        $content->save();
                        $content_id = $content->id;
                    }
                }
            }
        }

        $get_content = ContentField::find($content_id);
        if ($get_content != null) {
            return response()->json(['status' => '200']);
        } else {
            return response()->json(['status' => '400']);
        }
    }

    public function SubContentListGet(Request $request, $cat_id, $app_id, $parent_id)
    {
        // dump($cat_id);
        // dump($app_id);
        // dump($parent_id);
        // dd($form_structure_id);
        // $form_structure_get = FormStructureNew::where('app_id', $app_id)
        //             ->where('parent_id', $parent_id)
        //             ->where('category_id', $cat_id)
        //             ->first();
        // $content_list = ContentField::where('app_id', $app_id)
        //                 ->where('form_structure_id', $form_structure_get->id)
        //                 ->get();

        // new
        $tab_type = $request->tab_type;
        if ($tab_type == "active_application_tab") {
            $status = 1;
        } elseif ($tab_type == "deactive_application_tab") {
            $status = 0;
        }
        $form_structure_get = FormStructureNew::where('app_id', $app_id)
            ->where('parent_id', $parent_id)
            ->where('category_id', $cat_id)
            ->first();
        // dd($form_structure_get);

        $data = ContentField::where('status', '1')->where('app_id', $app_id);
        // $data = ContentField::where('status', '1')->where('app_id', $app_id)->where('form_structure_id', $form_structure_get->id)->get();
        // dd($data);
        if (isset($status)) {
            $s = (string) $status;
            $data = $data->where('status', $s);
        }
        if (!empty($request->get('search'))) {
            $search = $request->get('search');
            // $search_val = $search['value'];
            // $data = $data->where('name', 'Like', '%' . $search_val . '%')
            //     ->orWhere('app_id', 'Like', '%' . $search_val . '%')
            //     ->orWhere('package_name', 'Like', '%' . $search_val . '%');
        }

        $data = $data->where('form_structure_id', $form_structure_get->id)
            ->orderBy('id', 'DESC')
            ->groupBy('main_content_id')
            ->get();

        // dd($data);

        foreach ($data as $d) {
            $d->start_date = $d->created_at->format('d M Y');
            $category_ids = Category::where('id', $form_structure_get->category_id)->where('status', '1')->first();
            $application = ApplicationData::where('id', $form_structure_get->app_id)->where('status', '1')->first();
            $d->form_title = $form_structure_get->form_title;
            $d->category_name = $category_ids->title;
            $d->app_name = $application->name;
        }

        return datatables::of($data)->make(true);
    }
}
