@extends('user.layouts.layout')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/dropzone.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
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
<div class="container-fluid mt-3 custom-form-design">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Category Edit Form</h4>
                    <div class="row">
                        <div class="col-md-12 col-xl-5 category_edit_col">
                            <div class="form-validation">
                                <!-- {{ Form::open(array('url' => 'category', 'method' => 'post', 'enctype' => 'multipart/form-data')) }} -->
                                <form class="form-valide" action="" mathod="PUT" id="category_add" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="category_id" value="{{$data->id}}" />
                                    <p class="error-display mb-0" style="display: none;"></p>
                                    <input type="hidden" name="app_id" value="{{$data->app_id}}" />
                                    <p class="error-display mb-0" style="display: none;"></p>
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label class="col-form-label" for="name">Title: <span class="text-danger">*</span>
                                            </label>
                                            <div class="row pl-3">
                                                <div class="col-lg-8 p-0 mr-2 mb-3">
                                                    <input type="text" class="form-control" id="name" value="{{$data->title}}" name="name" placeholder="Application Name..">
                                                    <p class="error-display mb-0"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="form-group col-9 col-md-11">
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
                                                <select class="form-control select-box" id="val-skill" name="val-skill">
                                                    <option value="">Please select</option>
                                                    @foreach($fields as $field)
                                                        <option data-id="{{$field->id}}" value="{{$field->type}}">{{$field->title}}</option>
                                                    @endforeach
                                                </select>
                                                </div>
                                        </div>
                                        <div class="col-3 pr-3 pl-sm-0 col-md-1 p-0 text-right">
                                            <div class="custome_fields"><button type="button" data-id="" class="plus_btn btn mb-1 btn-info field_btn">Add</button></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div id="category_form" class="form-group col-12">
                                            @foreach($data->category as $d)
                                                <?php 
                                                $field_key = $d->id."_".$d->fields->id."_key[]"; 
                                                $field_name = ""; 
                                                ?>
                                                <div class="row mb-3 position-relative align-items-center">
                                                    <div class="col-md-5 mb-3 mb-md-0">
                                                        <input type="text" placeholder="" value="{{$d->key}}" class="form-control input-flat" name="{{$field_key}}" />
                                                        <p class="error-display mb-0"></p>
                                                    </div>
                                                    @if($d->fields->type == "textbox")
                                                    <?php $field_name = $d->id."_".$d->fields->id."_value[]"; ?>
                                                    <div class="col-10 col-sm-11 col-md-5 mb-3 mb-md-0">
                                                        <input type="text" value="{{$d->value}}" class="form-control input-flat" name="{{$field_name}}" />
                                                        <p class="error-display mb-0"></p>
                                                    </div>
                                                    @elseif($d->fields->type == "file")
                                                    <?php $field_name = $d->id."_".$d->fields->id."_file[]"; ?>
                                                    <div class="col-10 col-sm-11 col-md-5 mb-3 mb-md-0">
                                                        <input type="file" value="{{$d->value}}" class="form-control input-flat" name="{{$field_name}}" />
                                                        <p class="error-display mb-0" style="display: none;"></p>
                                                    </div>
                                                    @elseif($d->fields->type == "multi-file")
                                                    <?php $field_name = $d->id."_".$d->fields->id."_file[]"; ?>
                                                    <div class="col-10 col-sm-11 col-md-5 mb-3 mb-md-0">
                                                        <input type="file" value="{{$d->value}}" class="form-control input-flat" name="{{$field_name}}" />
                                                        <p class="error-display mb-0" style="display: none;"></p>
                                                    </div>
                                                    @endif
                                                    <!-- <div class="col-md-2">
                                                        <button type="button" class="plus_btn btn mb-1 btn-primary">+</button>
                                                    </div> -->
                                                    <div class="col-2 col-sm-1 col-md-1 mb-3 mb-md-0 text-center">
                                                        <button type="button" class="minus_btn btn mb-1 btn-dark p-0"><img src="{{asset('user/assets/icons/delete-red.png')}}"></button>
                                                    </div>
                                                    @if($d->fields->type == "file")
                                                    <div class="col-md-1 img_class text-start text-lg-center pl-md-0 pl-xl-3">
                                                        <img class="img_side" src="{{asset('category_image/'.$d->value)}}" >
                                                    </div>
                                                    @elseif($d->fields->type == "multi-file")
                                                    <div class="col-md-1 img_class text-start text-lg-center pl-md-0 pl-xl-3">
                                                        <img class="img_side" src="{{asset('category_image/'.$d->value)}}" >
                                                    </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <div class="">
                                                <button type="button" id="submit_category" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!-- {{ Form::close() }} -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/min/dropzone.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
