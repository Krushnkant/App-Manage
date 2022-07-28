<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Field,FormStructure,SubformStructure};

class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('content.add');
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
        //dd($data);
        $field_names = (isset($data['field_name']) && $data['field_name']) ? $data['field_name'] : null;
        $sub_field_names = (isset($data['sub_field_name']) && $data['sub_field_name']) ? $data['sub_field_name'] : null;

        if($field_names != ""){
            foreach($field_names as $key => $field_name){
                $FormStructures = new FormStructure();
                $FormStructures->application_id = $request->application_id;
                $FormStructures->field_name = $field_name;
                $FormStructures->field_type = $request->field_type[$key];
                $FormStructures->created_by = \Auth::id();
                $FormStructures->save();

                if($request->field_type[$key] == 'sub-form'){
                    foreach($sub_field_names as $subkey => $sub_field_name){
                        $SubFormStructures = new SubformStructure();
                        $SubFormStructures->application_id = $request->application_id;
                        $SubFormStructures->form_id = $FormStructures->id;
                        $SubFormStructures->field_name = $sub_field_name;
                        $SubFormStructures->field_type = $request->sub_field_type[$subkey];
                        $SubFormStructures->created_by = \Auth::id();
                        $SubFormStructures->save();
                    }
                }
            }
            return response()->json(['status' => '200', 'action' => 'done']);
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

    public function addcontent($id)
    {
        $fields = Field::where('estatus', 1)->get();
        return view('user.content.add', compact('id', 'fields'));
    }
}
