@extends('user.layouts.layout')

@section('content')
<style>
    .add_application_btn {
        background: #005A8C;
        box-shadow: 0px 4px 8px rgb(71 69 69 / 11%);
        border-radius: 6px;
        font-size: 16px;
        line-height: 25px;
        color: #fff !important;
        padding: 8px 17px;
    }

    .main_sidebar {
        left: 254px;
        top: 205px;
        background: #FFFFFF;
        padding: 20px;
    }

    .search_bar {
        position: relative;
    }

    .text_part,
    .image_part,
    .file_part {
        background: #FFFFFF;
    }

    input.search {
        border: none;
        background: #F7F7F7;
        border-radius: 10px;
        width: 243px;
        height: 42px;
        border-color: #cfcfcf;
        position: relative;
        padding-left: 35px;
    }

    .no {
        background: #EFEFEF;
        border-radius: 2px;
        width: 20px;
        height: 20px;
        text-align: center;
        color: #000;
    }

    .action {
        box-sizing: border-box;
        position: absolute;
        /* border: 1px solid #C8C8C8; */
        /* border-radius: 5px; */
        padding: 0px 60px;
    }

    img.search_icon {
        position: absolute;
        z-index: 999;
        top: 38%;
        margin-left: 10px;
    }

    .icons {
        margin-top: 10px;
    }

    .icons .plus {
        display: initial;
        margin-right: 15px;
    }

    .text_part h2,
    .file_part h2,
    span.name_text,
    .main_sidebar h2,
    .image_part h2 {
        font-family: "Roboto", sans-serif;
        font-style: normal;
        /* font-weight: 600; */
        font-size: 16px;
        line-height: 24px;
        color: #04090c;
        text-transform: capitalize;
        padding: 10px;
    }

    table#text_table,
    table#file_table {
        width: 100%;
    }

    table#text_table thead,
    table#file_table thead {
        background: #000;
    }

    table#text_table thead tr th,
    table#file_table thead tr th {
        padding: 10px;
        color: #fff;
        font-family: "Roboto", sans-serif;
        font-style: normal;
        font-weight: 500;
        font-size: 16px;
        line-height: 24px;
    }

    table#text_table tbody tr,
    table#file_table tbody tr {
        font-family: 'Poppins Light';
        font-style: normal;
        font-weight: 300;
        font-size: 14px;
        line-height: 21px;
        color: #000000;
        border-bottom: 1px solid #EAEAEA;
    }

    table#text_table tbody tr td,
    table#file_table tbody tr td {
        padding: 10px;
    }

    table#text_table tbody tr td:nth-child(1),
    table#file_table tbody tr td:nth-child(1) {
        border-right: 1px solid #EAEAEA;
    }

    .row.display_image img.image_small {
        width: 70px;
        height: 70px;
        border-radius: 2px;
        margin: 5px;
    }

    .image_part {
        width: 100%;
        float: left;
        padding: 10px;
    }

    hr {
        margin: 5px 0;
    }

    .row.name_text.parent_div {
        padding: 15px 0px;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 35px;
        height: 18px;
    }

.switch input {
  display: none;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: #dedede;
  border-radius: 40px;
  -webkit-transition: 0.4s;
  transition: 0.3s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 18px;
  width: 18px;
  background: #fff;
  border-radius: 50%;
  left: 0px;
  right: 10px;
    /* bottom: 1px; */
  -webkit-transition: 0.4s;
  transition: 0.4s;
}

input:checked + .slider {
  background: rgb(19, 80, 39);
}

input:checked + .slider:before {
  -webkit-transform: translateX(30px);
    -moz-transform: translateX(30px);
    transform: translateX(17px);
}

input:focus + .slider {
}

    /* .list_content .border_botton {
        border-bottom: 1px solid #cfcfcf;
    } */
