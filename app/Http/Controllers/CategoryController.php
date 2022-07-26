<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Field, Category, CategoryFields, ApplicationData, AppUser, CategoryField, FormStructureNew, FormStructureFieldNew, ContentField, ContentSubField, MainContent};
use App\Http\Helpers;
use Yajra\DataTables\DataTables;
use App\Models\{User, UserLogin};


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

    public function copy($id, $catid)
    {

        $main_category = Category::where('id', $catid)->first();
        if ($main_category != null) {
            $FormStructure = FormStructureNew::where('category_id', $main_category->id)->first();
            if ($FormStructure) {
                $structure = new FormStructureNew();
                $structure->app_id = (int)$FormStructure->app_id;
                $structure->parent_id = $FormStructure->parent_id;
                $structure->category_id = $id;
                $structure->form_title = $FormStructure->form_title;
                $structure->status = $FormStructure->status;
                $structure->created_by = $FormStructure->created_by;
                $structure->save();
            }
            if ($structure == true) {
                $FormStructureFields = FormStructureFieldNew::where('form_structure_id', $FormStructure->id)->get();
                foreach ($FormStructureFields as $FormStructureField) {
                    $structurefield = new FormStructureFieldNew();
                    $structurefield->app_id = (int)$FormStructureField->app_id;
                    $structurefield->form_structure_id = $structure->id;
                    $structurefield->field_type = $FormStructureField->field_type;
                    $structurefield->field_name = $FormStructureField->field_name;
                    $structurefield->status = $FormStructureField->status;
                    $structurefield->created_by = $FormStructureField->created_by;
                    $structurefield->save();
                }


                return response()->json(['status' => '200']);
            } else {
                return response()->json(['status' => '400']);
            }
        } else {
            return response()->json(['status' => '400']);
        }
    }

    public function SubContentCopy($id, $catid)
    {
        $FormStructure = FormStructureNew::where('id', $catid)->first();
        if ($FormStructure != null) {
            $structure = new FormStructureNew();
            $structure->app_id = (int)$FormStructure->app_id;
            $structure->parent_id = $id;
            $structure->category_id = $FormStructure->category_id;
            $structure->form_title = $FormStructure->form_title;
            $structure->status = $FormStructure->status;
            $structure->created_by = $FormStructure->created_by;
            $structure->save();
        } else {
            return response()->json(['status' => '400']);
        }
        if ($structure == true) {
            $FormStructureFields = FormStructureFieldNew::where('form_structure_id', $catid)->get();
            foreach ($FormStructureFields as $FormStructureField) {
                $structurefield = new FormStructureFieldNew();
                $structurefield->app_id = (int)$FormStructureField->app_id;
                $structurefield->form_structure_id = $structure->id;
                $structurefield->field_type = $FormStructureField->field_type;
                $structurefield->field_name = $FormStructureField->field_name;
                $structurefield->status = $FormStructureField->status;
                $structurefield->created_by = $FormStructureField->created_by;
                $structurefield->save();
            }
            return response()->json(['status' => '200']);
        } else {
            return response()->json(['status' => '400']);
        }
    }


    public function userdestroy($id)
    {

        $main_user = AppUser::with('user')->where('id', $id)->first();
        // dd($main_user);
        if ($main_user != null) {
            $data = AppUser::where('id', $main_user->id)->delete();

            if ($data == true) {
                return response()->json(['status' => '200', 'user' => $main_user]);
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
        $app_data = ApplicationData::where('id', $id)->first();
        return view('user.category.add', compact('id', 'fields', 'app_data', 'page'));
    }

    public function CategoryList(Request $request)
    {
        $table = $request->all();
        // $data = CategoryFields::with('category','application')->where('app_id', $table['app_id'])->get();
        // $data = Category::with(['category' => function ($query) {
        //     $query->with('fields');
        // }])->where('app_id', $table['app_id'])->get();
        // foreach ($data as $d) {
        //     $d->start_date = $d->created_at->format('d M Y');
        // }
        // dump($table['app_id']);
        $category = Category::where('app_id', $table['app_id'])->get();
        // $data = Category::with('category_field')->where('app_id', $table['app_id'])->get();
        // // dump($data);
        $multi_file = [];
        foreach ($category as $d) {
            $category_content = CategoryField::where('app_id', $table['app_id'])->where('category_id', $d->id)->get();
            $structures_content = FormStructureNew::where('app_id', $table['app_id'])->where('category_id', $d->id)->get();
            foreach ($category_content as $key => $value) {
                // dump($value);
                if ($value->field_type == "multi-file") {
                    array_push($multi_file, $value->field_value);
                }
            }

            $d->start_date = $d->created_at->format('d M Y');
            $d->content = $category_content;
            $d->structures_content = $structures_content;
            $d->multi = $multi_file;
        }
        // dd();
        // $data = [
        //     'category' => $category,
        //     'category_content' => $category_content,
        // ];
        return datatables::of($category)->make(true);
    }

    public function UserList(Request $request)
    {
        $table = $request->all();
        // dd($table);
        //         // $data = CategoryFields::with('category','application')->where('app_id', $table['app_id'])->get();
        $data = AppUser::with('user')->where('app_id', $table['app_id'])->get();
        //dd($data);
        foreach ($data as $d) {
            $d->start_date = $d->created_at->format('d M Y');
            $d->firstname = isset($d->user) ? $d->user->firstname : "";
            // dump($d->created_at);
        }
        // dd($data);
        return datatables::of($data)->make(true);
    }

    public function ChageCategoryStatus($id)
    {
        $category = Category::find($id);
        //dd($category);
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
    public function ChageuserStatus($id)
    {
        $user = User::find($id);
        // dd($user);
        $result = "active";
        if ($user->estatus == '1') {
            $result = "deactive";
            $user->estatus = '2';
        } else {
            $result = "active";
            $user->estatus = '1';
        }
        $user->save();
        // dd($user);
        if ($user != null) {
            // dd($result);
            // response()->json(['status' => '200', 'action' => $result]);
            return response()->json(['status' => '200', 'action' => $result]);
        } else {
            return response()->json(['status' => '400']);
        }
        // if ($user->estatus == '1') {
        //     $user->estatus = '2';
        //     $user->save();
        //     //dd($user);
        //   response()->json(['status' => '200', 'action' => 'deactive']);
        // }
        // if ($user->estatus == '2') {
        //     $user->estatus = '1';
        //     $user->save();
        //     return response()->json(['status' => '200', 'action' => 'active']);
        // }
    }
    public function AddCategoryNew($id)
    {
        $page = "Add Category";
        $fields = Field::where('estatus', 1)->get();
        // dump($fields);
        $categories = Category::where('app_id', $id)->get();
        // dd($categories);
        $app_data = ApplicationData::where('id', $id)->first();
        // dd($app_data);
        return view('user.category.add_new', compact('id', 'fields', 'app_data', 'page', 'categories'));
    }

    public function AddUserNew($id)
    {
        $page = "Add User";
        $users = User::where('estatus', 1)->whereIN('role', ['3', '4'])->get();
        $app_data = ApplicationData::where('id', $id)->where('status', '1')->first();
        $app_user = AppUser::where('app_id', $id)->pluck('user_id')->toArray();
        //dd($app_user);
        return view('user.category.adduser', compact('id', 'users', 'app_data', 'app_user', 'page'));
    }

    public function InsertCategoryNew(Request $request)
    {
        $data = $request->all();

        if (Category::where('app_id', $data['app_id'])->where('title', '=', $data['name'])->exists()) {
            return response()->json(['status' => '300', 'message' => 'title already exist']);
        }

        $auth = Auth()->user();
        $app_id = (isset($data['app_id']) && $data['app_id']) ? $data['app_id'] : null;
        $name = (isset($data['name']) && $data['name']) ? $data['name'] : null;
        $field_key1 = (isset($data['1field_key']) && $data['1field_key']) ? $data['1field_key'] : null;
        $field_value1 = (isset($data['1field_value']) && $data['1field_value']) ? $data['1field_value'] : null;
        $field_key2 = (isset($data['2field_key']) && $data['2field_key']) ? $data['2field_key'] : null;
        $field_value2 = (isset($data['2field_value']) && $data['2field_value']) ? $data['2field_value'] : null;
        $field_key3 = (isset($data['3field_key']) && $data['3field_key']) ? $data['3field_key'] : null;

        if ($field_key1 == null || $field_key1 == "") {
            if ($field_key2 == null || $field_key2 == "") {
                if ($field_key3 == null || $field_key3 == "") {
                    return response()->json(['status' => '300', 'message' => 'Please add Custom Field']);
                }
            }
        }

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

    public function InsertUserNew(Request $request)
    {
        $data = $request->all();

        $auth = Auth()->user();
        $app_id = (isset($data['app_id']) && $data['app_id']) ? $data['app_id'] : null;
        $user_id = (isset($data['user_id']) && $data['user_id']) ? $data['user_id'] : null;
        // $fname = (isset($data['firstname']) && $data['firstname']) ? $data['firstname'] : null;
        // $lname = (isset($data['lastname']) && $data['lastname']) ? $data['lastname'] : null;
        // $field_key1 = (isset($data['1field_key']) && $data['1field_key']) ? $data['1field_key'] : null;
        // $field_value1 = (isset($data['1field_value']) && $data['1field_value']) ? $data['1field_value'] : null;
        // $field_key2 = (isset($data['2field_key']) && $data['2field_key']) ? $data['2field_key'] : null;
        // $field_value2 = (isset($data['2field_value']) && $data['2field_value']) ? $data['2field_value'] : null;
        // $field_key3 = (isset($data['3field_key']) && $data['3field_key']) ? $data['3field_key'] : null;
        // //    $field_value3 = (isset($data['3field_value']) && $data['3field_value']) ? $data['3field_value'] : null;

        // dump($data);

        foreach ($request->user_id as $key => $item) {

            //if($item != "" && $item != null){          
            $insuser = new AppUser();
            $insuser->app_id = (int)$app_id;
            $insuser->user_id = (int)$user_id;
            $insuser->user_id = $item;;
            $insuser->save();
            // }

        }

        // $category->firstname = $fname;
        // $category->lastname = $lname;
        // $category->created_at = $auth->id;

        return response()->json(['status' => '200']);
        // dd( $category);  

    }
    public function EditCategoryNew($id)
    {
        $page = "Edit Category";
        $data = Category::with(['category_field' => function ($query) {
            $query->groupBy('field_key');
        }])->where('id', $id)->first();
        $fields = Field::where('estatus', 1)->get();
        $app_data = ApplicationData::where('id', $data->app_id)->first();
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
        if (Category::where('app_id', $app_id)->where('title', '=', $name)->where('id', '<>', $category_id)->exists()) {
            return response()->json(['status' => '300', 'message' => 'title already exist']);
        }
        $all_id_array = [];
        if ($all_id != "") {
            $all_id_array = explode(",", $all_id);
        }
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

    public function SubFormStructure($cat_id, $app_id, $parent_id)
    {
        // dump($cat_id);
        // dump($app_id);
        // dump($parent_id);
        // dump($prev_id);
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
        return view('user.form_structure.add', compact('page', 'cat_id', 'app_id', 'parent_id', 'form_structure', 'fields', 'already_form', 'form_structure_field'));
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
        $already_form = (isset($data['already_form']) && $data['already_form']) ? $data['already_form'] : 0;
        $deleted = (isset($data['deleted']) && $data['deleted']) ? $data['deleted'] : 0;
        $form_structure_id = (isset($data['form_structure_id']) && $data['form_structure_id']) ? $data['form_structure_id'] : 0;
        // $sub_field_names = (isset($data['sub_field_name']) && $data['sub_field_name']) ? $data['sub_field_name'] : null;

        if ($already_form != 0) {
            $form_structure = FormStructureNew::find($form_structure_id);
            $form_structure->form_title = $form_title;
            $form_structure->updated_by = $auth->id;
            $form_structure->save();

            unset($data['application_id']);
            unset($data['form_structure_id']);
            unset($data['already_form']);
            unset($data['form_title']);
            unset($data['category_id']);
            unset($data['parent_id']);
            unset($data['_token']);

            foreach ($data as $key => $dd_) {
                if (strpos($key, "_sub_name") !== false) {
                    $int_var = (int)filter_var($key, FILTER_SANITIZE_NUMBER_INT);
                    $old_foem_fields = FormStructureFieldNew::find($int_var);
                    $type = $data[$int_var . '_sub_type'];
                    if ($old_foem_fields != null) {
                        $old_foem_fields->app_id = $application_id;
                        $old_foem_fields->form_structure_id = $form_structure_id;
                        $old_foem_fields->field_type = $type;
                        $old_foem_fields->field_name = $dd_;
                        $old_foem_fields->updated_by = $auth->id;
                        $old_foem_fields->save();
                    }
                } else {
                    if (strpos($key, "field_name") !== false) {
                        foreach ($data['field_name'] as $key1 => $field_ex) {
                            $old_foem_fields = new FormStructureFieldNew();
                            $old_foem_fields->app_id = $application_id;
                            $old_foem_fields->form_structure_id = $form_structure_id;
                            $old_foem_fields->field_type = $data['field_type'][$key1];
                            $old_foem_fields->field_name = $field_ex;
                            $old_foem_fields->created_by = $auth->id;
                            $old_foem_fields->save();
                        }
                    }
                }
            }

            if ($deleted != 0) {
                $deleted_ = explode(',', $deleted);
                foreach ($deleted_ as $del) {
                    $delete_content_data = ContentField::where('form_structure_field_id', $del)
                        ->where('status', '1')
                        ->delete();
                    $del_foem_fields = FormStructureFieldNew::find($del);
                    $del_foem_fields->delete();
                }
            }
            return response()->json(['status' => '200', 'action' => 'done']);
        } else {
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
                return response()->json(['status' => '200', 'action' => 'done']);
            }
        }
        // return response()->json(['status' => '200', 'action' => 'done']);
    }

    public function SubContentAdd($cat_id, $app_id, $parent_id)
    {
        // dump($app_id);
        // dump($cat_id);
        // dump($parent_id);
        // dump($prev_id);
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
        // dd($form_structure_field);
        // return view('user.content.add_content', compact('application_id', 'main_form', 'sub_form', 'categories', 'is_category', 'is_sub_formm','application', 'page'));
        return view('user.sub_content.add', compact('application', 'app_id', 'cat_id', 'parent_id', 'main_form', 'form_structure_field', 'categories', 'page', 'is_category', 'selected_cat'));
    }

    public function SubContentInsert(Request $request, $cat_id, $app_id, $parent_id)
    {
        // dump($cat_id);
        // dump($app_id);
        // dd($parent_id);

        $data = $request->all();
        if (MainContent::where('form_structure_id', $data['form_structure_id'])->where('title', '=', $data['title'])->exists()) {
            return response()->json(['status' => '300', 'message' => 'title already exist']);
        }
        // dd($data);
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

        $main_content = new MainContent();
        $main_content->form_structure_id = $form_structure_id;
        $main_content->title = $title;
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
        if (isset($form_structure_get->id)) {
            $data = $data->where('form_structure_id', $form_structure_get->id)
                ->orderBy('id', 'DESC')
                ->groupBy('main_content_id')
                ->get();

            // dd($data);

            foreach ($data as $d) {
                $main_title = MainContent::where('id', $d->main_content_id)->first();
                $d->start_date = $d->created_at->format('d M Y');
                $category_ids = Category::where('id', $form_structure_get->category_id)->where('status', '1')->first();
                $application = ApplicationData::where('id', $form_structure_get->app_id)->where('status', '1')->first();
                // $d->form_title = $form_structure_get->form_title;
                $d->category_name = $category_ids->title;
                $d->app_name = $application->name;
                $d->form_title = $main_title->title;
            }
        } else {
            $data = array();
        }
        return datatables::of($data)->make(true);
    }

    public function SubContentEdit(Request $request, $cat_id, $app_id, $parent_id, $content_id)
    {
        // dump($cat_id);
        // dump($app_id);
        // dump($parent_id);
        // dump($content_id);
        $page = "Edit content";
        $sub_content_table = null;
        $add_new_fields = null;
        $application = ApplicationData::find($app_id);
        $formStructure = FormStructureNew::where('app_id', $app_id)
            ->where('parent_id', $parent_id)
            ->where('category_id', $cat_id)
            ->first();
        // dd($formStructure->id);
        // dd($content_id);
        if ($formStructure != null) {
            $main_content = MainContent::find($content_id);
            $sub_form_structure = FormStructureFieldNew::where('app_id', $app_id)
                ->where('form_structure_id', $formStructure->id)
                ->get();
            $sub_form_structure_id = FormStructureFieldNew::where('app_id', $app_id)
                ->where('form_structure_id', $formStructure->id)
                // ->where('form_structure_id', 2)
                ->get()->pluck('id')->toArray();
            // dump($sub_form_structure_id);

            $check_content_table = ContentField::whereIn('form_structure_field_id', $sub_form_structure_id)
                ->where('app_id', $app_id)
                ->where('main_content_id', $content_id)
                // ->where('form_structure_id', 2)
                ->where('form_structure_id', $formStructure->id)
                // ->get();
                ->get()->pluck('form_structure_field_id')->toArray();
            // dump($check_content_table);
            $result = array_diff($sub_form_structure_id, $check_content_table);
            // dump($result);
            if (count($result) > 0) {
                $add_new_fields = FormStructureFieldNew::whereIn('id', $result)->get();
            }
        }
        $content = ContentField::where('main_content_id', $content_id)->where('app_id', $app_id)->get();
        $content_sub_id = ContentField::where('main_content_id', $content_id)
            ->where('app_id', $app_id)
            ->where('field_value', null)
            ->first();
        if ($content_sub_id != null) {
            $sub_content_table = ContentSubField::where('app_id', $app_id)->where('content_field_id', $content_sub_id->id)->get();
        }
        // dd($add_new_fields);
        return view('user.sub_content.edit', compact('application', 'main_content', 'formStructure', 'content', 'sub_content_table', 'app_id', 'cat_id', 'parent_id', 'page', 'add_new_fields'));
    }

    public function SubContentUpdate(Request $request, $cat_id, $app_id, $parent_id, $structure)
    {
        $data = $request->all();
        // dd($data);
        $auth = Auth()->user();
        $main_content_id = 0;
        $category_new = (isset($data['category_id']) && $data['category_id']) ? $data['category_id'] : null;
        $title = (isset($data['title']) && $data['title']) ? $data['title'] : null;
        $content_id = (isset($data['content_id']) && $data['content_id']) ? $data['content_id'] : null;
        $form_structure_id = (isset($data['form_structure_id']) && $data['form_structure_id']) ? $data['form_structure_id'] : null;
        if (MainContent::where('form_structure_id', $form_structure_id)->where('title', '=', $title)->where('id', '<>', $content_id)->exists()) {
            return response()->json(['status' => '300', 'message' => 'title already exist']);
        }
        $main_content = MainContent::find($content_id);
        $main_content->title = $title;
        $main_content->save();

        unset($data['application_id']);
        unset($data['form_structure_id']);
        unset($data['category_id']);
        unset($data['parent_id']);
        unset($data['title']);
        unset($data['content_id']);
        unset($data['_token']);

        foreach ($data as $key => $dd_) {
            if (strpos($key, "_content") !== false) {
                $int_var = (int)filter_var($key, FILTER_SANITIZE_NUMBER_INT);
                $content = ContentField::find($int_var);
                $main_content_id = $content->main_content_id;

                $content->app_id = $app_id;
                $content->main_content_id = $main_content_id;
                $content->form_structure_id = $form_structure_id;
                $check_val = $content->field_value;
                if ($check_val != "") {
                    if (file_exists($dd_)) {
                        $path = public_path("app_data_images/");
                        $extension = $dd_->extension();
                        $type = null;
                        if (str_contains($extension, 'png') || str_contains($extension, 'jpg') || str_contains($extension, 'jpeg') || str_contains($extension, 'webp')) {
                            $type = 'image';
                        } else {
                            $type = 'video';
                        }
                        $result = Helpers::UploadImage($dd_, $path);
                        $content->field_value = $result;
                        $content->file_type = $type;
                    } else {
                        $content->field_value = $dd_;
                    }
                } else {
                    foreach ($dd_ as $img) {
                        // dump("jijiji");
                        // dump($img);
                        $path = public_path("app_data_images/");
                        $extension = $img->extension();
                        $type = null;
                        if (str_contains($extension, 'png') || str_contains($extension, 'jpg') || str_contains($extension, 'jpeg') || str_contains($extension, 'webp')) {
                            $type = 'image';
                        } else {
                            $type = 'video';
                        }
                        $result = Helpers::UploadImage($img, $path);
                        // dump($result);
                        $content_sub = new ContentSubField();
                        $content_sub->app_id = $app_id;
                        $content_sub->content_field_id = $content->id;
                        $content_sub->field_value = $result;
                        $content_sub->file_type = $type;
                        $content_sub->created_by = $auth->id;
                        $content_sub->save();
                        // dump($content_sub);
                    }
                }
                // dd();
                // if($content->field_value == 'null' && $content->field_value == null){
                //     foreach($dd_ as $img){
                //         dump("jijiji");
                //         dump($img);
                //         $path = public_path("app_data_images/");
                //         $extension = $img->extension();
                //         $type = null;
                //         if (str_contains($extension, 'png') || str_contains($extension, 'jpg') || str_contains($extension, 'jpeg') || str_contains($extension, 'webp')) {
                //             $type = 'image';
                //         } else {
                //             $type = 'video';
                //         }
                //         $result = Helpers::UploadImage($img, $path);
                //         // $content_sub = New ContentSubField();
                //         // $content_sub->content_field_id = $content->id;
                //         // $content_sub->field_value = $result;
                //         // $content_sub->file_type = $type;
                //         // $content_sub->created_by = $auth->id;
                //         // $content_sub->save();
                //     }
                // }else{
                //     dump("opopop");
                //     if (file_exists($dd_)) {
                //         $path = public_path("app_data_images/");
                //         $extension = $dd_->extension();
                //         $type = null;
                //         if (str_contains($extension, 'png') || str_contains($extension, 'jpg') || str_contains($extension, 'jpeg') || str_contains($extension, 'webp')) {
                //             $type = 'image';
                //         } else {
                //             $type = 'video';
                //         }
                //         $result = Helpers::UploadImage($dd_, $path);
                //         $content->field_value = $result;
                //         $content->file_type = $type;
                //     }else{
                //         $content->field_value = $dd_;
                //     }
                // }
                // $content->app_id = $app_id;
                // $content->main_content_id = $main_content_id;
                // $content->form_structure_id = $form_structure_id;
                $content->updated_by = $auth->id;
                $content->save();
                // dd();
            } else {
                if (strpos($key, "_form") !== false) {
                    // dump("new");
                    // dump($key);
                    $int_var = (int)filter_var($key, FILTER_SANITIZE_NUMBER_INT);
                    $content = new ContentField();
                    $content->app_id = $app_id;
                    $content->main_content_id = $content_id;
                    $content->form_structure_id = $form_structure_id;
                    $content->form_structure_field_id = $int_var;
                    $content->created_by = $auth->id;
                    $content->save();
                    if (is_array($dd_)) {
                        foreach ($dd_ as $img) {
                            // dump("jijiji");
                            // dump($img);
                            $path = public_path("app_data_images/");
                            $extension = $img->extension();
                            $type = null;
                            if (str_contains($extension, 'png') || str_contains($extension, 'jpg') || str_contains($extension, 'jpeg') || str_contains($extension, 'webp')) {
                                $type = 'image';
                            } else {
                                $type = 'video';
                            }
                            $result = Helpers::UploadImage($img, $path);
                            // dump($result);
                            $content_sub = new ContentSubField();
                            $content_sub->app_id = $app_id;
                            $content_sub->content_field_id = $content->id;
                            $content_sub->field_value = $result;
                            $content_sub->file_type = $type;
                            $content_sub->created_by = $auth->id;
                            $content_sub->save();
                        }
                    } else {

                        $content = ContentField::find($content->id);
                        if (file_exists($dd_)) {
                            $path = public_path("app_data_images/");
                            $extension = $dd_->extension();
                            $type = null;
                            if (str_contains($extension, 'png') || str_contains($extension, 'jpg') || str_contains($extension, 'jpeg') || str_contains($extension, 'webp')) {
                                $type = 'image';
                            } else {
                                $type = 'video';
                            }
                            $result = Helpers::UploadImage($dd_, $path);
                            // dump($result);
                            $content->field_value = $result;
                            $content->file_type = $form_structure_id;
                        } else {
                            // dump("value only");
                            // dump($dd_);
                            $content->field_value = $dd_;
                        }
                        $content->save();
                    }
                }
            }
        }
        return response()->json(['status' => '200']);
    }

    public function DeleteContentNew($id, $type)
    {
        if ($type == "multi") {
            $sub_content = ContentSubField::where('id', $id)->delete();
        } else {
            $sub_content = ContentField::where('id', $id)->delete();
        }
        if ($sub_content == 1) {
            return response()->json(['status' => '200']);
        } else {
            return response()->json(['status' => '400']);
        }
    }

    public function DeleteSubContentNew($id)
    {

        $main_content = MainContent::where('id', $id)->delete();

        $field_content = ContentField::where('main_content_id', $id)->delete();

        //$sub_content = ContentField::where('id', $id)->delete();

        if ($main_content == 1) {
            return response()->json(['status' => '200']);
        } else {
            return response()->json(['status' => '400']);
        }
    }

    public function ImageDelete($id)
    {
        $category_field = CategoryField::where('id', $id)->first();
        if ($category_field != null) {
            $category_field = $category_field->delete();
            return response()->json(['status' => '200']);
        } else {
            return response()->json(['status' => '400']);
        }
    }

    public function SubContentListGetNew(Request $request, $cat_id, $app_id, $parent_id)
    {
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

        if ($form_structure_get != null) {
            $data = ContentField::with('field_content_s')->where('status', '1')->where('app_id', $app_id);
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

            foreach ($data as $d) {
                $main_title = MainContent::where('id', $d->main_content_id)->first();
                $d->start_date = $d->created_at->format('d M Y');
                $category_ids = Category::where('id', $form_structure_get->category_id)->where('status', '1')->first();
                // dump($category_ids->title);
                $application = ApplicationData::where('id', $form_structure_get->app_id)->where('status', '1')->first();
                // dump($application);
                // $d->form_title = $form_structure_get->form_title; //*** */
                $d->category_name = $category_ids->title;
                if ($application != null) {
                    $d->app_name = $application->name;
                } else {
                    $d->app_name = null;
                }
                $d->form_title = $main_title->title;
                $d->main_content_id = $main_title->id;
                $d->main_content_status = $main_title->status;
            }
            // dd();
            return response()->json(['status' => '200', 'data' => $data]);
        } else {
            return response()->json(['status' => '400']);
        }
    }

    public function ShowOnlyContent($cat_id, $app_id, $parent_id, $content_id)
    {
        $form_structure_get = FormStructureNew::where('app_id', $app_id)
            ->where('parent_id', $parent_id)
            ->where('category_id', $cat_id)
            ->first();
        $main_content = ContentField::where('id', $content_id)->first();
        $data_ = ContentField::with('field_content')->where('status', '1')->where('app_id', $app_id)
            ->where('form_structure_id', $form_structure_get->id)
            ->where('main_content_id', $main_content->main_content_id)
            ->orderBy('id', 'DESC')
            // ->groupBy('main_content_id')
            ->get();

        foreach ($data_ as $d) {
            $sub_content = ContentSubField::where('app_id', $app_id)
                ->where('content_field_id', $d->id)
                ->get();

            $d->multi_files = $sub_content;
            // $main_title = MainContent::where('id', $d->main_content_id)->first();
            // $d->start_date = $d->created_at->format('d M Y');
            // $category_ids = Category::where('id', $form_structure_get->category_id)->where('status', '1')->first();
            // $application = ApplicationData::where('id', $form_structure_get->app_id)->where('status', '1')->first();
            // // $d->form_title = $form_structure_get->form_title;
            // $d->category_name = $category_ids->title;
            // $d->app_name = $application->name;
            // $d->form_title = $main_title->title;
        }

        return response()->json(['status' => '200', 'data' => $data_]);
    }

    public function SearchingApi(Request $request, $cat_id, $app_id, $parent_id)
    {
        $search = $request->all();

        $form_structure_get = FormStructureNew::where('app_id', $app_id)
            ->where('parent_id', $parent_id)
            ->where('category_id', $cat_id)
            ->first();
        if ($form_structure_get != null) {
            $data = ContentField::with('field_content_s')->where('status', '1')->where('app_id', $app_id);
            if (isset($status)) {
                $s = (string) $status;
                $data = $data->where('status', $s);
            }
            $data_ids = $data->where('form_structure_id', $form_structure_get->id)->pluck('main_content_id')->toArray();
            $main_title_id = MainContent::whereIn('id', $data_ids)
                ->where('title', 'LIKE', '%' . $search['content'] . '%')
                ->pluck('id')->toArray();
            $data = $data->where('form_structure_id', $form_structure_get->id)
                ->whereIn('main_content_id', $main_title_id)
                ->orderBy('id', 'DESC')
                ->groupBy('main_content_id')
                ->get();

            foreach ($data as $d) {
                $main_title = MainContent::whereIn('id', $main_title_id)
                    ->where('id', $d->main_content_id)
                    ->first();
                $d->start_date = $d->created_at->format('d M Y');
                $category_ids = Category::where('id', $form_structure_get->category_id)->where('status', '1')->first();
                $application = ApplicationData::where('id', $form_structure_get->app_id)->where('status', '1')->first();
                // $d->form_title = $form_structure_get->form_title; //*** */
                $d->category_name = $category_ids->title;
                if ($application != null) {
                    $d->app_name = $application->name;
                } else {
                    $d->app_name = null;
                }
                $d->form_title = $main_title->title;
                $d->main_content_id = $main_title->id;
                $d->main_content_status = $main_title->status;
            }
            return response()->json(['status' => '200', 'data' => $data]);
        } else {
            return response()->json(['status' => '400']);
        }
    }
}
