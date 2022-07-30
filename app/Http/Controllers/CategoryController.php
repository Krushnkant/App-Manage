<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Field, Category, CategoryFields};
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
            if($field_key3 != null){
                foreach($field_key3 as $key => $field3){
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
        $data = Category::with(['category' => function($query){
            $query->with('fields');
        }])->where('id', $id)->first();
        $fields = Field::where('estatus', 1)->get();
        return view('user.category.edit', compact('data','fields'));
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
        
        $name = (isset($data['name']) && $data['name']) ? $data['name'] : $main_category->title;
        $app_id = (isset($data['app_id']) && $data['app_id']) ? $data['app_id'] : null;
        $category_id = (isset($data['category_id']) && $data['category_id']) ? $data['category_id'] : null;
        $main_category = Category::where('id', $category_id)->first();
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
        $fields = Field::where('estatus', 1)->get();
        return view('user.category.add', compact('id', 'fields'));
    }

    public function CategoryList(Request $request)
    {
        $table = $request->all();
        // $data = CategoryFields::with('category','application')->where('app_id', $table['app_id'])->get();
        $data = Category::with('category')->where('app_id', $table['app_id'])->get();
        foreach($data as $d){
            $d->start_date = $d->created_at->format('d M Y');
            // dump($d->created_at);
        }
        // dd();
        return datatables::of($data)->make(true);
    }
}
