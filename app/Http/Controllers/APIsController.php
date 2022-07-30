<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{ApplicationData, Category, FormStructure, AppData, SubAppData};


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
            $app = ApplicationData::where('app_id',$data['app_id'])->where('token', $data['token'])->first();
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
            $app = ApplicationData::where('app_id',$data['app_id'])->where('token', $data['token'])->first();
            if($app != null){
                $category = Category::where('app_id', $app->id)->where('status', '0')->get();
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
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }

    public function ContentList(Request $request)
    {
        try {
            $data = $request->all();
            $app = ApplicationData::where('app_id',$data['app_id'])->where('token', $data['token'])->first();
            if($app != null){
                $cat_id = (isset($data['category_id'])) ? $data['category_id'] : null ;
                if($cat_id != null && $cat_id != 0){
                    $form_structure = AppData::select("*")
                    ->leftJoin("form_structures", "form_structures.id", "=", "app_data.form_structure_id")
                    ->where('category_id', $cat_id)
                    ->where("app_id", $app->id)
                    ->where("status", 1)
                    ->get();
                }elseif($cat_id == 0 || $cat_id == null){
                    $form_structure = AppData::select("*")
                    ->leftJoin("form_structures", "form_structures.id", "=", "app_data.form_structure_id")
                    ->where('category_id','!=',null)
                    ->where("app_id", $app->id)
                    ->where("status", 1)
                    ->get();
                }
                if($form_structure != null){
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
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }

    public function SubContentList(Request $request)
    {
        try {
            $data = $request->all();
            $app = ApplicationData::where('app_id',$data['app_id'])->where('token', $data['token'])->first();
            $attrs = [];
            if($app != null){
                $cat_id = (isset($data['category_id'])) ? $data['category_id'] : null ;
                if($cat_id != null && $cat_id != 0){
                    $form_structure = SubAppData::select("*")
                    ->leftJoin("subform_structures", "subform_structures.id", "=", "sub_app_data.sub_form_structure_id")
                    ->where("app_id", $app->id)
                    ->where("category_id", $cat_id)
                    ->where("subform_structures.form_id", $data['sub_form_id'])
                    ->where("status", 1)
                    ->get()
                    ->groupBy("UUID");
                }elseif($cat_id == 0 || $cat_id == null){
                    $form_structure = SubAppData::select("*")
                    ->leftJoin("subform_structures", "subform_structures.id", "=", "sub_app_data.sub_form_structure_id")
                    ->where('category_id','!=',null)
                    ->where("app_id", $app->id)
                    ->where("subform_structures.form_id", $data['sub_form_id'])
                    ->where("status", 1)
                    ->get()
                    ->groupBy("UUID");
                }
                if($form_structure != null){
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
        } catch (Throwable $e) {
            report($e);
            return false;
        }

    }
}
