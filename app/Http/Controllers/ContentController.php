<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Field,FormStructure,SubformStructure, Category, ApplicationData, AppData, SubAppData};
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use Carbon\Carbon;

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
        // dump($data);
        // $uuid = Str::random(30);
        // dd($randomString);
        $field_names = (isset($data['field_name']) && $data['field_name']) ? $data['field_name'] : null;
        $sub_field_names = (isset($data['sub_field_name']) && $data['sub_field_name']) ? $data['sub_field_name'] : null;

        // dump($field_names);
        // dd($sub_field_names);
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
    public function edit($id, $uuid)
    {
        $page = "Edit Content";
        $application = ApplicationData::find($id);
        $app_data = AppData::with('fieldd')->where('UUID', $uuid)->where('app_id', $id)->get();
        $sub_app_data = SubAppData::with('fieldd')->where('app_id', $id)->where('app_uuid', $uuid)->get();
        $categories = Category::where('app_id', $id)->where('status', '1')->get();
        // dd($app_data);
        return view('user.content.edit_content', compact('id','app_data', 'sub_app_data', 'categories','application', 'page'));
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

        // dd($data);
        $field_names = (isset($data['field_name']) && $data['field_name']) ? $data['field_name'] : null;
        $field_type = (isset($data['field_type']) && $data['field_type']) ? $data['field_type'] : null;
        $sub_field_names = (isset($data['sub_field_name']) && $data['sub_field_name']) ? $data['sub_field_name'] : null;
        $sub_field_type = (isset($data['sub_field_type']) && $data['sub_field_type']) ? $data['sub_field_type'] : null;
        // $UUID_main = (isset($data['UUID-main']) && $data['UUID-main']) ? $data['UUID-main'] : null;
        $main_structure = FormStructure::where('application_id', $application_id)->get()->pluck('id')->toArray();
        $sub_structure = SubformStructure::where('application_id', $application_id)->get()->pluck('id')->toArray();
        $sub_structure_formid = SubformStructure::where('application_id', $application_id)->first();
        if($sub_structure_formid != null && !empty($sub_structure_formid)){
            $sub_form_id = $sub_structure_formid->form_id;
        }
        $get_all_content = AppData::where('app_id', $application_id)->groupBy('UUID')->get();
        $get_all_content_if = AppData::where('app_id', $application_id)->first();
        $get_all_sub_content = SubAppData::where('app_id', $application_id)->groupBy('UUID')->get();
        $get_all_sub_content_if = SubAppData::where('app_id', $application_id)->first();
        
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

                if($get_all_content != null && !empty($get_all_content)){
                    foreach($get_all_content as $content){
                        $app_data = new AppData();
                        $app_data->UUID = $content->UUID;
                        $app_data->app_id = $content->app_id;
                        $app_data->category_id = $content->category_id;
                        $app_data->form_structure_id = $FormStructures->id;
                        $app_data->value = " ";
                        $app_data->save();
                    }
                }

                array_push($from_struucture_array, $FormStructures->id);
                // if($field_type[$key] == "sub-form"){
                //     foreach($sub_field_names as $subkey => $sub_field_name){
                //         $SubFormStructures = new SubformStructure();
                //         $SubFormStructures->application_id = $request->application_id;
                //         $SubFormStructures->form_id = $FormStructures->id;
                //         $SubFormStructures->field_name = $sub_field_name;
                //         $SubFormStructures->field_type = $request->sub_field_type[$subkey];
                //         $SubFormStructures->created_by = \Auth::id();
                //         $SubFormStructures->save();

                //         if($get_all_sub_content_if != null && !empty($get_all_sub_content_if)){
                //             foreach($get_all_sub_content as $sub_content){
                //                 $sub_app_data = new SubAppData();
                //                 $sub_app_data->app_id = $sub_content->application_id;
                //                 $sub_app_data->category_id = $sub_content->category_id;
                //                 $sub_app_data->app_uuid = $sub_content->app_uuid;
                //                 $sub_app_data->UUID = $sub_content->UUID;
                //                 $sub_app_data->sub_form_structure_id = $SubFormStructures->id;
                //                 $sub_app_data->value = " ";
                //                 $sub_app_data->save();
                //             }
                //         }else{
                //             if($get_all_content_if != null && !empty($get_all_content_if)){
                //                 $ddd = 0;
                //                 foreach($get_all_content as $content){
                //                     $current_timestamp = Carbon::now()->timestamp;
                //                     $sub_app_data = new SubAppData();
                //                     $sub_app_data->app_id = $content->app_id;
                //                     $sub_app_data->category_id = $content->category_id;
                //                     $sub_app_data->app_uuid = $content->UUID;
                //                     $sub_app_data->UUID = $current_timestamp."_s".$ddd;
                //                     $sub_app_data->sub_form_structure_id = $SubFormStructures->id;
                //                     $sub_app_data->value = " ";
                //                     $sub_app_data->save();
                //                     $ddd ++;
                //                 }
                //             }
                //         }
                //     }
                // }
            }
        }
        // else{
        //     if($sub_structure_formid != null && !empty($sub_structure_formid)){
        //         if($sub_field_type != null){
        //             foreach($sub_field_names as $subkey => $sub_field_name){
        //                 $SubFormStructures = new SubformStructure();
        //                 $SubFormStructures->application_id = $application_id;
        //                 $SubFormStructures->form_id = $sub_form_id;
        //                 $SubFormStructures->field_name = $sub_field_name;
        //                 $SubFormStructures->field_type = $sub_field_type[$subkey];
        //                 $SubFormStructures->created_by = \Auth::id();
        //                 $SubFormStructures->save();

        //                 array_push($sub_from_struucture_array, $SubFormStructures->id);
        //             }
        //         }
        //     }
        // }
        if($sub_field_names != null){
            $main_structure_ = FormStructure::where('application_id', $application_id)->where('field_type', 'sub-form')->where('status', 1)->first();
            foreach($sub_field_names as $subkey => $sub_field_name){
                $SubFormStructures = new SubformStructure();
                $SubFormStructures->application_id = $application_id;
                $SubFormStructures->form_id = $main_structure_->id;
                $SubFormStructures->field_name = $sub_field_name;
                $SubFormStructures->field_type = $request->sub_field_type[$subkey];
                $SubFormStructures->created_by = \Auth::id();
                $SubFormStructures->save();
                array_push($sub_from_struucture_array, $SubFormStructures->id);
                if($get_all_sub_content_if != null && !empty($get_all_sub_content_if)){
                    foreach($get_all_sub_content as $sub_content){
                        $sub_app_data = new SubAppData();
                        $sub_app_data->app_id = $application_id;
                        $sub_app_data->category_id = $sub_content->category_id;
                        $sub_app_data->app_uuid = $sub_content->app_uuid;
                        $sub_app_data->UUID = $sub_content->UUID;
                        $sub_app_data->sub_form_structure_id = $SubFormStructures->id;
                        $sub_app_data->value = " ";
                        $sub_app_data->save();
                    }
                }else{
                    if($get_all_content_if != null && !empty($get_all_content_if)){
                        $ddd = 0;
                        foreach($get_all_content as $content){
                            $current_timestamp = Carbon::now()->timestamp;
                            $sub_app_data = new SubAppData();
                            $sub_app_data->app_id = $content->app_id;
                            $sub_app_data->category_id = $content->category_id;
                            $sub_app_data->app_uuid = $content->UUID;
                            $sub_app_data->UUID = $current_timestamp."_s".$ddd;
                            $sub_app_data->sub_form_structure_id = $SubFormStructures->id;
                            $sub_app_data->value = " ";
                            $sub_app_data->save();
                            $ddd ++;
                        }
                    }
                }
            }
        }
        // else{
        //     if($sub_structure_formid != null && !empty($sub_structure_formid)){
        //         if($sub_field_type != null){
        //             foreach($sub_field_names as $subkey => $sub_field_name){
        //                 $SubFormStructures = new SubformStructure();
        //                 $SubFormStructures->application_id = $application_id;
        //                 $SubFormStructures->form_id = $sub_form_id;
        //                 $SubFormStructures->field_name = $sub_field_name;
        //                 $SubFormStructures->field_type = $sub_field_type[$subkey];
        //                 $SubFormStructures->created_by = \Auth::id();
        //                 $SubFormStructures->save();

        //                 array_push($sub_from_struucture_array, $SubFormStructures->id);
        //             }
        //         }
        //     }
        // }
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
        if($sub_from_struucture_array != null){
            $subform_remove_form_fields = SubformStructure::where('application_id', $application_id)
                ->whereNotIn('id', $sub_from_struucture_array)
                ->get()->pluck('id')->toArray();
            $delete_sub_form_data = SubAppData::whereIn('sub_form_structure_id', $subform_remove_form_fields)
                ->where('app_id', $application_id)->delete();
            // dump($delete_sub_form_data);
            $delete_subform_remove_form_fields = SubformStructure::where('application_id', $application_id)
                ->whereNotIn('id', $sub_from_struucture_array)->delete();
                
        }

        if($from_struucture_array != null){
            $subform_remove_form_fields_1 = FormStructure::where('application_id', $application_id)
                ->whereNotIn('id', $from_struucture_array)
                ->get()->pluck('id')->toArray();
            $delete_sub_form_data_1 = AppData::whereIn('form_structure_id', $subform_remove_form_fields_1)
                ->where('app_id', $application_id)->delete();
            // dump($delete_sub_form_data_1);
            $delete_subform_remove_form_fields = FormStructure::where('application_id', $application_id)
                ->whereNotIn('id', $from_struucture_array)->delete();
                
        }
        // dd();
        // $subform_remove_form_fields = SubformStructure::where('application_id', $application_id)
        //                 ->where('field_type', 'sub-form')
        //                 ->whereNotIn('id', $from_struucture_array)
        //                 ->first();
        // $other_form_fields = FormStructure::where('application_id', $application_id)
        //                 ->whereNotIn('id', $from_struucture_array)
        //                 ->get()->pluck('id')->toArray();
        // $main_data_delete = AppData::whereIn('form_structure_id', $other_form_fields)->where('app_id', $application_id)->delete();
        // $form_fields = FormStructure::where('application_id', $application_id)
        //                 ->whereNotIn('id', $from_struucture_array)
        //                 ->delete();
        
        // if($subform_remove_form_fields != null){
        //     $sub_form_fields = SubformStructure::where('application_id', $application_id)
        //                                     ->where('form_id', $subform_remove_form_fields->id)
        //                                     ->delete();
        //     $subform_remove_form_fields->delete();
        // }else{
        //     if($sub_structure_formid != null && !empty($sub_structure_formid)){
        //         $sub_form_fieldss = SubformStructure::where('application_id', $application_id)->first();
        //         if($sub_form_fieldss != null){
        //             $other_form_fields1 = FormStructure::where('application_id', $application_id)
        //                                 ->whereNotIn('id', $from_struucture_array)
        //                                 ->get()->pluck('id')->toArray();
        //             $main_data_delete = AppData::whereIn('form_structure_id', $other_form_fields1)->where('app_id', $application_id)->delete();

        //             $form_fields = FormStructure::where('application_id', $application_id)
        //                                             ->whereNotIn('id', $from_struucture_array)
        //                                             ->delete();

        //             $other_form_fields2 = SubformStructure::where('application_id', $application_id)
        //                     ->whereNotIn('id', $from_struucture_array)
        //                     ->where('form_id', $sub_form_id)
        //                     ->get()->pluck('id')->toArray();
        //             $main_data_delete1 = SubAppData::where('app_id', $application_id)
        //                                 ->whereIn('sub_form_structure_id', $other_form_fields2)
        //                                 ->delete();
        //             $sub_form_fields = SubformStructure::where('application_id', $application_id)
        //                                             ->where('form_id', $sub_form_id)
        //                                             ->whereNotIn('id', $sub_from_struucture_array)
        //                                             ->delete();
        //             foreach($data as $key => $dd){
        //                 $splitd = explode("_",$key);
        //                 $rocord_id = $splitd[0];
        //                 $type = $splitd[1];
        //                 $match = $splitd[2];
                        
        //                 $form_fieldsa = FormStructure::where('application_id', $application_id)->where('id', $rocord_id)->first();
        //                 $sub_form_fieldsa = SubformStructure::where('application_id', $application_id)->where('id', $rocord_id)->first();
            
        //                 if($match == "name"){
        //                     if($type == "main"){
        //                         $form_fieldsa->field_name = $dd[0];
        //                         $form_fieldsa->save();
        //                         array_push($from_struucture_array, $rocord_id);
        //                     }else if($type == "sub"){
        //                         array_push($sub_from_struucture_array, $rocord_id);
        //                         $sub_form_fieldsa->field_name = $dd[0];
        //                         $sub_form_fieldsa->save();
        //                     }
        //                 }
        //             }
        //         }
        //     }
        // }

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
        $content = AppData::find($id);
        $get_all_app_data = AppData::where('UUID', $content->UUID)->delete();
        $get_all_sub_app_data = SubAppData::where('app_uuid', $content->UUID)->delete();
        
        return response()->json(['status' => '200', 'action' => 'Delete Content Data Successfully']);
    }

    public function addstructure($id)
    {
        $page = "Structure";
        $is_sub = 0;
        $application = ApplicationData::find($id);
        $fields = Field::where('estatus', 1)->get();
        $already = FormStructure::with('sub_form')->where('application_id', $id)->get();
        $is_sub = FormStructure::where('application_id', $id)->where('field_type', 'sub-form')->first();
        if($is_sub != null){
            $is_sub = 1;
        }
        $is_form = FormStructure::where('application_id', $id)->first();
        if($is_form != null){
            return view('user.content.edit', compact('id', 'fields', 'already', 'is_sub', 'application', 'page'));
        }else{
            return view('user.content.add', compact('id', 'fields', 'application', 'page'));
        }
    }

    public function ContentForm($application_id)
    {
        $page = "Add Content";
        $is_category = 0;
        $is_sub_formm = 0;
        $application = ApplicationData::find($application_id);
        $main_form = FormStructure::where('application_id', $application_id)->get();
        $sub_form = SubformStructure::where('application_id', $application_id)->get();
        $is_sub_form = SubformStructure::where('application_id', $application_id)->first();
        $categories = Category::where('app_id', $application_id)->where('status', '1')->get();
        $is_categories = Category::where('app_id', $application_id)->where('status', '1')->first();
        if($is_categories != null){
            $is_category = 1;
        }
        if($is_sub_form != null){
            $is_sub_formm = 1;
        }
        return view('user.content.add_content', compact('application_id', 'main_form', 'sub_form', 'categories', 'is_category', 'is_sub_formm','application', 'page'));
    }

    public function ContentList(Request $request, $id)
    {
        $page = "Content List";
        $application = ApplicationData::find($id);
        // $get_application = ApplicationData::where('id', $id)->where('status', '1')->first();
        // $get_app_data = AppData::with('category','application')->select("*")
        //                 ->leftJoin("form_structures", "form_structures.id", "=", "app_data.form_structure_id")
        //                 ->where("app_id", $id)
        //                 ->where("status", 1)
        //                 ->get()
        //                 ->groupBy('UUID');
        // foreach($get_app_data as $d){
        //     foreach($d as $rr){
        //         $rr->start_date = $rr->created_at->format('d M Y');
        //     }
        // }
        // $get_uuid = AppData::with('category','application')->where('app_id', $id)->groupBy('UUID')->get();
        // dd($get_uuid);
        // foreach($get_uuid as $gett){
        //     // dump($get->UUID);
        //     $get_app_data = AppData::with('category','application')->select("*")
        //                 ->leftJoin("form_structures", "form_structures.id", "=", "app_data.form_structure_id")
        //                 ->where("UUID", $gett->UUID)
        //                 ->where('app_id', $id)
        //                 ->where("status", 1)
        //                 ->get();
        //     $gett->app_data = $get_app_data;
        //     $form_structure = SubAppData::select("*")
        //             ->leftJoin("subform_structures", "subform_structures.id", "=", "sub_app_data.sub_form_structure_id")
        //             ->where("app_uuid",  $gett->UUID)
        //             ->where('app_id', $id)
        //             ->where("status", 1)
        //             ->get();
        //     $gett->sub_app_data = $form_structure;
        // }
        // print_r($get_uuid);
        return view('user.content.content_list', compact('id', 'application', 'page'));
    }

    public function ContentGetList(Request $request, $id)
    {
       $data = $request->all();
       $get_application = ApplicationData::where('id', $id)->where('status', '1')->first();
    //    $get_app_data = AppData::with('category','application')->select("*")
    //                 ->leftJoin("form_structures", "form_structures.id", "=", "app_data.form_structure_id")
    //                 ->where("app_id", $id)
    //                 ->where("status", 1)
    //                 ->get()
    //                 ->groupBy('UUID');
    //     foreach($get_app_data as $d){
    //         foreach($d as $rr){
    //             $rr->start_date = $rr->created_at->format('d M Y');
    //         }
    //     }
        $get_uuid = AppData::with('category','application')->where('app_id', $id)->groupBy('UUID')->get();
            foreach($get_uuid as $gett){
                $get_app_data = AppData::with('category','application')->select("*")
                            ->leftJoin("form_structures", "form_structures.id", "=", "app_data.form_structure_id")
                            ->where("UUID", $gett->UUID)
                            ->where('app_id', $id)
                            // ->where("status", 1)
                            ->get();
                $gett->app_data = $get_app_data;
                $form_structure = SubAppData::select("*")
                        ->leftJoin("subform_structures", "subform_structures.id", "=", "sub_app_data.sub_form_structure_id")
                        ->where("app_uuid",  $gett->UUID)
                        ->where('app_id', $id)
                        // ->where("status", 1)
                        ->get();
                $gett->sub_app_data = $form_structure;
                $gett->start_date = $gett->created_at->format('d M Y');
            }
        // return view('user.content.content_list', compact('id','get_uuid'));
        // dd($get_app_data);
        return datatables::of($get_uuid)->make(true);
    }

    public function DeleteContent($id)
    {
        $app_data = AppData::find($id);
        if($app_data != null){
            $data = $app_data->delete();
            if($data == true){
                return response()->json(['status' => '200']);
            }else{
                return response()->json(['status' => '400']);
            }
        }else{
            return response()->json(['status' => '400']);
        }
    }

    public function ChageContentStatus($id)
    {
        $content = AppData::find($id);
        if($content->status == '1'){
            $get_all_app_data = AppData::where('UUID', $content->UUID)
                                ->where('status', '1')->update(['status' => '0']);
            $get_all_sub_app_data = SubAppData::where('app_uuid', $content->UUID)
                                ->where('status', '1')->update(['status' => '0']);
            return response()->json(['status' => '200','action' =>'deactive']);
        }else{
            $get_all_app_data = AppData::where('UUID', $content->UUID)
                                ->where('status', '0')->update(['status' => '1']);
            $get_all_sub_app_data = SubAppData::where('app_uuid', $content->UUID)
                                ->where('status', '0')->update(['status' => '1']);
            return response()->json(['status' => '200','action' =>'active']);
        }
    }

}
