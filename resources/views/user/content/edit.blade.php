@extends('user.layouts.layout')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/dropzone.min.css" rel="stylesheet">
<style>
    .dropzone {
        background: #e3e6ff;
        border-radius: 13px;
        max-width: 550px;
        margin-left: auto;
        margin-right: auto;
        border: 2px dotted #1833FF;
        margin-top: 50px;
    }
    .pe-none {
        pointer-events: none;
        background: #cfcfcf40;
    }
</style>
<div class="container-fluid mt-3">
    <div class="row justify-content-center custom-form-design">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Edit Form</h4>
                    <b>Note : <span>if you want to remove any field so, all values is removed</span></b>
                    <div class="form-validation">
                        <form class="form-valide" action="" mathod="PUT" id="form_structures_add" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" value="{{ $id }}" name="application_id">
                            
                            <div class="row">
                                <div class="col-md-10  col-xl-6">
                                    <div class="row">
                                        <label class="col-lg-12 col-form-label px-sm-3" for="name">Field Select: <span class="text-danger">*</span></label>
                                        <div class="form-group col-9 col-sm-10 px-sm-0">
                                            <div class="col-lg-12 px-0 px-sm-3">
                                                <div class="position-relative">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="arrow_selectbox" xmlns:xlink="http://www.w3.org/1999/xlink" width="46" height="46" viewBox="0 0 46 46" fill="none">
                                                    <rect width="46" height="46" fill="url(#pattern0)"></rect>
                                                    <defs>
                                                    <pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
                                                    <use xlink:href="#image0_303_257" transform="scale(0.00195312)"></use>
                                                    </pattern>
                                                    <image id="image0_303_257" width="512" height="512" xlink:href="data:image/png;base64,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"></image>
                                                    </defs>
                                                    </svg>
                                                    <select class="form-control select-box" id="field" name="field">
                                                        <option value="">--Select--</option>
                                                        @foreach($fields as $field)
                                                            <option value="{{$field->type}}">{{$field->title}}</option>
                                                        @endforeach
                                                        <!-- <option value="sub-form">Sub Form</option> -->
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-3 px-0 px-sm-3 col-sm-2 text-center">
                                            <!-- <label class="col-lg-4 col-form-label" for="name">-</label> -->
                                            <div class="ml-auto ">
                                                <button type="button" class="plus_btn btn btn-info field_btn" id="Add">Add</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-10 col-xl-6 add-value px-0">
                                    @foreach($already as $data)
                                    <?php 
                                        $key_name = $data->id."_main_name[]"; 
                                        $key_type = $data->id."_main_type[]"; 
                                    ?>
                                        <div class="row mt-3 mx-0"> 
                                            <div class="col-12 col-sm-5 mb-3 mb-sm-0">
                                                <input type="text" placeholder="Field Name" value="{{$data->field_name}}" class="form-control input-flat specReq" data-name="field_name" name="{{$key_name}}" />
                                                <label id="field_name-error" class="error invalid-feedback animated fadeInDown" for=""></label>
                                            </div>
                                            <div class="col-10 col-sm-5 mb-sm-0">
                                                <input type="text" value="{{$data->field_type}}" class="form-control input-flat pe-none" name="{{$key_type}}"  />
                                            </div>
                                            <div class="col-2 col-sm-2 text-center">
                                                <button type="button" class="minus_btn btn btn-dark px-0"><img src="{{asset('user/assets/icons/delete-red.png')}}"></button>
                                            </div>
                                        </div>
                                    @endforeach
                                    @foreach($already as $data)
                                        @if(isset($data->sub_form) && $data->sub_form != null && sizeof($data->sub_form)) 
                                            <div class="row mt-3 mx-3 border px-sm-3 py-sm-4 py-3 sub-form-card">
                                            <label class="col-lg-12 col-form-label pt-0" for="name">Field Select: <span class="text-danger">*</span>
                                                    </label>
                                                <div class="form-group col-9 col-sm-10">
                                                    <div class="col-lg-12 px-0">
                                                        <div class="position-relative">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="arrow_selectbox" xmlns:xlink="http://www.w3.org/1999/xlink" width="46" height="46" viewBox="0 0 46 46" fill="none">
                                                                <rect width="46" height="46" fill="url(#pattern0)"></rect>
                                                                <defs>
                                                                <pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
                                                                <use xlink:href="#image0_303_257" transform="scale(0.00195312)"></use>
                                                                </pattern>
                                                                <image id="image0_303_257" width="512" height="512" xlink:href="data:image/png;base64,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"></image>
                                                                </defs>
                                                                </svg>
                                                            <select class="form-control select-box" id="field-subform" name="field">
                                                                <option value="">--Select--</option>
                                                                @foreach($fields as $field)
                                                                    @if($field->type != "multi-file")
                                                                        <option value="{{$field->type}}">{{$field->title}}</option>
                                                                    @endif
                                                                @endforeach
                                                        </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-3 col-sm-2 px-0 px-sm-3 text-center">
                                                    <!-- <label class="col-lg-4 col-form-label" for="name">-</label> -->
                                                    <div class="ml-auto ">
                                                        <button type="button" class="plus_btn btn btn-info field_btn" id="AddSub">Add</button>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12 add-value-sub mb-0 px-0">
                                                    @foreach($data->sub_form as $dat)
                                                    <?php 
                                                        $key_name1 = $dat->id."_sub_name[]"; 
                                                        $key_type1 = $dat->id."_sub_type[]"; 
                                                    ?>
                                                        <div class="row mt-sm-3 mx-0">
                                                            <div class="col-12 col-sm-5 my-3 my-sm-0">
                                                                <input type="text" placeholder="Field Name" value="{{$dat->field_name}}" class="form-control input-flat specReq" data-name="field_name" name="{{$key_name1}}" />
                                                            </div>
                                                            <div class="col-10 col-sm-5">
                                                                <input type="text" placeholder="Field Name" value="{{$dat->field_type}}" class="form-control input-flat pe-none" name="{{$key_type1}}" />
                                                            </div>
                                                            <div class="col-2 col-sm-2 text-center">
                                                                <button type="button" class="minus_btn btn btn-dark px-0"><img src="{{asset('user/assets/icons/delete-red.png')}}"></button>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="form-group col-md-6 mt-3">
                                    <div class="">
                                       <button type="button" id="submit_form_structures" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<script type="text/javascript">
