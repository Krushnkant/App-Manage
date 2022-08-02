<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Field,FormStructure,SubformStructure, Category, ApplicationData, AppData};
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.content.add_content');
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
        // $uuid = Str::random(30);
        // dd($randomString);
        $field_names = (isset($data['field_name']) && $data['field_name']) ? $data['field_name'] : null;
        $sub_field_names = (isset($data['sub_field_name']) && $data['sub_field_name']) ? $data['sub_field_name'] : null;

        if($field_names != ""){
            foreach($field_names as $key => $field_name){
                $FormStructures = new FormStructure();
                // $FormStructures->UUID = $uuid;
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
        $data = $request->all();
        $application_id = $id;

        // dump($data);
        $main_structure = FormStructure::where('application_id', $application_id)->get()->pluck('id')->toArray();
        $sub_structure = SubformStructure::where('application_id', $application_id)->get()->pluck('id')->toArray();
        $sub_structure_formid = SubformStructure::where('application_id', $application_id)->first();
        if($sub_structure_formid != null){
            $sub_form_id = $sub_structure_formid->form_id;
        }
        $field_names = (isset($data['field_name']) && $data['field_name']) ? $data['field_name'] : null;
        $field_type = (isset($data['field_type']) && $data['field_type']) ? $data['field_type'] : null;
        $sub_field_names = (isset($data['sub_field_name']) && $data['sub_field_name']) ? $data['sub_field_name'] : null;
        $sub_field_type = (isset($data['sub_field_type']) && $data['sub_field_type']) ? $data['sub_field_type'] : null;

        // dump($field_names);
        // dump($field_type);
        // dump($sub_field_names);
        // dd($sub_field_names);
        $from_struucture_array = [];
        $sub_from_struucture_array = [];
        if($field_names != ""){
            foreach($field_names as $key => $field_name){
                $FormStructures = new FormStructure();
                $FormStructures->application_id = $application_id;
                $FormStructures->field_name = $field_name;
                $FormStructures->field_type = $field_type[$key];
                $FormStructures->created_by = \Auth::id();
                $FormStructures->save();

                array_push($from_struucture_array, $FormStructures->id);
                if($field_type[$key] == "sub-form"){
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
                // else{
            }
        }else{
            if($sub_field_type != null){
                foreach($sub_field_names as $subkey => $sub_field_name){
                    $SubFormStructures = new SubformStructure();
                    $SubFormStructures->application_id = $application_id;
                    $SubFormStructures->form_id = $sub_form_id;
                    $SubFormStructures->field_name = $sub_field_name;
                    $SubFormStructures->field_type = $sub_field_type[$subkey];
                    $SubFormStructures->created_by = \Auth::id();
                    $SubFormStructures->save();

                    array_push($sub_from_struucture_array, $SubFormStructures->id);
                }
            }
        }
        unset($data['field_name']);
        unset($data['field_type']);
        unset($data['sub_field_name']);
        unset($data['sub_field_type']);
        unset($data['_token']);
        unset($data['application_id']);
        unset($data['field']);
        unset($data['field-subform']);
        // dd($data);
        foreach($data as $key => $dd){
            $splitd = explode("_",$key);
            $rocord_id = $splitd[0];
            $type = $splitd[1];
            if($type == "main"){
                array_push($from_struucture_array, $rocord_id);
            }
            if($type == "sub"){
                array_push($sub_from_struucture_array, $rocord_id);
            }
        }
        // dump($from_struucture_array);
        // dump($sub_from_struucture_array);
        $subform_remove_form_fields = FormStructure::where('application_id', $application_id)
                        ->where('field_type', 'sub-form')
                        ->whereNotIn('id', $from_struucture_array)
                        ->first();
        $form_fields = FormStructure::where('application_id', $application_id)
                        ->whereNotIn('id', $from_struucture_array)
                        ->delete();
        if($subform_remove_form_fields != null){
            $sub_form_fields = SubformStructure::where('application_id', $application_id)
                                            ->where('form_id', $subform_remove_form_fields->id)
                                            ->delete();
            $subform_remove_form_fields->delete();
        }else{
            $sub_form_fieldss = SubformStructure::where('application_id', $application_id)->first();
            if($sub_form_fieldss != null){
                $form_fields = FormStructure::where('application_id', $application_id)
                                                ->whereNotIn('id', $from_struucture_array)
                                                ->delete();
                $sub_form_fields = SubformStructure::where('application_id', $application_id)
                                                ->where('form_id', $sub_form_id)
                                                ->whereNotIn('id', $sub_from_struucture_array)
                                                ->delete();
                foreach($data as $key => $dd){
                    $splitd = explode("_",$key);
                    $rocord_id = $splitd[0];
                    $type = $splitd[1];
                    $match = $splitd[2];
                    
                    $form_fieldsa = FormStructure::where('application_id', $application_id)->where('id', $rocord_id)->first();
                    $sub_form_fieldsa = SubformStructure::where('application_id', $application_id)->where('id', $rocord_id)->first();
        
                    if($match == "name"){
                        if($type == "main"){
                            $form_fieldsa->field_name = $dd[0];
                            $form_fieldsa->save();
                            array_push($from_struucture_array, $rocord_id);
                        }else if($type == "sub"){
                            array_push($sub_from_struucture_array, $rocord_id);
                            $sub_form_fieldsa->field_name = $dd[0];
                            $sub_form_fieldsa->save();
                        }
                    }
                }
            }
        }

        return response()->json(['status' => '200', 'action' => 'done']);
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

    public function addstructure($id)
    {
        $is_sub = 0;
        $fields = Field::where('estatus', 1)->get();
        $already = FormStructure::with('sub_form')->where('application_id', $id)->get();
        $is_sub = FormStructure::where('application_id', $id)->where('field_type', 'sub-form')->first();
        if($is_sub != null){
            $is_sub = 1;
        }
        $is_form = FormStructure::where('application_id', $id)->first();
        if($is_form != null){
            return view('user.content.edit', compact('id', 'fields', 'already', 'is_sub'));
        }else{
            return view('user.content.add', compact('id', 'fields'));
        }
    }

    public function ContentForm($application_id)
    {
        $main_form = FormStructure::where('application_id', $application_id)->get();
        $sub_form = SubformStructure::where('application_id', $application_id)->get();
        $categories = Category::where('app_id', $application_id)->where('status', '1')->get();
        return view('user.content.add_content', compact('application_id', 'main_form', 'sub_form', 'categories'));
    }

    public function ContentList(Request $request, $id)
    {
        $get_application = ApplicationData::where('id', $id)->where('status', '1')->first();
        $get_app_data = AppData::with('category','application')->select("*")
                        ->leftJoin("form_structures", "form_structures.id", "=", "app_data.form_structure_id")
                        ->where("app_id", $id)
                        ->where("status", 1)
                        ->get()
                        ->groupBy('UUID');
        foreach($get_app_data as $d){
            foreach($d as $rr){
                $rr->start_date = $rr->created_at->format('d M Y');
            }
        }
        return view('user.content.content_list', compact('id','get_app_data'));
    }

    public function ContentGetList(Request $request, $id)
    {
       $data = $request->all();
       $get_application = ApplicationData::where('id', $id)->where('status', '1')->first();
       $get_app_data = AppData::with('category','application')->select("*")
                    ->leftJoin("form_structures", "form_structures.id", "=", "app_data.form_structure_id")
                    ->where("app_id", $id)
                    ->where("status", 1)
                    ->get()
                    ->groupBy('UUID');
        foreach($get_app_data as $d){
            foreach($d as $rr){
                $rr->start_date = $rr->created_at->format('d M Y');
            }
        }
        // return view('user.content.content_list', compact('id'));
        dd($get_app_data);
        // return datatables::of($get_app_data)->make(true);
    }

}