<script type="text/javascript">
    $("#cat_form").hide();
    var app_id = 0;
    const cat_id = "{{$data->id}}";
    $(".field_btn").click(function(){
        var app_id = $(this).attr('data-id');
        $("#cat_form").show();
    });
    // $('#val-skill').change(function(){
    //     var html = "";
    //     var valuee = $(this).val()
    //     var option = $('option:selected', this).attr('data-id');
    //     var field_name = option+"field_value[]";
    //     var field_key = option+"field_key[]";
    //     var type = "text";
    //     if(valuee == "textbox"){
    //         type = "text";
    //     }
    //     if(valuee == "file"){
    //         type = "file";
    //     }
    //     if(valuee == "multi-file"){
    //         type = "file";
    //     }

    //     html += '<div class="row mb-2">'+
    //                 '<div class="col-md-4">'+
    //                     '<input type="text" placeholder="" class="form-control input-flat" name="'+field_key+'" />'+
    //                 '</div>'+
    //                 '<div class="col-md-4">'+
    //                     '<input type="'+type+'" class="form-control input-flat" name="'+field_name+'" />'+
    //                 '</div>'+
    //                 '<div class="col-md-2">'+
    //                     '<button type="button" class="plus_btn btn mb-1 btn-primary">+</button>'+
    //                 '</div>'+
    //                 '<div class="col-md-2">'+
    //                     '<button type="button" class="minus_btn btn mb-1 btn-dark">-</button>'+
    //                 '</div>'+
    //             '</div>';
    //     $("#category_form").append(html);
    // })
    $('body').on('click', '.plus_btn', function(){
        // var tthis = $(this).parent().parent();
        // var ddd = tthis.clone()
        // $("#category_form").append(ddd);
        var html = "";
        var selected = $('#val-skill option:selected');
        var option = selected.attr('data-id')
        var valuee = selected.attr('value')
        var field_name = option+"field_value[]";
        var field_key = option+"field_key[]";

        var type = "";
        if(valuee == "textbox"){
            type = "text";
        }else if(valuee == "file"){
            type = "file";
        }else if(valuee == "multi-file"){
            type = "file";
        }else{
            type = ""
        }

        if(type != ""){ 
            html += '<div class="row mb-3">'+
                            '<div class="col-md-5 mb-3 mb-md-0">'+
                                '<input type="text" placeholder="" class="form-control input-flat" name="'+field_key+'" />'+
                            '</div>'+
                            '<div class="col-10 col-sm-10 col-md-5">'+
                                '<input type="'+type+'" class="form-control input-flat" name="'+field_name+'" />'+
                            '</div>'+
                            // '<div class="col-md-2">'+
                            //     '<button type="button" class="plus_btn btn mb-1 btn-primary">+</button>'+
                            // '</div>'+
                            '<div class="col-2 col-sm-2 col-md-1 text-center">'+
                                '<button type="button" class="minus_btn btn p-0 btn-dark"><img src="{{asset('user/assets/icons/delete-red.png')}}"></button>'+
                            '</div>'+
                        '</div>';
                $("#category_form").append(html);
        }
    })

    // $('body').on('click', '.plus_btn', function(){
    //     var tthis = $(this).parent().parent();
    //     var ddd = tthis.clone()
    //     $("#category_form").append(ddd);
    // })
    $('body').on('click', '.minus_btn', function(){
        var tthis = $(this).parent().parent();
        var ddd = tthis.remove()
    })

    $('body').on('click', '#submit_category', function () {
        var formData = new FormData($("#category_add")[0]);
        // var url1 = '{{ Route("category.update", "id") }}';
        var total_length = 0;
        $("form#category_add :input").each(function(){
            if($(this).val().length == 0){
                if($(this).next().length != 0){
                    total_length ++;
                    $(this).next().text("This Field Is Required")
                }
            }else{
                if($(this).next().length != 0){
                    total_length ++;
                }else{
                    total_length ++;
                }
                
                $(this).next().text("")
                total_length --;
            }
        })
        console.log(total_length)
        if(total_length == 0){
            $.ajax({
                    type: 'POST',
                    url: "{{ url('/category-update')}}/"+cat_id,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        if(data.status == 200){
                            var app_id = "{{$id}}";
                            toastr.success("Category Update",'Success',{timeOut: 5000});
                            window.location.href = "{{ url('category-add/'.$id)}}";
                            // $("#category_add")[0].reset()
                        }else{
                            toastr.error("Please try again",'Error',{timeOut: 5000})
                        }
                    }
            });
        }
    })

</script>
@endpush('scripts')