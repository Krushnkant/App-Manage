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
                    <h4 class="card-title">Add Form Structures</h4>
                    <div class="form-validation">
                        <form class="form-valide" action="" mathod="POST" id="form_structures_add" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" value="{{ $id }}" name="application_id">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="col-lg-4 col-form-label" for="name">Field Select: <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-12">
                                        
                                        <select class="form-control" id="field" name="field">
                                            <option value="">--Select--</option>
                                                @foreach($fields as $field)
                                                    <option value="{{$field->type}}">{{$field->title}}</option>
                                                @endforeach
                                            <option value="sub-form">Sub Form</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                   <label class="col-lg-4 col-form-label" for="name">-
                                    </label>
                                    <div class="col-lg-12 ml-auto ">
                                        <button type="button" class="btn btn-primary" id="Add">Add</button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6 add-value">
                                   
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
        // var valuee = $('#field-subform').val()
        // var type = "text";
        // if(valuee == "textbox"){
        //     type = "text";
        // }
        // if(valuee == "file"){
        //     type = "file";
        // }
        // if(valuee == "multi-file"){
        //     type = "multi-file";
        // }
        var selected = $('#field-subform option:selected');
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
        $(this).prop('disabled',true);
        $(this).find('.submitloader').show();
        var btn = $(this);

        var formData = new FormData($("#form_structures_add")[0]);
        var valid_form = validateForm();
        if(valid_form==true && valid_form==true){
        $.ajax({
                type: 'POST',
                url: "{{ route('content.store') }}",
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                    if(res['status']==200){
                        toastr.success("Form Added",'Success',{timeOut: 5000});
                        window.location.href = "{{ url('content-edit/'.$id)}}";
                        $("#form_structures_add")[0].reset()
                    }
                },
                error: function (data) {
                    $(btn).prop('disabled',false);
                    $(btn).find('.submitloader').hide();
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