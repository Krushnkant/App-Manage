@extends('user.layouts.layout')

@section('content')
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<style>
    input[type="file"] {
        display: block;
    }

    .imageThumb {
        max-height: 75px;
        border: 2px solid;
        padding: 1px;
        cursor: pointer;
    }

    .pip {
        display: inline-block;
        margin: 10px 10px 0 0;
    }

    .remove {
        display: block;
        background: #444;
        border: 1px solid black;
        color: white;
        text-align: center;
        cursor: pointer;
    }

    .remove:hover {
        background: white;
        color: black;
    }

    .sub_form {
        width: 100%;
    }

    span.error-display {
        color: #f00;
    }

    .spinner-border {
        display: none;
    }
</style>
<div>
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item "><a href="{{url('application-new')}}">Application List</a></li>
                <li class="breadcrumb-item "><a href="{{url('sub-content/'.$app_id.'/'.$cat_id.'/'.$parent_id)}}">Back List</a></li>
                <li class="breadcrumb-item active">Add Content</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid pt-0">
        <div class="row justify-content-center custom-form-design">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Add Content - {{$application->name}}</h4>
                        <form class="form-valide" action="" mathod="POST" id="content_add" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" value="{{ $app_id }}" name="application_id">
                            <input type="hidden" value="{{ $formStructure->id }}" name="form_structure_id">
                            <input type="hidden" value="{{ $cat_id }}" name="category_id">
                            <input type="hidden" value="{{ $parent_id }}" name="parent_id">
                            <!-- <input type="hidden" value="{{ $app_id }}" name="application_id"> -->

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="col-form-label" for="name">Form Title</label>
                                    <input type="text" id="title" placeholder="Field Name" class="form-control input-flat specReq" name="title" value="{{$main_content->title}}" />
                                    <input type="hidden" id="content_id" placeholder="Field Name" class="form-control input-flat specReq" name="content_id" value="{{$main_content->id}}" />
                                </div>
                            </div>

                            <div class="row">
                                @foreach($content as $key => $c_)
                                <?php
                                $field_types = App\Models\FormStructureFieldNew::where('id', $c_->form_structure_field_id)->first();
                                $name = $c_->id . "_content";
                                ?>
                                @if($field_types->field_type == "multi-file")
                                <?php
                                $field_types = App\Models\FormStructureFieldNew::where('id', $c_->form_structure_field_id)->first();
                                $multi_files = App\Models\ContentSubField::where('content_field_id', $c_->id)->where('app_id', $app_id)->get();
                                $name = $c_->id . "_content[]";
                                ?>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="col-form-label" for="name">{{$field_types->field_name}}</label>
                                        <input type="file" name="{{$name}}" value="{{$c_->field_value}}" id="{{$field_types->field_name}}" placeholder="enter your {{$field_types->field_name}}" class="form-control input-flat specReq files" multiple />
                                    </div>
                                    <div class="image_gallery">
                                        @if(isset($multi_files) && count($multi_files) > 0)
                                        @foreach($multi_files as $file)
                                        <?php
                                        $extension = pathinfo(storage_path($file->field_value), PATHINFO_EXTENSION);
                                        ?>
                                        <!-- <img src="{{asset('app_data_images/'.$file->field_value)}}" class="w-100" /> -->
                                        <span class="pip">
                                            @if($extension == "jpg" || $extension == "webp" || $extension == "png" || $extension == "jpeg")
                                            <img class="img_side" src="{{asset('app_data_images/'.$file->field_value)}}">
                                            @else
                                            <a href="{{asset('app_data_images/'.$file->field_value)}}" target="_blank">
                                                <img class="img_side" src="{{asset('user/assets/icons/file_icon.png')}}">
                                            </a>
                                            @endif
                                            <br />
                                            <span data-id="{{$file->id}}" data-toggle='modal' data-target='#exampleModalCenter' data-title="multi" class="remove deleteUserBtn">X</span>
                                        </span>
                                        @endforeach
                                        @endif
                                    </div>
                                </div>
                                @elseif($field_types->field_type == "file")
                                <?php
                                $extension = pathinfo(storage_path($c_->field_value), PATHINFO_EXTENSION);
                                ?>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="col-form-label" for="name">{{$field_types->field_name}}</label>
                                        <input type="{{$field_types->field_type}}" value="{{$c_->field_value}}" name="{{$name}}" id="{{$field_types->field_name}}" placeholder="enter your {{$field_types->field_name}}" class="form-control input-flat specReq files" />
                                    </div>
                                    <div class="image_gallery">
                                        <span class="pip">
                                            @if($extension == "jpg" || $extension == "webp" || $extension == "png" || $extension == "jpeg")
                                            <img class="img_side" src="{{asset('app_data_images/'.$c_->field_value)}}">
                                            @else
                                            <a href="{{asset('app_data_images/'.$c_->field_value)}}" target="_blank">
                                                <img class="img_side" src="{{asset('user/assets/icons/file_icon.png')}}">
                                            </a>
                                            @endif
                                            <br />
                                            <span data-id="{{$c_->id}}" data-toggle='modal' data-target='#exampleModalCenter' data-title="single" class="remove deleteUserBtn">X</span>
                                        </span>
                                        <!-- <img src="{{asset('app_data_images/'.$c_->field_value)}}" class="w-100" /> -->
                                    </div>
                                </div>
                                @else
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="name">{{$field_types->field_name}}</label>
                                        <input type="{{$field_types->field_type}}" value="{{$c_->field_value}}" name="{{$name}}" id="{{$field_types->field_name}}" placeholder="enter your {{$field_types->field_name}}" class="form-control input-flat specReq" name="title" />
                                    </div>
                                </div>
                                @endif
                                @endforeach
                            </div>
                            <div class="row">
                                @if(isset($add_new_fields) && count($add_new_fields) > 0)
                                @foreach($add_new_fields as $field)
                                @if($field->field_type == "multi-file")
                                <?php
                                $name = $field->id . "_form[]";
                                ?>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="name">{{$field->field_name}}</label>
                                        <input type="file" name="{{$name}}" id="{{$field->field_name}}" placeholder="enter your {{$field->field_name}}" class="form-control input-flat specReq files" name="title" multiple />
                                    </div>
                                </div>
                                @elseif($field->field_type == "file")
                                <?php
                                $name = $field->id . "_form";
                                ?>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="name">{{$field->field_name}}</label>
                                        <input type="{{$field->field_type}}" name="{{$name}}" id="{{$field->field_name}}" placeholder="enter your {{$field->field_name}}" class="form-control input-flat specReq files" name="title" />
                                    </div>
                                </div>
                                @else
                                <?php
                                $name = $field->id . "_form";
                                ?>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="name">{{$field->field_name}}</label>
                                        <input type="{{$field->field_type}}" name="{{$name}}" id="{{$field->field_name}}" placeholder="enter your {{$field->field_name}}" class="form-control input-flat specReq" name="title" />
                                    </div>
                                </div>
                                @endif
                                @endforeach
                                @endif
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6 mt-3">
                                    <div class="">
                                        <button type="button" id="submit_app_data" class="btn btn-primary">
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
                        <!-- <div id='loader'></div> -->
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
@endsection
@push('scripts')
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var ddd = 0;
        if (window.File && window.FileList && window.FileReader) {
            $('body').on('change', '.files', function(e) {
                // $(".files").on("change", function(e) {
                var uniq = (new Date()).getTime() + "_s" + ddd;
                var main = $(this)
                var image_array = [];
                var image_string = "";
                var files = e.target.files,
                    filesLength = files.length;
                // var dumm = JSON.stringify(files)
                // console.log(dumm)
                ddd++;
                var input_html = "";
                var file_name = uniq + "multifile[]";
                var ids = "files_hid" + ddd;
                var sss = "#" + ids;
                input_html = '<input type="hidden" value="" class="files_hid" id="' + ids + '" name="' + file_name + '" />';
                // input_html.val(input_html)
                // main.parent().append(input_html)
                // console.log()
                for (var i = 0; i < filesLength; i++) {
                    var f = files[i]
                    image_array.push(f.name)
                    var fileReader = new FileReader();
                    fileReader.onload = (function(e) {
                        var file = e.target;
                        var type = e.target.result.split(';')[0].split('/')[0];
                        const type_ = type.split(':');
                        var define = '';
                        if (type_[1] == "image") {
                            define += "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>";
                        } else {
                            define += "<img class='imageThumb' src='{{asset('user/assets/icons/file_icon.png')}}' title='' />";
                        }
                        $("<span class=\"pip\">" + define +
                            "<br/><span class=\"remove\">X</span>" +
                            "</span>").insertAfter(main);
                        $(".remove").click(function() {
                            // $('body').on('click', '.remove', function () {
                            $(this).parent(".pip").remove();
                        });

                        // Old code here
                        // $("<img></img>", {
                        //   class: "imageThumb",
                        //   src: e.target.result,
                        //   title: file.name + " | Click to remove"
                        // }).insertAfter("#files").click(function(){$(this).remove();});

                    });
                    fileReader.readAsDataURL(f);
                }
                image_string = image_array.join(",")
                $(sss).val(image_string)
            });
        } else {
            // alert("Your browser doesn't support to File API")
        }
    });

    $('body').on('click', '#submit_app_data', function() {
        var plus = 1;
        var all = $('.sub_form .row.sub_form_row .col-md-6').find('.cp_btn').find('.UUID');
        // var alll = $('.sub_form .row .col-md-6').find('.cp_btn').find('.UUIDd');
        $(all).map(function(key, value) {
            var uniq = (new Date()).getTime() + "_s" + key;
            return $(this).val(uniq);
        })

        var formData = new FormData($("#content_add")[0]);
        // console.log(ValidateForm())
        var validation = ValidateForm()
        if (validation != false) {
            var url = "{{url('/')}}";
            var app_id = "{{$app_id}}";
            var cat_id = "{{$cat_id}}";
            var parent_id = "{{$parent_id}}";

            $('.spinner-border').show();
            $('#submit_app_data').prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: url + "/sub-content-update/" + cat_id + "/" + app_id + "/" + parent_id + "/" + "{{$formStructure->id}}",
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.status == 200) {
                        $('.spinner-border').hide();
                        toastr.success("Content Added", 'Success', {
                            timeOut: 5000
                        })
                        $("#content_add")[0].reset()
                        window.location.href = "{{ url('sub-content/'.$app_id.'/'.$cat_id.'/'.$parent_id)}}";
                    } else {
                        $('#submit_app_data').prop('disabled', false);
                        $('.spinner-border').hide();
                        toastr.error("Please try again", 'Error', {
                            timeOut: 5000
                        })
                    }
                }
            });
        }
    })
    // var uniqq = (new Date()).getTime()+"_"+1;
    // $(".UUID").val(uniqq);
    $('body').on('click', '.copy_btn', function() {
        var parent_ = $(this).parent().parent().parent().clone();
        $(".sub_form .row.sub_form_row ").append(parent_);
    })
    $('body').on('click', '.remove_btn', function() {
        var parent_ = $(this).parent().parent().remove();
    })

    $('body').on('click', '.deleteUserBtn', function(e) {
        var delete_user_id = $(this).attr('data-id');
        var delete_title = $(this).attr('data-title');
        // console.log($("#exampleModalCenter").find('#RemoveUserSubmit'))
        $("#exampleModalCenter").find('#RemoveUserSubmit').attr('data-id', delete_user_id);
        $("#exampleModalCenter").find('#RemoveUserSubmit').attr('data-title', delete_title);
    });

    $('body').on('click', '#RemoveUserSubmit', function(e) {
        $('#RemoveUserSubmit').prop('disabled', true);
        var remove_user_id = $(this).attr('data-id');
        var remove_title = $(this).attr('data-title');
        console.log(remove_user_id)
        console.log(remove_title)
        $.ajax({
            type: 'GET',
            url: "{{ url('/content_image_delete_new') }}/" + remove_user_id + "/" + remove_title,
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

    function ValidateForm() {
        var isFormValid = true;
        var app_id = "{{$app_id}}";
        $("#content_add input, select").each(function() {
            // var val__ = $(this).attr("id").val();
            var val__ = $(this).val();
            // console.log(val__);
            if ($(this).attr("id") != undefined && val__ != "") {
                var FieldId = "span_" + $(this).attr("id");
                console.log($(this).attr("type"))
                if ($.trim($(this).val()).length == 0 || $.trim($(this).val()) == 0) {
                    $(this).addClass("highlight");
                    if ($("#" + FieldId).length == 0) {
                        $("<span class='error-display' id='" + FieldId + "'>This Field Is Required</span>").insertAfter(this);
                    }
                    if ($("#" + FieldId).css('display') == 'none') {
                        $("#" + FieldId).fadeIn(500);
                    }
                    // var formData = $(this).val()
                    // $.ajax({
                    //     type: 'POST',
                    //     url: "{{ url('/same_value_match')}}/",
                    //     "data":{ _token: '{{ csrf_token() }}', formData: formData, app_id: app_id},
                    //     success: function (res) {
                    //         if(res.responce == true){
                    //             $(this).addClass("highlight");
                    //             $("<span class='error-display' id='" + FieldId + "'>Same value not enter</span>").insertAfter(this);  
                    //         }
                    //     },
                    //     error: function (data) {
                    //         console.log(data)
                    //     }
                    // })
                    isFormValid = false;
                } else {
                    $(this).removeClass("highlight");
                    if ($("#" + FieldId).length > 0) {
                        $("#" + FieldId).fadeOut(1000);
                    }
                }
            }
        })
        // return false;
        return isFormValid;
    }
</script>
@endpush('scripts')