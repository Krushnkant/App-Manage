<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{ApplicationData, Category};


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
                $category = Category::where('app_id', $app->id)->where('status', '1')->get();
                dd($category);
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
