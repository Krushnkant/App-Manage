@extends('user.layouts.layout')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/dropzone.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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

    span.error-display {
        color: #f00;
        display: block;
    }

    .spinner-border {
        display: none;
    }

    .revers_div {
        flex-direction: row-reverse;
    }
</style>
<div>
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{url('application-new')}}">Application List</a></li>
                <li class="breadcrumb-item active">Edit Category</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid pt-0 custom-form-design">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Category Edit Form - {{$app_data->name}}</h4>
                        <div class="row">
                            <div class="col-md-12 col-xl-5 category_edit_col">
                                <div class="form-validation">
                                    <!-- {{ Form::open(array('url' => 'category', 'method' => 'post', 'enctype' => 'multipart/form-data')) }} -->
                                    <form class="form-valide" action="" mathod="PUT" id="category_add" enctype="multipart/form-data">
                                        @csrf
                                        <?php
                                        $current_id = [];
                                        $cuur_id = "";
                                        ?>
                                        @foreach($data->category_field as $key => $d)
                                        <?php
                                        array_push($current_id, $d->id);
                                        $cuur_id = implode(",", $current_id);
                                        ?>
                                        @endforeach
                                        <input type="hidden" name="category_id" value="{{$data->id}}" />
                                        <input type="hidden" name="app_id" value="{{$data->app_id}}" />
                                        <input type="hidden" name="all_id" value="{{$cuur_id}}" />
                                        <input type="hidden" id="delete_id" name="delete_id" value="0" />
                                        <div class="row">
                                            <div class="form-group col-12">
                                                <label class="col-form-label" for="name">Title <span class="text-danger">*</span>
                                                </label>
                                                <div class="row pl-3">
                                                    <div class="col-md-11 p-0 mb-3">
                                                        <input type="text" class="form-control" id="name" value="{{$data->title}}" name="name" placeholder="Application Name..">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3 ">
                                            <div class="form-group col-9 col-md-10">
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
                                                        @foreach($fields as $key => $field)
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
                                                @foreach($data->category_field as $key => $d)
                                                <?php
                                                $field_key = $d->id . "_oldkey";
                                                $field_key_id = $d->id . "_oldkey";
                                                $field_name_id = $d->id . "_oldvalue";
                                                $current_id = [];
                                                array_push($current_id, $d->id);
                                                $cuur_id = implode(",", $current_id);
                                                // $field_key = $d->id . "_" . $d->field_type . "_key";
                                                // $field_key_id = $d->id . "_" . $d->field_type . "_key";
                                                // $field_name_id = $d->id . "_" . $d->field_type . "_value";
                                                ?>
                                                <div class="row position-relative align-items-center">
                                                    <div class="col-md-5 mb-3 mb-md-0">
                                                        <input type="text" placeholder="" value="{{$d->field_key}}" data="specific" id="{{$field_key}}" class="form-control input-flat" name="{{$field_key}}" />
                                                    </div>
                                                    @if($d->field_type == "textbox")
                                                    <?php $field_name = $d->id . "_" . $d->field_type . "_value[]"; ?>
                                                    <div class="col-10 col-sm-11 col-md-5 mb-3 mb-md-0">
                                                        <input type="text" value="{{$d->field_value}}" class="form-control input-flat" id="{{$field_name_id}}" name="{{$field_name_id}}" />
                                                    </div>
                                                    @elseif($d->field_type == 'file')
                                                    <?php
                                                    $field_name_ = $d->id . "_oldvalue[]";
                                                    $field_name = $d->id . "_" . $d->field_type . "_file[]";
                                                    ?>
                                                    <div class="col-10 col-sm-11 col-md-5 mb-3 mb-md-0">
                                                        <input type="file" value="{{$d->field_value}}" class="form-control input-flat files" id="{{$field_name_id}}" name="{{$field_name_id}}" />
                                                        <!-- <img src="{{asset('category_image/'.$d->field_value)}}" class="img_side" /> -->
                                                    </div>
                                                    @elseif($d->field_type == 'multi-file')
                                                    <?php
                                                    $field_name_ = $d->id . "_oldvalue[]";
                                                    $field_name = $d->id . "_" . $d->field_type . "_file[]";
                                                    $get_multi_img = App\Models\CategoryField::where('app_id', $d->app_id)
                                                        ->where('category_id', $d->category_id)
                                                        ->where('field_key', $d->field_key)
                                                        ->where('field_type', 'multi-file')->get();
                                                    ?>
                                                    <div class="col-10 col-sm-11 col-md-5 mb-3 mb-md-0 oooo">
                                                        <input type="file" value="{{$d->field_value}}" class="form-control input-flat files" id="{{$field_name_id}}" name="{{$field_name_}}" multiple />
                                                        <div class="revers_div">
                                                        </div>
                                                    </div>
                                                    @endif
                                                    <div class="col-2 col-sm-1 col-md-1 mb-3 mb-md-0 text-center delete_btn_part">
                                                        <button type="button" data-id="{{$d->id}}" class="minus_btn btn mb-1 btn-dark p-0"><img src="{{asset('user/assets/icons/delete-red.png')}}"></button>
                                                    </div>
                                                </div>
                                                <div class="row mt-2 mb-3">
                                                    @if($d->field_type == "file")
                                                    <div class="offset-md-5 col-md-1 img_class text-start text-lg-center">
                                                        <img class="img_side" src="{{asset('category_image/'.$d->field_value)}}">
                                                    </div>
                                                    @elseif($d->field_type == 'multi-file')
                                                    <?php
                                                    $field_name_ = $d->id . "_oldvalue[]";
                                                    $field_name = $d->id . "_" . $d->field_type . "_file[]";
                                                    $get_multi_img = App\Models\CategoryField::where('app_id', $d->app_id)
                                                        ->where('category_id', $d->category_id)
                                                        ->where('field_key', $d->field_key)
                                                        ->where('field_type', 'multi-file')->get();
                                                    ?>
                                                    <div class="offset-md-5 col-md-1 img_class text-start text-lg-center d-flex">
                                                        @foreach($get_multi_img as $img)
                                                        <span class="pip">
                                                            <img class="img_side" src="{{asset('category_image/'.$img->field_value)}}">
                                                            <br />
                                                            <span data-id="{{$img->id}}" data-toggle='modal' data-target='#exampleModalCenter' class="remove deleteUserBtn">X</span>
                                                        </span>
                                                        @endforeach
                                                    </div>
                                                    @endif
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-12">
                                                <div class="">
                                                    <button type="button" id="submit_category" class="btn btn-primary">
                                                        Submit
                                                        <div class="spinner-border" role="status">
                                                            <span class="sr-only">Loading...</span>
                                                        </div>
                                                    </button>
                                                    <button type="reset" class="btn btn-dark">Cancel</button>
                                                </div>
                                                <!-- <span id="loader">
                                                    <div class="loader">
                                                        <svg class="circular" viewBox="25 25 50 50">
                                                            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10"></circle>
                                                        </svg>
                                                    </div>
                                                </span> -->
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
    <div class="modal fade" id="exampleModalCenter">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Are you sure you want to delete this image ?</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-gray" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary delete" id="RemoveUserSubmit">Delete</button>
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
    var signatures = {
        JVBERi0: "application/pdf",
        R0lGODdh: "image/gif",
        R0lGODlh: "image/gif",
        iVBORw0KGgo: "image/png",
        "/9j/": "image/jpg"
    };

    function detectMimeType(b64) {
        for (var s in signatures) {
            if (b64.indexOf(s) === 0) {
                return signatures[s];
            }
        }
    }
    $(document).ready(function() {
        var ddd = 0;
        var app_id = "{{$id}}";
        if (window.File && window.FileList && window.FileReader) {
            $('body').on('change', '.files', function(e) {
                var uniq = (new Date()).getTime() + "_s" + ddd;
                var main = $(this).next()
                var files = e.target.files,
                    filesLength = files.length;
                for (var i = 0; i < filesLength; i++) {
                    var f = files[i]
                    var fileReader = new FileReader();
                    fileReader.onload = (function(e) {
                        var file = e.target;
                        var ss = $(".revers_div").children().length
                        ss = ss + 1;
                        let mimeType = file.result.match(/[^:]\w+\/[\w-+\d.]+(?=;|,)/)[0];
                        var placeholder = "";
                        if (mimeType.match("png") || mimeType.match("jpg") || mimeType.match("jpeg")) {
                            placeholder = e.target.result;
                        } else {
                            placeholder = "https://riggswealth.com/wp-content/uploads/2016/06/Riggs-Video-Placeholder-300x150.jpg";
                        }
                        $("<span class=\"pip\">" +
                            "<span class='number_display'>" + ss + "</span>" +
                            "<img class=\"imageThumb\" src=\"" + placeholder + "\" title=\"" + file.name + "\"/>" +
                            "<br/><span class=\"remove\">X</span>" +
                            "</span>").appendTo(main);
                        $(".remove").click(function() {
                            $(this).parent(".pip").remove();
                            // console.log($(this).parent(".pip").remove())
                        });
                    });
                    fileReader.readAsDataURL(f);
                }
            });
        } else {
            alert("Your browser doesn't support to File API")
        }
    });
    $("#cat_form").hide();
    var app_id = 0;
    const cat_id = "{{$data->id}}";
    // console.log("{{ url('/category-update')}}/" + cat_id)
    $(".field_btn").click(function() {
        var app_id = $(this).attr('data-id');
        $("#cat_form").show();
    });

    $('body').on('click', '.plus_btn', function() {
        // var tthis = $(this).parent().parent();
        // var ddd = tthis.clone()
        // $("#category_form").append(ddd);
        var html = "";
        var set_multiple = "";
        var set_multi = "";
        var selected = $('#val-skill option:selected');
        var option = selected.attr('data-id')
        var valuee = selected.attr('value')
        var field_name = option + "field_value[]";
        var field_key = option + "field_key[]";
        var field_name_id = option + "field_value";
        var field_key_id = option + "field_key";

        var type = "";
        if (valuee == "textbox") {
            type = "text";
        } else if (valuee == "file") {
            type = "file";
        } else if (valuee == "multi-file") {
            type = "file";
            set_multiple = "multiple";
            set_multi = "multiple";
            field_name = option + "field_value[]"
            $("select option[value*='multi-file']").prop('disabled', true);
        } else {
            type = ""
        }

        if (type != "") {
            html += '<div class="row mb-3">' +
                '<div class="col-md-5 mb-3 mb-md-0">' +
                '<input type="text" placeholder="" id="' + field_key_id + '" data="specific" class="form-control input-flat" name="' + field_key + '" />' +
                '</div>' +
                '<div class="col-10 col-sm-10 col-md-5">' +
                '<input type="' + type + '" id="' + field_name_id + '" class="form-control input-flat"  data="' + set_multi + '" name="' + field_name + '" ' + set_multiple + '/>' +
                '</div>' +
                // '<div class="col-md-2">'+
                //     '<button type="button" class="plus_btn btn mb-1 btn-primary">+</button>'+
                // '</div>'+
                '<div class="col-2 col-sm-2 col-md-1 text-center">' +
                '<button type="button" class="minus_btn btn p-0 btn-dark"><img src="{{asset("user/assets/icons/delete-red.png")}}"></button>' +
                '</div>' +
                '</div>';
            $("#category_form").append(html);
        }
    })

    var delete_array = [];

    $('body').on('click', '.minus_btn', function() {
        var tthis = $(this).parent().parent();
        var ddd = tthis.remove()
        var deletd_id = $(this).attr('data-id')
        delete_array.push(deletd_id);
        var deleted_str = delete_array.join(",");
        $("#delete_id").val(deleted_str);
        // console.log(deleted_str)
    })

    $('body').on('click', '#submit_category', function() {
        var formData = new FormData($("#category_add")[0]);
        var validation = ValidateForm()

        if (validation != false) {
            $('.spinner-border').show();
            $('#submit_category').prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: "{{ url('/category-update-new')}}/" + cat_id,
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.status == 200) {
                        $('.spinner-border').hide();
                        var app_id = "{{$id}}";
                        toastr.success("Category Update", 'Success', {
                            timeOut: 5000
                        });
                        window.location.href = "{{ url('category-add-new/'.$data->app_id)}}";
                        // $("#category_add")[0].reset()
                    } else if (data.status == 300) {
                        $('#submit_category').prop('disabled', false);
                        $('.spinner-border').hide();
                        toastr.error(data.message, 'Error', {
                            timeOut: 5000
                        })
                    } else {
                        $('#submit_category').prop('disabled', false);
                        $('.spinner-border').hide();
                        toastr.error("Please try again", 'Error', {
                            timeOut: 5000
                        })
                    }
                }
            });
        }
    })

    function ValidateForm() {
        var isFormValid = true;
        var specific_arr = [];
        var specific_ids = [];
        var total_specific = $("#category_add input");

        $(total_specific).each(function() {
            if ($(this).attr('data') == "specific") {
                if ($(this).val()) {
                    specific_arr.push($(this).val())
                }
            }
        })
        $(total_specific).each(function() {
            if ($(this).attr('data') == "specific") {
                if ($(this).val()) {
                    specific_ids.push($(this).attr('id'))
                }
            }
        })

        $("#category_add input").each(function() {
            var regexp = /^\S*$/;
            var only_id = "#" + $(this).attr("id");
            if ($(this).attr("id") != undefined) {
                // console.log($(this).attr('value'))
                var FieldId = "span_" + $(this).attr("id");
                var trim_val = $(only_id).attr('value');
                if ($.trim($(this).val()).length == 0 || $.trim($(this).val()) == 0) {
                    if ($.trim(trim_val).length == 0) {
                        $(this).addClass("highlight");
                        if ($("#" + FieldId).length == 0) {
                            $("<span class='error-display' id='" + FieldId + "'>This Field Is Required</span>").insertAfter(this);
                        }
                        if ($("#" + FieldId).css('display') == 'none') {
                            $("#" + FieldId).fadeIn(500);
                        }
                        isFormValid = false;
                    }
                } else {
                    if ($.trim($(this).val()).length != 0 || $.trim($(this).val()) != 0) {
                        const seen = new Set();
                        const duplicates = specific_arr.filter(n => seen.size === seen.add(n).size);
                        var iddd = "";
                        var idd1 = "";
                        $(specific_ids).each(function(item, val) {
                            var vall = $("#" + val).val();
                            var iddds = "#" + val;
                            if (regexp.test(vall) == false) {
                                idd1 = "#span_" + val;
                                $(this).addClass("highlight");
                                $(iddds).nextAll('span').remove();
                                $("<span class='error-display other' id='" + idd1 + "'>Please remove space</span>").insertAfter(iddds);
                                isFormValid = false;
                            } else {
                                $(iddds).nextAll('span').remove();
                                if (duplicates.length > 0) {
                                    $(duplicates).each(function(item, val) {
                                        var ddd = specific_arr.indexOf(val);
                                        iddd = "#" + specific_ids[ddd];
                                        idd1 = specific_ids[ddd];

                                        $(iddd).nextAll('span').remove();
                                        $(iddd).addClass("highlight");
                                        $("<span class='error-display other' id='" + idd1 + "'>Please enter different value</span>").insertAfter(iddd);
                                        isFormValid = false;
                                    })
                                }
                                // else{
                                //     $(specific_ids).each( function(item, val){
                                //         iddd = "#"+val;
                                //         $(iddd).removeClass("highlight");  
                                //         $(iddd).nextAll('span').remove();
                                //         isFormValid = true; 
                                //     }) 
                                // }
                            }
                        })
                    }
                    $(this).removeClass("highlight");
                    if ($("#" + FieldId).length > 0) {
                        $("#" + FieldId).fadeOut(1000);
                    }
                }
            }
        })
        // console.log(isFormValid)
        return isFormValid;
        // return false;  
    }

    $('body').on('click', '.deleteUserBtn', function(e) {
        var delete_user_id = $(this).attr('data-id');
        $("#exampleModalCenter").find('#RemoveUserSubmit').attr('data-id', delete_user_id);
    });
    $('body').on('click', '#RemoveUserSubmit', function(e) {
        $('#RemoveUserSubmit').prop('disabled', true);
        var remove_user_id = $(this).attr('data-id');
        // console.log(remove_user_id)
        $.ajax({
            type: 'GET',
            url: "{{ url('/category-image-delete') }}/" + remove_user_id,
            success: function(res) {
                // console.log(res)
                if (res.status == 200) {
                    $("#exampleModalCenter").modal('hide');
                    $('#RemoveUserSubmit').prop('disabled', false);
                    // $('#application_list').DataTable().draw();
                    location.reload();
                    toastr.success(res.action, 'Success', {
                        timeOut: 5000
                    });
                } else {
                    $("#exampleModalCenter").modal('hide');
                    $('#RemoveUserSubmit').prop('disabled', false);
                }
            },
            error: function(data) {
                toastr.error("Please try again", 'Error', {
                    timeOut: 5000
                });
            }
        });
    });
</script>
@endpush('scripts')