$(document).ready(function() { 
    var app_id = "{{$id}}";
    // console.log(app_id)
    //$("#Add").on("click", function() {
    $('body').on('click', '#Add', function(){    
        var html = "";
        // var valuee = $('#field').val();
        var selected = $('#field option:selected');
        var valuee = selected.attr('value')
        var type = "";
        // console.log(valuee)
        if(valuee == "textbox"){
            type = "text";
        }else if(valuee == "file"){
            type = "file";
        }else if(valuee == "multi-file"){
            type = "multi-file";
        }else if(valuee == "sub-form"){
            type = "sub-form";
            $('#field option').prop('disabled', true);
        }else{
            type = ""
        }


        if(type == 'sub-form'){
            html += '<div class="row mt-3 mx-0">'+
                    '<div class="col-12 col-sm-5 mb-3">'+
                        '<input type="text" placeholder="Field Name" class="form-control input-flat specReq" data-name="field_name" name="field_name[]" /><label id="field_name-error" class="error invalid-feedback animated fadeInDown" for=""></label>'+
                    '</div>'+
                    '<div class="col-10 col-sm-5 mb-0 mb-sm-">'+
                        '<input type="text" value="'+type+'" class="form-control input-flat pe-none" name="field_type[]"  />'+
                    '</div>'+
                    '<div class="col-2 col-sm-2 text-center">'+
                        '<button type="button"  class="minus_btn btn btn-dark px-0"><img src="{{asset('user/assets/icons/delete-red.png')}}"></button>'+
                    '</div>'+
                '</div>';

           html += '<div class="row mt-3 mt-sm-0 mx-3 border px-sm-3 py-sm-4 py-3 sub-form-card">'+
           '<label class="col-lg-12 col-form-label pt-0" for="name">Field Select: <span class="text-danger">*</span></label>'+
                '<div class="form-group col-9 col-sm-10">'+
                    '<div class="col-lg-12 px-0">'+
                    '<div class="position-relative">'+
                        ' <svg xmlns="http://www.w3.org/2000/svg" class="arrow_selectbox" xmlns:xlink="http://www.w3.org/1999/xlink" width="46" height="46" viewBox="0 0 46 46" fill="none"><rect width="46" height="46" fill="url(#pattern0)"></rect><defs><pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1"><use xlink:href="#image0_303_257" transform="scale(0.00195312)"></use></pattern><image id="image0_303_257" width="512" height="512" xlink:href="data:image/png;base64,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"></image></defs></svg>'+
                            '<select class="form-control select-box mb-sm-0" id="field-subform" name="field-subform">'+
                                '<option value="">---Select---</option>'+
                                '<option value="textbox">Textbox</option>'+
                                '<option value="file">Image</option>'+
                            '</select>'+
                        '</div>'+
                    '</div>'+
                '</div>'+
                '<div class="form-group col-3 col-sm-2 px-0 px-sm-3 text-center">'+
                    // '<label class="col-lg-4 col-form-label" for="name">-'+
                    // '</label>'+
                    '<div class="ml-auto ">'+
                        '<button type="button" class="plus_btn btn mb-1 btn-info field_btn" id="AddSub">Add</button>'+
                    '</div>'+
                '</div>'+ 
                '<div class="form-group col-md-12 add-value-sub mb-0 px-0">'+
                                   
                '</div>'+   
                '</div>';
        }else if(type != ""){
            html += '<div class="row mt-3 mx-0">'+
                    '<div class="col-12 col-sm-5 mb-3 mb-sm-0">'+
                        '<input type="text" placeholder="Field Name" class="form-control input-flat specReq" data-name="field_name" name="field_name[]" /><label id="field_name-error" class="error invalid-feedback animated fadeInDown" for=""></label>'+
                    '</div>'+
                    '<div class="col-10 col-sm-5 mb-sm-0">'+
                        '<input type="text" value="'+type+'" class="form-control input-flat pe-none" name="field_type[]"  />'+
                    '</div>'+
                    '<div class="col-2 col-sm-2 text-center">'+
                        '<button type="button"  class="minus_btn btn btn-dark px-0"><img src="{{asset('user/assets/icons/delete-red.png')}}"></button>'+
                    '</div>'+
                '</div>';
        }        
        $(".add-value").append(html);
    });

    $('body').on('click', '#AddSub', function(){    
        var html = "";

        var selected = $('#field-subform option:selected');
        // var selected = $('#field option:selected');
        var valuee = selected.attr('value')
        var type = "";
        if(valuee == "textbox"){
            type = "text";
        }else if(valuee == "file"){
            type = "file";
        }else if(valuee == "multi-file"){
            type = "multi-file";
        }else if(valuee == "sub-form"){
            type = "sub-form";
        }else{
            type = ""
        }
        if(type != ""){
            html += '<div class="row mt-sm-3 mx-0">'+
                    '<div class="col-12 col-sm-5 my-3 my-sm-0">'+
                        '<input type="text" placeholder="Field Name" class="form-control input-flat" name="sub_field_name[]" />'+
                    '</div>'+
                    '<div class="col-10 col-sm-5">'+
                        '<input  type="text" value="'+type+'" class="form-control input-flat pe-none" name="sub_field_type[]"  />'+
                    '</div>'+
                    '<div class="col-2 col-sm-2 text-center">'+
                        '<button type="button"  class="minus_btn btn btn-dark px-0"><img src="{{asset('user/assets/icons/delete-red.png')}}"></button>'+
                    '</div>'+
                '</div>';
        }
        $(".add-value-sub").append(html);
    });

    $('body').on('click', '.minus_btn', function(){
        var tthis = $(this).parent().parent();
        var ddd = tthis.remove()
    });

    $('body').on('click', '#submit_form_structures', function () {
       
        // $(this).prop('disabled',true);
        // $(this).find('.submitloader').show();
        var btn = $(this);

        var formData = new FormData($("#form_structures_add")[0]);
        var valid_form = validateForm();
        if(valid_form==true && valid_form==true){
        $.ajax({
                type: 'POST',
                url: "{{ url('/content-update')}}/"+app_id,
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                    if(res['status']==200){

                        toastr.success("Form Structure Added",'Success',{timeOut: 5000});
                        window.location.href = "{{ url('/content-form/')}}"+'/'+app_id;
                        console.log("{{ url('/content-form')}}"+app_id)
                        $("#form_structures_add")[0].reset()
                    }
                },
                error: function (data) {
                    // $(btn).prop('disabled',false);
                    // $(btn).find('.submitloader').hide();
                    toastr.error("Please try again",'Error',{timeOut: 5000});
                }
        });
        }else{
            $(btn).prop('disabled',false);
            $(btn).find('.submitloader').hide();
        }
    });

    function validateForm() {
        var valid = true;
        var this_form = $('#form_structures_add');
        // console.log($('#form_structures_add').find('.specReq'));
        $('#form_structures_add').find('.specReq').each(function() {
            var thi = $('.specReq');
            //alert($(thi).attr('name'));
            var this_err = $(thi).attr('data-name') + "-error";
            if($(thi).val()=="" || $(thi).val()==null) {
                $(this_form).find("#"+this_err).html("Please select any value");
                $(this_form).find("#"+this_err).show();
                valid = false;
            }
        });
        return valid;
    }

 

});   
</script>
@endpush('scripts')