</style>
<div>
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{url('application-new')}}">Application List</a></li>
                @if($parent_id == 0)
                <?php
                $get_cat = App\Models\Category::where('id', $cat_id)->first();
                $title = isset($get_cat->title)?$get_cat->title:"";
                ?>
                <li class="breadcrumb-item active"><a href="{{url('category-add-new/'.$app_id)}}">{{$title}}</a></li>
                @else
                <?php
                $application = App\Models\ApplicationData::where('id', $app_id)->first();
                $structure = App\Models\FormStructureNew::where('app_id', $application->id)->first();
                $structure_old = App\Models\FormStructureNew::where('app_id', $application->id)->get();
                ?>
                <?php
                if (count($structure_old) > 0) {
                    foreach ($structure_old as $key => $dat) {
                        if ($dat->parent_id < $parent_id) {
                            $get_cat = App\Models\Category::where('id', $cat_id)->first();
                            $title = $get_cat->title;
                            if ($key == 0) {
                ?>
                                <li class="breadcrumb-item active"><a href="{{url('category-add-new/'.$cat_id)}}">{{$title}}</a></li>
                            <?php
                            }
                            $prev_id = $dat->parent_id;
                            ?>
                            <li class="breadcrumb-item active"><a href="{{url('application-new-design/'.$cat_id.'/'.$app_id.'/'.$prev_id)}}">{{$dat->form_title}}</a></li>
                <?php
                        }
                    }
                }
                ?>
                @endif
            </ol>
        </div>
    </div>
    <div class="container-fluid pt-0">
        <div class="row">
            <div class="col-12">
                <div class="text-left mb-4 add_application_btn_part">

                    <a href="{{url('sub-content-form/'.$cat_id.'/'.$app_id.'/'.$parent_id)}}" class="btn gradient-4 btn-lg border-0 btn-rounded add_application_btn {{$is_content != 1 ? 'disabled' : ''}}">
                        Add content
                    </a>
                    <a href="{{url('sub-form-structure/'.$cat_id.'/'.$app_id.'/'.$parent_id)}}" class="btn gradient-4 btn-lg border-0 btn-rounded add_application_btn">
                        Form Structure
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <div class="main_sidebar">
                    <form class="search_bar">
                        <img src="{{asset('user/assets/icons/search.png')}}" class="search_icon" />
                        <input name="search" id="search" class="search" placeholder="search..." />
                    </form>
                    <hr>
                    <div class="list_content">

                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="text_part">
                            <h2>text</h2>
                            <table id="text_table">
                                <thead>
                                    <tr>
                                        <th>Field Name</th>
                                        <th>Value</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="file_part">
                            <h2>file</h2>
                            <table id="file_table">
                                <thead>
                                    <tr>
                                        <th>Field Name</th>
                                        <th>Value</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-12">
                        <div class="image_part">
                            <h2>images</h2>
                            <div class="row display_image">

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
                    <h5 class="modal-title">Are you sure you want to delete this record ?</h5>
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
    <div class="modal fade" id="copyModalCenter">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Copy Form Structure ?</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row no-gutters">
                        <div class="col-md-12">
                            <label class="col-form-label px-0" for="name">custom field <span class="text-danger">*</span>
                            </label>
                        </div>
                    </div>
                    <div class="row m-0 no-gutters">
                        <div class="form-group col-9 col-sm-12 mb-3 pl-0 ">
                            <div class="position-relative">
                                <svg xmlns="http://www.w3.org/2000/svg" class="arrow_selectbox" xmlns:xlink="http://www.w3.org/1999/xlink" width="46" height="46" viewBox="0 0 46 46" fill="none">
                                    <rect width="46" height="46" fill="url(#pattern0)" />
                                    <defs>
                                        <pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
                                            <use xlink:href="#image0_303_257" transform="scale(0.00195312)" />
                                        </pattern>
                                        <image id="image0_303_257" width="512" height="512" xlink:href="data:image/png;base64,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" />
                                    </defs>
                                </svg>
                                <select class="form-control select-box" id="select_category" name="select_category">
                                    <option value="">Please select</option>
                                    @foreach($maincontents as $maincontent)
                                        <?php $categoryfield = \App\Models\FormStructureNew::where('parent_id', $maincontent->content_field->id)->get(); ?>
                                        @if(count($categoryfield) > 0)
                                            <option data-id="{{$categoryfield[0]->id}}" value="{{$maincontent->id}}">{{$maincontent->title}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary text-white" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="CopySubmit">Copy</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script type="text/javascript">
    var url = "{{url('/')}}";
    var cat_id = "{{$cat_id}}";
    var app_id = "{{$app_id}}";
    var parent_id = "{{$parent_id}}";
    $(document).ready(function() {
        application_page_tabs('', true);
        // $("div.list_content").first().css("background-color","#e9e9e9");
    })

    function application_page_tabs() {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url + "/content-list-get-new/" + cat_id + "/" + app_id + "/" + parent_id,
            data: {
                'token': '{{ csrf_token() }}'
            },
            type: 'POST',
            dataType: 'json',
            success: function(result) {
                
                if (result.status == "200") {
                    var html = '';
                    var Active = 'Active';
                    var Inactive = 'Inactive';
                    
                    $.map(result.data, function(item, key) {
                        console.log(item.field_content_s);
                        var background_color = '#fff';
                        if (key == 0) {
                            OnClickShowData(item.id)
                             background_color = "#e9e9e9";
                        }
                        var url2 = url + "/application-new-design/" + cat_id + "/" + app_id + "/" + item.id;
                        var edit_url = "{{url('/')}}" + "/sub-content-edit/" + "{{$cat_id}}" + "/{{$app_id}}/{{$parent_id}}/" + item.main_content_id;
                        key = key + 1;

                        var img_url0 = "{{asset('user/assets/icons/copy.png')}}";
                        if(item.field_content_s == null){
                            var copy  = "<a href='javascript:void(0)' data-id='" + item.id + "' data-toggle='modal' data-target='#copyModalCenter' title=\"Copy\" class='copyBtn'><img src='" + img_url0 + "' alt=''></a>";
                         }else{
                            var copy  = "<a href='javascript:void(0)' title=\"Copy\" class='show_toster_already'><img src='" + img_url0 + "' alt=''></a>";
                         }

                        html += '<div class="row name_text parent_div" style="background-color: '+ background_color +'" data-id="' + item.id + '">' +
                            '<div class="col-lg-1">' +
                            ' <div class="no">' +
                            '<span>' + key + '</span>' + // '<span>' + (item.status == '1' ? Active : Inactive) + '</span>' +
                            '</div>' +
                            '</div>' +
                            '<div class="col-lg-8">' +
                            ' <div class="name">' +
                            '<span class="name_text" data-id="' + item.id + '">' + item.form_title + '</span>' +
                            '<div class="icons">' +
                            '<div class="plus ">' +
                            '<label class="switch mt-1" style="margin-bottom: -5px;"><input type="checkbox" ' + (item.main_content_status == '1' ? "checked" : "") + ' class="toggle-class" data-id="'+ item.main_content_id +'"><span class="slider"></span></label>' +
                            '</div>' +
                            '<div class="plus">' +
                                copy
                             +
                            '</div>' +
                            '<div class="plus">' +
                            '<a href="' + edit_url + '" data-url="'+ edit_url +'" class="editUserBtn">' +
                            '<img src = "{{asset("user/assets/icons/edit.png")}}" / > ' +
                            ' </a>' +
                            '</div>' +
                            '<div class="plus">' +
                            '<a href="javascript:void(0)" rel="' + item.id + '" data-toggle="modal" data-target="#exampleModalCenter" class="deleteUserBtn">' +
                            '<img src="{{asset("user/assets/icons/delete.png")}}" />' +
                            '</a>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="col-lg-3 p-0">' +
                            '<div class="active_deactive">' +
                            '<div class="action">' +
                            // '<img src="{{asset("user/assets/icons/right.png")}}" />' +
                            '<a href="'+ url2 +'" data-url="'+ url2 +'" class="addUserBtn" ><i class="fa fa-arrow-right" style="font-size:16px"></i></a>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<hr>';
                    });
                    $(".list_content").append(html);
                } else {
                    console.log("false")
                }
            }
        });
    }

    function OnClickShowData(data_id) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url + "/show-only-content-new/" + cat_id + "/" + app_id + "/" + parent_id + "/" + data_id,
            type: 'GET',
            dataType: 'json',
            success: function(result) {
                if (result.status === "200") {
                    var text_ = '';
                    var file_ = '';
                    var file_html = '';
                    var multi_file_ = '';
                    var html = '';
                    $.each(result.data, function(index, value) {
                        if (value.field_content.field_type === "multi-file") {
                            $.each(value.multi_files, function(index1, value1) {
                                var img_url = "{{asset('app_data_images')}}/" + value1.field_value;
                                multi_file_ += '<div class="col-lg-1">' +
                                    '<img src="' + img_url + '" class="image_small" />' +
                                    '</div>';
                            })
                        } else if (value.field_content.field_type === "file") {
                            var img_url = "{{asset('app_data_images')}}/" + value.field_value;
                            var valid_extensions = /(\.jpg|\.jpeg|\.png|\.gif|\.webp)$/i;
                            var filename = value.field_value
                            var ids = "#myModal" + value.id;
                            var id = "myModal" + value.id;
                            var popup_file = '';
                            // file_ += '<tr>';
                            if (valid_extensions.test(filename)) {
                                popup_file += '<img class="img_side" data-toggle="modal" data-target="' + ids + '" src="' + img_url + '" class="image_small" />';
                                html += '<div id="' + id + '" class="modal fade" role="dialog">' +
                                    '<div class="modal-dialog">' +
                                    '<div class="modal-content">' +
                                    '<div class="modal-body">' + popup_file + '</div>' +
                                    '<div class="modal-footer">' +
                                    '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>';
                                file_ += '<tr>' +
                                    '<td>' + value.field_content.field_name + '</td>' +
                                    '<td><img class="img_side" data-toggle="modal" data-target="' + ids + '" src="' + img_url + '" class="image_small" />' + html + '</td>' +
                                    '</tr>';
                            } else {
                                popup_file += '<img class="img_side" data-toggle="modal" data-target="' + ids + '" src="{{asset("user/assets/icons/video_icon.jpg")}}" class="image_small" />';
                                html += '<div id="' + id + '" class="modal fade" role="dialog">' +
                                    '<div class="modal-dialog">' +
                                    '<div class="modal-content">' +
                                    '<div class="modal-body">' + popup_file + '</div>' +
                                    '<div class="modal-footer">' +
                                    '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>';
                                file_ += '<tr>' +
                                    '<td>' + value.field_content.field_name + '</td>' +
                                    '<td><img class="img_side" data-toggle="modal" data-target="' + ids + '" src="{{asset("user/assets/icons/video_icon.jpg")}}" class="image_small" />' + html + '</td>' +
                                    '</tr>';
                            }
                        } else {
                            text_ += '<tr>' +
                                '<td>' + value.field_content.field_name + '</td>' +
                                '<td>' + value.field_value + '</td>' +
                                '</tr>';
                        }
                    });
                    $("#text_table tbody").html(text_);
                    $("#file_table tbody").html(file_);
                    $(".display_image").html(multi_file_);
                }
            }
        });
    }
    $(".list_content").on("click", ".name_text", function(e) {
        // e.preventDefault();
        $(".parent_div").each(function(index, value) {
            $(this).css("background-color", "white");
        });
        if ($(this).hasClass("parent_div")) {
            $(this).css("background-color", "#e9e9e9");
        }
        var data_id = $(this).attr('data-id');
        OnClickShowData(data_id);
    });

    $("#search").keyup(function() {
        // $("#text_table tbody").empty();
        // $("#file_table tbody").empty();
        // $(".display_image").empty();
        var x = $(this).val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url + "/searching/" + cat_id + "/" + app_id + "/" + parent_id,
            data: {
                'token': '{{ csrf_token() }}',
                'content': x
            },
            type: 'POST',
            dataType: 'json',
            success: function(result) {
                
                if (result.status == "200") {
                    var html = '';
                    var Active = 'Active';
                    var Inactive = 'Inactive';
                    var background_color = '#fff';
                    $("div.list_content").empty();
                    $.map(result.data, function(item, key) {
                        console.log(item);
                        var url2 = url + "/application-new-design/" + cat_id + "/" + app_id + "/" + item.id;
                        var edit_url = "{{url('/')}}" + "/sub-content-edit/" + "{{$cat_id}}" + "/{{$app_id}}/{{$parent_id}}/" + item.main_content_id;
                        key = key + 1;

                        var img_url0 = "{{asset('user/assets/icons/copy.png')}}";
                        if(item.field_content_s == null){
                            var copy  = "<a href='javascript:void(0)' data-id='" + item.id + "' data-toggle='modal' data-target='#copyModalCenter' title=\"Copy\" class='copyBtn'><img src='" + img_url0 + "' alt=''></a>";
                         }else{
                            var copy  = "<a href='javascript:void(0)' title=\"Copy\" class='show_toster_already'><img src='" + img_url0 + "' alt=''></a>";
                         }

                        html += '<div class="row name_text parent_div" data-id="' + item.id + '">' +
                            '<div class="col-lg-1">' +
                            ' <div class="no">' +
                            '<span>' + key + '</span>' +
                            '</div>' +
                            '</div>' +
                            '<div class="col-lg-8">' +
                            ' <div class="name">' +
                            '<span class="name_text" data-id="' + item.id + '">' + item.form_title + '</span>' +
                            '<div class="icons">' +
                            '<div class="plus">' +
                            '<label class="switch mt-1" style="margin-bottom: -5px;" ><input type="checkbox" ' + (item.main_content_status == '1' ? "checked" : "") + ' class="toggle-class" data-id="'+ item.main_content_id +'"><span class="slider"></span></label>' +
                            '</div>' +
                            '<div class="plus">' +
                                copy
                             +
                            '</div>' +
                            '<div class="plus">' +
                            '<a href="' + edit_url + '" data-url="'+ edit_url +'" class="editUserBtn">' +
                            '<img src = "{{asset("user/assets/icons/edit.png")}}" / > ' +
                            ' </a>' +
                            '</div>' +
                            '<div class="plus">' +
                            '<a href="javascript:void(0)" rel="' + item.id + '" data-toggle="modal" data-target="#exampleModalCenter" class="deleteUserBtn">' +
                            '<img src="{{asset("user/assets/icons/delete.png")}}" />' +
                            '</a>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="col-lg-3 p-0">' +
                            '<div class="active_deactive">' +
                            '<div class="action">' +
                            // '<img src="{{asset("user/assets/icons/right.png")}}" />' +
                           // '<span>' + (item.status == '1' ? Active : Inactive) + '</span>' +
                            '<a href="'+ url2 +'" data-url="'+ url2 +'" class="addUserBtn" ><i class="fa fa-arrow-right" style="font-size:16px"></i></a>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<hr>';
                    });
                    $(".list_content").append(html);
                } else {
                    console.log("false")
                }
                // console.log(result)
            }
        })
    });

    $('body').on('click', '.copyBtn', function(e) {
        var copy_category_id = $(this).attr('data-id');
        $("#copyModalCenter").find('#CopySubmit').attr('data-id', copy_category_id);
    });
    $('body').on('click', '.show_toster_already', function(e) {
        toastr.error("already add structure", 'Error', {
                    timeOut: 5000
        });
    });
    $('body').on('click', '#CopySubmit', function(e) {
        $('#CopySubmit').prop('disabled', true);
       
        var remove_user_id = $(this).attr('data-id');
        
        var select_category_id = $("#select_category").find(':selected').attr('data-id');
       
        $.ajax({
            type: 'GET',
            url: "{{ url('/sub_form') }}" + '/' + remove_user_id + '/' + select_category_id + '/copy',
            success: function(res) {
                if (res.status == 200) {
                    $("#copyModalCenter").modal('hide');
                    $('#CopySubmit').prop('disabled', false);
                    $('#category_list').DataTable().draw();
                    location.reload();
                } else {
                    $("#copyModalCenter").modal('hide');
                    $('#CopySubmit').prop('disabled', false);
                }
            },
            error: function(data) {
                toastr.error("Please try again", 'Error', {
                    timeOut: 5000
                });
            }
        });
    });

    
 $(document).ready(function(){
    $('body').on('change', '.toggle-class', function() {
        let status = $(this).prop('checked') === true ? 1 : 0;
        let userId = $(this).data('id');
        $.ajax({
            type: 'GET',
            url: "{{ url('/chageaContentstatusNew') }}" +'/' + userId,
            success: function (res) {
                if(res.status == 200 && res.action=='deactive'){
                    toastr.success("Content Deactivated",'Success',{timeOut: 5000});
                    $('#content_list').DataTable().draw();
                }
                if(res.status == 200 && res.action=='active'){
                    toastr.success("Content activated",'Success',{timeOut: 5000});
                    $('#content_list').DataTable().draw();
                }
            },
            error: function (data) {
                toastr.error("Please try again",'Error',{timeOut: 5000});
            }
        });
    });
});
</script>
@endpush('scripts')