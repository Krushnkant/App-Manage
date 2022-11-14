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
  width: 51px;
  height: 20px;
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
  transition: 0.4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 18px;
  width: 18px;
  background: #fff;
  border-radius: 50%;
  left: 2px;
    bottom: 1px;
  -webkit-transition: 0.4s;
  transition: 0.4s;
}

input:checked + .slider {
  background: #be0071;
}

input:checked + .slider:before {
  -webkit-transform: translateX(30px);
  -moz-transform: translateX(30px);
  transform: translateX(30px);
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
                        var background_color = '#fff';
                        if (key == 0) {
                            OnClickShowData(item.id)
                             background_color = "#e9e9e9";
                        }
                        var url2 = url + "/application-new-design/" + cat_id + "/" + app_id + "/" + item.id;
                        var edit_url = "{{url('/')}}" + "/sub-content-edit/" + "{{$cat_id}}" + "/{{$app_id}}/{{$parent_id}}/" + item.main_content_id;
                        key = key + 1;
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
                            '<div class="switch"><input type="checkbox" ' + (item.main_content_status == '1' ? "checked" : "") + ' class="toggle-class" data-id="'+ item.main_content_id +'"><span class="slider"></span></div>' +
                            '</div>' +
                            '<div class="plus">' +
                            '<a href="' + edit_url + '" data-url="'+ edit_url +'" class="editUserBtn">' +
                            '<img src = "{{asset("user/assets/icons/copy-img.png")}}" / > ' +
                            ' </a>' +
                            '</div>' +
                            '<div class="plus">' +
                            '<a href="javascript:void(0)" rel="' + item.id + '" data-toggle="modal" data-target="#exampleModalCenter" class="deleteUserBtn">' +
                            '<img src="{{asset("user/assets/icons/delete-img.png")}}" />' +
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
                        var url2 = url + "/application-new-design/" + cat_id + "/" + app_id + "/" + item.id;
                        var edit_url = "{{url('/')}}" + "/sub-content-edit/" + "{{$cat_id}}" + "/{{$app_id}}/{{$parent_id}}/" + item.main_content_id;
                        key = key + 1;
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
                            '<label class="switch"><input type="checkbox" ' + (item.main_content_status == '1' ? "checked" : "") + ' class="toggle-class" data-id="'+ item.main_content_id +'"><span class="slider"></span></label>' +
                            '</div>' +
                            '<div class="plus">' +
                            '<a href="' + edit_url + '" data-url="'+ edit_url +'" class="editUserBtn">' +
                            '<img src = "{{asset("user/assets/icons/copy-img.png")}}" / > ' +
                            ' </a>' +
                            '</div>' +
                            '<div class="plus">' +
                            '<a href="javascript:void(0)" rel="' + item.id + '" data-toggle="modal" data-target="#exampleModalCenter" class="deleteUserBtn">' +
                            '<img src="{{asset("user/assets/icons/delete-img.png")}}" />' +
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

    
 $(document).ready(function(){
    $('body').on('change', '.toggle-class', function() {
        let status = $(this).prop('checked') === true ? 1 : 0;
        let userId = $(this).data('id');
        $.ajax({
            type: 'GET',
            url: "{{ url('/chageaContentstatusNew') }}" +'/' + userId,
            success: function (res) {
                console.log(res);
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