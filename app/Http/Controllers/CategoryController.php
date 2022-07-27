<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Field, Category, CategoryFields};
use App\Http\Helpers;

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

       dump($data['app_id']);
       dump($data['name']);
       dump($data['1field_key']);
       dump($data['1field_value']);
       dump($data['2field_key']);
       dump($data['2field_value']);
       dump($data['3field_key']);
       dump($data['3field_value']);

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
                    $path = public_path("category_thumb/");
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
            return response()->json(['status' => '200', 'action' => 'done']);
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

    public function AddCategory($id)
    {
        $fields = Field::where('estatus', 1)->get();
        return view('user.category.add', compact('id', 'fields'));
    }
}
