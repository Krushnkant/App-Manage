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
</style>
<div class="container-fluid mt-3">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Add Content</h4>
                    <div class="form-validation">
                        {{ Form::open(array('url' => 'application', 'method' => 'post', 'enctype' => 'multipart/form-data')) }}
                        <!-- <form class="form-valide" action="" method="post"> -->
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="col-lg-4 col-form-label" for="name">Field Select: <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-12">
                                        <select class="form-control" id="field" name="field">
                                            
                                            @foreach($fields as $field)
                                                <option value="{{$field->type}}">{{$field->title}}</option>
                                            @endforeach
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
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </div>
                        <!-- </form> -->
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script type="text/javascript">
$(document).ready(function() {    
    //$("#Add").on("click", function() {
    $('body').on('click', '#Add', function(){    
        var html = "";
        var valuee = $('#field').val()
        var type = "text";
        if(valuee == "textbox"){
            type = "text";
        }
        if(valuee == "file"){
            type = "file";
        }
        if(valuee == "multi-file"){
            type = "multi-file";
        }
        if(valuee == "sub-form"){
            type = "sub-form";
        }


        if(type == 'sub-form'){
           html += '<div class="row mt-3 border">'+
                '<div class="form-group col-md-10">'+
                    '<label class="col-lg-4 col-form-label" for="name">Field Select: <span class="text-danger">*</span></label>'+
                    '<div class="col-lg-12">'+
                        '<select class="form-control" id="field-subform" name="field-subform">'+
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
        }else{
            html += '<div class="row mt-3">'+
                    '<div class="col-md-5">'+
                        
                        '<input type="text" placeholder="Field Name" class="form-control input-flat" name="field_key[]" />'+
                    '</div>'+
                    '<div class="col-md-5">'+
                       
                        '<input  type="text" value="'+type+'" class="form-control input-flat" name="field_value[]" disabled />'+
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
        var valuee = $('#field-subform').val()
        var type = "text";
        if(valuee == "textbox"){
            type = "text";
        }
        if(valuee == "file"){
            type = "file";
        }
        if(valuee == "multi-file"){
            type = "multi-file";
        }
      

        html += '<div class="row mt-3">'+
                    '<div class="col-md-5">'+
                        '<input type="text" placeholder="Field Name" class="form-control input-flat" name="field_key[]" />'+
                    '</div>'+
                    '<div class="col-md-5">'+
                        '<input  type="text" value="'+type+'" class="form-control input-flat" name="field_value[]" disabled />'+
                    '</div>'+
                    '<div class="col-md-2">'+
                        '<button type="button"  class="minus_btn btn mb-1 btn-dark">-</button>'+
                    '</div>'+
                '</div>';
               
        $(".add-value-sub").append(html);
    });

    $('body').on('click', '.minus_btn', function(){
        var tthis = $(this).parent().parent();
        var ddd = tthis.remove()
    })

 

});   
</script>
@endpush('scripts')