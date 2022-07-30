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
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Edit Form</h4>
                    <b>Note : <span>if you want to remove any field so, all values is removed</span></b>
                    <div class="form-validation">
                        <form class="form-valide" action="" mathod="PUT" id="form_structures_add" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" value="{{ $id }}" name="application_id">
                            
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="col-lg-4 col-form-label" for="name">Field Select: <span class="text-danger">*</span></label>
                                    <div class="col-lg-12">
                                        <select class="form-control" id="field" name="field">
                                            <option value="">--Select--</option>
                                            @foreach($fields as $field)
                                                @if($field->type != "multi-file")
                                                    <option value="{{$field->type}}">{{$field->title}}</option>
                                                @endif
                                            @endforeach
                                            <option value="sub-form">Sub Form</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="col-lg-4 col-form-label" for="name">-</label>
                                    <div class="col-lg-12 ml-auto ">
                                        <button type="button" class="btn btn-primary" id="Add">Add</button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6 add-value">
                                @foreach($already as $data)
                                <?php 
                                    $key_name = $data->id."_main_name[]"; 
                                    $key_type = $data->id."_main_type[]"; 
                                ?>
                                    <div class="row mt-3 fdbfddb">
                                        <div class="col-md-5">
                                            <input type="text" placeholder="Field Name" value="{{$data->field_name}}" class="form-control input-flat specReq" data-name="field_name" name="{{$key_name}}" />
                                            <label id="field_name-error" class="error invalid-feedback animated fadeInDown" for=""></label>
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" value="{{$data->field_type}}" class="form-control input-flat pe-none" name="{{$key_type}}"  />
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="minus_btn btn mb-1 btn-dark">-</button>
                                        </div>
                                    </div>
                                @endforeach
                                @foreach($already as $data)
                                    @if(isset($data->sub_form) && $data->sub_form != null && sizeof($data->sub_form)) 
                                        <div class="row mt-3 border">
                                            <div class="form-group col-md-6">
                                                <label class="col-lg-4 col-form-label" for="name">Field Select: <span class="text-danger">*</span>
                                                </label>
                                                <div class="col-lg-12">
                                                    <select class="form-control" id="field-subform" name="field">
                                                        <option value="">--Select--</option>
                                                        @foreach($fields as $field)
                                                            <option value="{{$field->type}}">{{$field->title}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="col-lg-4 col-form-label" for="name">-</label>
                                                <div class="col-lg-12 ml-auto ">
                                                    <button type="button" class="btn btn-primary" id="AddSub">Add</button>
                                                </div>
                                            </div>
                                            <div class="form-group row add-value-sub">
                                                @foreach($data->sub_form as $dat)
                                                <?php 
                                                    $key_name1 = $dat->id."_sub_name[]"; 
                                                    $key_type1 = $dat->id."_sub_type[]"; 
                                                ?>
                                                    <div class="row mt-3">
                                                        <div class="col-md-5">
                                                            <input type="text" placeholder="Field Name" value="{{$dat->field_name}}" class="form-control input-flat specReq" data-name="field_name" name="{{$key_name1}}" />
                                                        </div>
                                                        <div class="col-md-5">
                                                            <input type="text" placeholder="Field Name" value="{{$dat->field_type}}" class="form-control input-flat pe-none" name="{{$key_type1}}" />
                                                        </div>
                                                        <div class="col-md-2">
                                                            <button type="button" class="minus_btn btn mb-1 btn-dark">-</button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <div class="col-lg-8 ml-auto">
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
        }else{
            type = ""
        }


        if(type == 'sub-form'){
            html += '<div class="row mt-3">'+
                    '<div class="col-md-5">'+
                        '<input type="text" placeholder="Field Name" class="form-control input-flat specReq" data-name="field_name" name="field_name[]" /><label id="field_name-error" class="error invalid-feedback animated fadeInDown" for=""></label>'+
                    '</div>'+
                    '<div class="col-md-5">'+
                        '<input type="text" value="'+type+'" class="form-control input-flat pe-none" name="field_type[]"  />'+
                    '</div>'+
                    '<div class="col-md-2">'+
                        '<button type="button"  class="minus_btn btn mb-1 btn-dark">-</button>'+
                    '</div>'+
                '</div>';

           html += '<div class="row mt-3 border">'+
                '<div class="form-group col-md-10">'+
                    '<label class="col-lg-4 col-form-label" for="name">Field Select: <span class="text-danger">*</span></label>'+
                    '<div class="col-lg-12">'+
                        '<select class="form-control" id="field-subform" name="field-subform">'+
                            '<option value="">---Select---</option>'+
                            '<option value="textbox">Textbox</option>'+
                            '<option value="file">Image</option>'+
                            '<option value="multi-file">Multi Image</option>'+
                        '</select>'+
                    '</div>'+
                '</div>'+
                '<div class="form-group col-md-2">'+
                    '<label class="col-lg-4 col-form-label" for="name">-'+
                    '</label>'+
                    '<div class="col-lg-12 ml-auto ">'+
                        '<button type="button" class="btn btn-primary" id="AddSub">Add</button>'+
                    '</div>'+
                '</div>'+ 
                '<div class="form-group col-md-12 add-value-sub">'+
                                   
                '</div>'+   
                '</div>';
        }else if(type != ""){
            html += '<div class="row mt-3">'+
                    '<div class="col-md-5">'+
                        '<input type="text" placeholder="Field Name" class="form-control input-flat specReq" data-name="field_name" name="field_name[]" /><label id="field_name-error" class="error invalid-feedback animated fadeInDown" for=""></label>'+
                    '</div>'+
                    '<div class="col-md-5">'+
                        '<input type="text" value="'+type+'" class="form-control input-flat pe-none" name="field_type[]"  />'+
                    '</div>'+
                    '<div class="col-md-2">'+
                        '<button type="button"  class="minus_btn btn mb-1 btn-dark">-</button>'+
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
            html += '<div class="row mt-3">'+
                    '<div class="col-md-5">'+
                        '<input type="text" placeholder="Field Name" class="form-control input-flat" name="sub_field_name[]" />'+
                    '</div>'+
                    '<div class="col-md-5">'+
                        '<input  type="text" value="'+type+'" class="form-control input-flat pe-none" name="sub_field_type[]"  />'+
                    '</div>'+
                    '<div class="col-md-2">'+
                        '<button type="button"  class="minus_btn btn mb-1 btn-dark">-</button>'+
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
                        window.location.href = "{{ url('/content-form')}}"+app_id;
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
         //alert();
        var valid = true;
        var this_form = $('#form_structures_add');
        console.log($('#form_structures_add').find('.specReq'));
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