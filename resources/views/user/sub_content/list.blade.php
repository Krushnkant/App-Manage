@extends('user.layouts.layout')

@section('content')
<!-- <link href="{{ url('public/plugins/tables/css/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css"> -->
<style>
    .application_img_text {
        display: flex;
    }
</style>
<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" /> -->
<div>
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Dashboard</a></li>
                @if(isset($parent_id) && $parent_id != 0)
                <li class="breadcrumb-item"><a href="{{url('sub-content/'.$app_id.'/'.$cat_id.'/'.$parent_id)}}">Back List</a></li>
                @else
                <li class="breadcrumb-item"><a href="{{url('category-add-new/'.$app_id)}}">Category List</a></li>
                @endif
                <li class="breadcrumb-item active">Application List</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid pt-0">
        <div class="row">
            <div class="col-12">
                <div class="card application_part">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Sub Content List - Application Management</h4>
                        <div class="text-left mb-4 add_application_btn_part">
                            <a href="{{url('sub-content-form/'.$app_id.'/'.$cat_id.'/'.$parent_id)}}" class="btn gradient-4 btn-lg border-0 btn-rounded add_application_btn">
                                <span class="mr-2 d-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M12 22C17.5 22 22 17.5 22 12C22 6.5 17.5 2 12 2C6.5 2 2 6.5 2 12C2 17.5 6.5 22 12 22Z" stroke="#151415" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M8 12H16" stroke="#151415" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M12 16V8" stroke="#151415" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                Add content
                            </a>
                            <a href="{{url('sub-form-structure/'.$app_id.'/'.$cat_id.'/'.$parent_id)}}" class="btn gradient-4 btn-lg border-0 btn-rounded add_application_btn">
                                <span class="mr-2 d-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M12 22C17.5 22 22 17.5 22 12C22 6.5 17.5 2 12 2C6.5 2 2 6.5 2 12C2 17.5 6.5 22 12 22Z" stroke="#151415" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M8 12H16" stroke="#151415" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M12 16V8" stroke="#151415" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                Form Structure
                            </a>
                        </div>
                        <!-- <ul class="nav application_tab mt-4" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link application_page_tabs active" data-tab="all_application_tab" id="home-tab" data-toggle="tab" href="#all" role="tab" aria-controls="all" aria-selected="falsse">All</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link application_page_tabs" data-tab="active_application_tab" id="profile-tab" data-toggle="tab" href="#active" role="tab" aria-controls="active" aria-selected="true">Active</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link application_page_tabs" data-tab="deactive_application_tab" id="contact-tab" data-toggle="tab" href="#Inactive" role="tab" aria-controls="Inactive" aria-selected="false">Inactive</a>
                            </li>
                        </ul> -->
                        <div class="tab-content" id="myTabContent">

                            <div class="tab-pane fade show active" id="active" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="tab-pane fade show active table-responsive table_detail_part" id="all_application_tab">
                                    <div class="table-responsive application_table_part">
                                        <table id="content_list" class="table zero-configuration customNewtable application_table shadow-none" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <!-- <th></th> -->
                                                    <th>No</th>
                                                    <th>Application</th>
                                                    <th>Category</th>
                                                    <th>Form Title</th>
                                                    <th>status</th>
                                                    <th>Data</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <!-- <th></th> -->
                                                    <th>No</th>
                                                    <th>Application</th>
                                                    <th>Category</th>
                                                    <th>Form Title</th>
                                                    <th>status</th>
                                                    <th>Data</th>
                                                    <th>Action</th>
                                                </tr>
                                            </tfoot>
                                        </table>
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
    </div>
</div>
@endsection
@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script> -->
<script type="text/javascript">
    function copyToClipboard(element) {
        navigator.clipboard.writeText(element);
    }

    // function format(d) {
    //     // console.log(d)
    //     var cat_list = "";
    //     var token = d.token;
    //     var test_token = d.test_token;
    //     var UUID = d.app_id;
    //     var category_id = d.cat_ids;
    //     var strcuture_id = d.strcuture_id;
    //     var cat_path = "{{url('api/category-list')}}";
    //     var content_api_path = "{{url('api/content-list')}}";
    //     var sub_content_api_path = "{{url('api/sub-content-list')}}";

    //     if (d.is_category == 1) {
    //         cat_list += "<tr><td><span class='evKiBP'>POST</span><span class='mr-2'>|</span><span><p class='dPNnCb'>Get Category List</p></span></td></tr>" +
    //             "<tr class='mt-0'><td style='display:block;'><span class='kArPKh text-left'>" + cat_path + " <button class='btn_copy' onclick=copyToClipboard('" + cat_path + "')><img class='copy_svg' src='{{asset('user/assets/icons/copy.svg')}}' /></button></span></td></tr>" +
    //             "<table class='w-100 child-inner-table mb-4 mx-3'>" +
    //             "<thead>" +
    //             "<tr>" +
    //             "<th><strong>PARAMS</strong></th>" +
    //             "<th><strong>REQUIRED</strong></th>" +
    //             "<th><strong>DATA TYPE</strong></th>" +
    //             "<th class='text-left'><strong>DESCRIPTION</strong></th>" +
    //             "<th class='text-left'><strong>EXAMPLE</strong></th>" +
    //             "</tr>" +
    //             "</thead>" +
    //             "<tbody>" +
    //             "<tr>" +
    //             "<td><code>token</code></td>" +
    //             "<td>YES</td>" +
    //             "<td><em>string</em></td>" +
    //             "<td class='text-left'>Token must be same as example</td>" +
    //             "<td class='text-left'>" + token + ", " + test_token + "</td>" +
    //             "</tr>" +
    //             // "<tr>"+
    //             //     "<td><code>app_id</code></td>"+
    //             //     "<td>YES</td>"+
    //             //     "<td><em>string</em></td>"+
    //             //     "<td class='text-left'>AppId must be same as example</td>"+
    //             //     "<td class='text-left'>"+UUID+"</td>"+
    //             // "</tr>"+
    //             "</tbody>" +
    //             "</table></tr>" +

    //             "<tr class='w-100'><td><div class='px-3'><div class='text-left'><span class='evKiBP'>POST</span><span class='mr-2'>|</span><span><p class='dPNnCb'>Get Content List</p></div></span></td></tr>" +
    //             "<tr><td><span class='kArPKh text-left'>" + content_api_path + " <button class='btn_copy' onclick=copyToClipboard('" + content_api_path + "')><img class='copy_svg' src='{{asset('user/assets/icons/copy.svg')}}' /></button></span></td></tr>" +
    //             "<tr><p><strong><span>Note:</span></strong></p></tr>" +
    //             "<tr><ul><li><span>if you want to get all category then pass (0) instade of category id</span></li></ul></div></tr>" +
    //             "<table class='w-100 child-inner-table mb-4 mx-3'>" +
    //             "<thead>" +
    //             "<tr>" +
    //             "<th><strong>PARAMS</strong></th>" +
    //             "<th><strong>REQUIRED</strong></th>" +
    //             "<th><strong>DATA TYPE</strong></th>" +
    //             "<th class='text-left'><strong>DESCRIPTION</strong></th>" +
    //             "<th class='text-left'><strong>EXAMPLE</strong></th>" +
    //             "</tr>" +
    //             "</thead>" +
    //             "<tbody>" +
    //             "<tr>" +
    //             "<td><code>token</code></td>" +
    //             "<td>YES</td>" +
    //             "<td><em>string</em></td>" +
    //             "<td class='text-left'>Token must be same as example</td>" +
    //             "<td class='text-left'>" + token + ", " + test_token + "</td>" +
    //             "</tr>" +
    //             // "<tr>"+
    //             //     "<td><code>app_id</code></td>"+
    //             //     "<td>YES</td>"+
    //             //     "<td><em>string</em></td>"+
    //             //     "<td class='text-left'>AppId must be same as example</td>"+
    //             //     "<td class='text-left'>"+UUID+"</td>"+
    //             // "</tr>"+
    //             "<tr>" +
    //             "<td><code>category_id</code></td>" +
    //             "<td>YES</td>" +
    //             "<td><em>string</em></td>" +
    //             "<td class='text-left'>category_id must be same as example</td>" +
    //             "<td class='text-left'>-</td>" +
    //             "</tr>" +
    //             "</tbody>" +
    //             "</table></tr>" +

    //             "<tr class='w-100'><td><div class='text-left px-3'><span class='evKiBP'>POST</span><span class='mr-2'>|</span><span><p class='dPNnCb'>Get Sub Form Content Data List</p></div></span></td></tr>" +
    //             "<tr><td><span class='kArPKh text-left mx-3'>" + sub_content_api_path + " <button class='btn_copy' onclick=copyToClipboard('" + sub_content_api_path + "')><img class='copy_svg' src='{{asset('user/assets/icons/copy.svg')}}' /></button></span></td></tr>" +
    //             "<table class='w-100 child-inner-table mb-4 mx-3'>" +
    //             "<thead>" +
    //             "<tr>" +
    //             "<th><strong>PARAMS</strong></th>" +
    //             "<th><strong>REQUIRED</strong></th>" +
    //             "<th><strong>DATA TYPE</strong></th>" +
    //             "<th class='text-left'><strong>DESCRIPTION</strong></th>" +
    //             "<th class='text-left'><strong>EXAMPLE</strong></th>" +
    //             "</tr>" +
    //             "</thead>" +
    //             "<tbody>" +
    //             "<tr>" +
    //             "<td><code>token</code></td>" +
    //             "<td>YES</td>" +
    //             "<td><em>string</em></td>" +
    //             "<td class='text-left'>Token must be same as example</td>" +
    //             "<td class='text-left'>" + token + ", " + test_token + "</td>" +
    //             "</tr>" +
    //             // "<tr>"+
    //             //     "<td><code>app_id</code></td>"+
    //             //     "<td>YES</td>"+
    //             //     "<td><em>string</em></td>"+
    //             //     "<td class='text-left'>AppId must be same as example</td>"+
    //             //     "<td class='text-left'>"+UUID+"</td>"+
    //             // "</tr>"+
    //             // "<tr>"+
    //             //     "<td><code>category_id</code></td>"+
    //             //     "<td>YES</td>"+
    //             //     "<td><em>string</em></td>"+
    //             //     "<td class='text-left'>category_id must be same as example</td>"+
    //             //     "<td class='text-left'>"+category_id+"</td>"+
    //             // "</tr>"+
    //             "<tr>" +
    //             "<td><code>sub_form_id</code></td>" +
    //             "<td>YES</td>" +
    //             "<td><em>string</em></td>" +
    //             "<td class='text-left'>category_id must be same as example</td>" +
    //             "<td class='text-left'>-</td>" +
    //             "</tr>" +
    //             "</tbody>" +
    //             "</table></tr>";
    //     } else {
    //         cat_list += "<tr><td><div class='text-left'><span class='evKiBP'>POST</span><span class='mr-2'>|</span><span><p class='dPNnCb'>Get Content List</p></div></span></td></tr>" +
    //             "<tr class='mt-0'><td style='display:block;'><span class='kArPKh text-left'>" + content_api_path + " <button class='btn_copy' onclick=copyToClipboard('" + content_api_path + "')><img class='copy_svg' src='{{asset('user/assets/icons/copy.svg')}}' /></button></span></td></tr>" +
    //             "<table class='w-100 child-inner-table mb-4 mx-3'>" +
    //             "<thead>" +
    //             "<tr>" +
    //             "<th><strong>PARAMS</strong></th>" +
    //             "<th><strong>REQUIRED</strong></th>" +
    //             "<th><strong>DATA TYPE</strong></th>" +
    //             "<th class='text-left'><strong>DESCRIPTION</strong></th>" +
    //             "<th class='text-left'><strong>EXAMPLE</strong></th>" +
    //             "</tr>" +
    //             "</thead>" +
    //             "<tbody>" +
    //             "<tr>" +
    //             "<td><code>token</code></td>" +
    //             "<td>YES</td>" +
    //             "<td><em>string</em></td>" +
    //             "<td class='text-left'>Token must be same as example</td>" +
    //             "<td class='text-left'>" + token + ", " + test_token + "</td>" +
    //             "</tr>" +
    //             // "<tr>"+
    //             //     "<td><code>app_id</code></td>"+
    //             //     "<td>YES</td>"+
    //             //     "<td><em>string</em></td>"+
    //             //     "<td class='text-left'>AppId must be same as example</td>"+
    //             //     "<td class='text-left'>"+UUID+"</td>"+
    //             // "</tr>"+
    //             "</tbody>" +
    //             "</table></tr>" +

    //             "<tr class='w-100'><td><div class='text-left px-3'><span class='evKiBP'>POST</span><span class='mr-2'>|</span><span><p class='dPNnCb'>Get Sub Form Content Data List</p></div></span></td></tr>" +
    //             "<tr><td><span class='kArPKh text-left mx-3'>" + sub_content_api_path + " <button class='btn_copy' onclick=copyToClipboard('" + sub_content_api_path + "')><img class='copy_svg' src='{{asset('user/assets/icons/copy.svg')}}' /></button></span></td></tr>" +
    //             "<table class='w-100 child-inner-table mb-4 mx-3'>" +
    //             "<thead>" +
    //             "<tr>" +
    //             "<th><strong>PARAMS</strong></th>" +
    //             "<th><strong>REQUIRED</strong></th>" +
    //             "<th><strong>DATA TYPE</strong></th>" +
    //             "<th class='text-left'><strong>DESCRIPTION</strong></th>" +
    //             "<th class='text-left'><strong>EXAMPLE</strong></th>" +
    //             "</tr>" +
    //             "</thead>" +
    //             "<tbody>" +
    //             "<tr>" +
    //             "<td><code>token</code></td>" +
    //             "<td>YES</td>" +
    //             "<td><em>string</em></td>" +
    //             "<td class='text-left'>Token must be same as example</td>" +
    //             "<td class='text-left'>" + token + ", " + test_token + "</td>" +
    //             "</tr>" +
    //             // "<tr>"+
    //             //     "<td><code>app_id</code></td>"+
    //             //     "<td>YES</td>"+
    //             //     "<td><em>string</em></td>"+
    //             //     "<td class='text-left'>AppId must be same as example</td>"+
    //             //     "<td class='text-left'>"+UUID+"</td>"+
    //             // "</tr>"+
    //             "<tr>" +
    //             "<td><code>sub_form_id</code></td>" +
    //             "<td>YES</td>" +
    //             "<td><em>string</em></td>" +
    //             "<td class='text-left'>category_id must be same as example</td>" +
    //             "<td class='text-left'>-</td>" +
    //             "</tr>" +
    //             "</tbody>" +
    //             "</table></tr>";
    //     }

    //     return '<table cellpadding="5" cellspacing="0" border="0" class="w-100" style="padding-left:50px;" id="child_row">' +
    //         '<ul class="d-none">' + cat_list + '</ul></table>';
    // }
    $(document).ready(function() {

        application_page_tabs('', true);

        //     function get_users_page_tabType() {
        //         var tab_type;
        //         $('.application_page_tabs').each(function() {
        //             var thi = $(this);
        //             if ($(thi).find('a').hasClass('show')) {
        //                 tab_type = $(thi).attr('data-tab');
        //             }
        //         });
        //         return tab_type;
        //     }

        //     $(".application_page_tabs").click(function() {
        //         var tab_type = $(this).attr('data-tab');

        //         application_page_tabs(tab_type, true);
        //     });

        function application_page_tabs(tab_type = '', is_clearState = false) {
            var url = "{{url('/')}}";
            var cat_id = "{{$cat_id}}";
            var app_id = "{{$app_id}}";
            var parent_id = "{{$parent_id}}";
            // console.log(cat_id)
            // console.log(app_id)
            // console.log(parent_id)
            // console.log(url + "/content-list-get/" + app_id + "/" + cat_id + "/" + parent_id)
            // console.log(url+"/sub-content/"+cat_id+"/"+app_id+"/parent")
            if (is_clearState) {
                $('#content_list').DataTable().state.clear();
            }
            var table = $('#content_list').DataTable({
                "destroy": true,
                "processing": true,
                "serverSide": true,
                'stateSave': function() {
                    if (is_clearState) {
                        return false;
                    } else {
                        return true;
                    }
                },
                "ajax": {
                    "url": url + "/content-list-get/" + cat_id + "/" + app_id + "/" + parent_id,
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        _token: '{{ csrf_token() }}',
                        tab_type: tab_type
                    },
                },
                'columnDefs': [{
                        "width": "5%",
                        "targets": 0
                    },
                    {
                        "width": "5%",
                        "targets": 1
                    },
                    {
                        "width": "13%",
                        "targets": 2
                    },
                    {
                        "width": "10%",
                        "targets": 3
                    },
                    {
                        "width": "10%",
                        "targets": 4
                    },
                    {
                        "width": "10%",
                        "targets": 5
                    },
                    {
                        "width": "10%",
                        "targets": 6
                    },
                    // { "width": "10%", "targets": 9 },
                ],
                "columns": [{
                        data: 'id',
                        name: 'id',
                        class: "text-center",
                        orderable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'app_name',
                        name: 'app_name',
                        class: "text-center",
                        orderable: false,
                        render: function(data, type, row, meta) {
                            return row.app_name;
                        }
                    },
                    // {
                    //     "mData": "icon",
                    //     className: 'text-left',
                    //     "mRender": function(data, type, row) {
                    //         var html = '';
                    //         var id = "myModal" + row.id;
                    //         var ids = "#myModal" + row.id;
                    //         var image_video1 = '';
                    //         var img_url = row.icon_url;
                    //         var filename1 = row.icon_url;

                    //         if (row.is_url == 1) {
                    //             if (row.icon_url.match("jpg") || row.icon_url.match("png") || row.icon_url.match("jpeg")) {
                    //                 image_video1 += "<img class='set_img' class='set_img' data-toggle='modal' data-target='" + ids + "' src='" + filename1 + "' />";
                    //             } else {
                    //                 if (row.icon_url.match("mp4")) {
                    //                     image_video1 += "<iframe src='" + filename1 + "' title='video' allowfullscreen></iframe>";
                    //                 } else if (row.icon_url.match("youtube")) {
                    //                     const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/;
                    //                     const match = row.icon_url.match(regExp);
                    //                     image_video1 += '<iframe src="https://www.youtube.com/embed/' +
                    //                         match[2] + '" frameborder="0" allowfullscreen></iframe>';

                    //                 }
                    //             }
                    //             html = '<div id="' + id + '" class="modal fade" role="dialog">' +
                    //                 '<div class="modal-dialog">' +
                    //                 '<div class="modal-content">' +
                    //                 '<div class="modal-body">' + image_video1 + '</div>' +
                    //                 '<div class="modal-footer">' +
                    //                 '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>' +
                    //                 '</div>' +
                    //                 '</div>' +
                    //                 '</div>' +
                    //                 '</div>';
                    //         } else {
                    //             var filename = row.icon;
                    //             var valid_extensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
                    //             var valid_video_extensions = /(\.mp4|\.webm|\.m4v)$/i;
                    //             var image_video = '';
                    //             var img_url = "{{asset('/app_icons/')}}/" + row.icon;
                    //             var video_url = "{{asset('/app_icons/')}}/" + row.icon;
                    //             if (valid_extensions.test(filename)) {
                    //                 image_video += '<img class="img-responsive" src="' + img_url + '" />';
                    //             } else {
                    //                 if (valid_video_extensions.test(filename)) {
                    //                     image_video += '<iframe src="' + video_url + '" title="video" allowfullscreen></iframe>';
                    //                 }
                    //             }
                    //             var img_url = "{{asset('/app_icons/')}}/" + row.icon;
                    //             html = '<div id="' + id + '" class="modal fade" role="dialog">' +
                    //                 '<div class="modal-dialog">' +
                    //                 '<div class="modal-content">' +
                    //                 '<div class="modal-body">' + image_video + '</div>' +
                    //                 '<div class="modal-footer">' +
                    //                 '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>' +
                    //                 '</div>' +
                    //                 '</div>' +
                    //                 '</div>' +
                    //                 '</div>';
                    //         }
                    //         if (row.is_url == 1) {
                    //             var image_video1 = '';
                    //             var img_url = row.icon_url;
                    //             var filename1 = row.icon_url;
                    //             if (row.icon_url != null) {
                    //                 if (row.icon_url.match("jpg") || row.icon_url.match("png") || row.icon_url.match("jpeg")) {
                    //                     image_video1 += "<img class='set_img' class='set_img' data-toggle='modal' data-target='" + ids + "' src='" + filename1 + "' />";
                    //                 } else {
                    //                     if (row.icon_url.match("mp4") || row.icon_url.match("youtube")) {
                    //                         image_video1 += "<img class='set_img' class='set_img' data-toggle='modal' data-target='" + ids + "' src='{{asset('user/assets/icons/video_icon.jpg')}}' />";
                    //                     }
                    //                 }
                    //             } else {
                    //                 image_video1 += "<img class='set_img' src='{{asset('user/assets/icons/dummy_img.jpg')}}' />";
                    //             }
                    //             return "<div class='application_img_text'>" + html + "<div class='images'>" + image_video1 + "</div><span class='application_text ml-2'>" + row.name + "</span></div>";
                    //         } else {
                    //             var image_video1 = '';
                    //             var img_url = "{{asset('/app_icons/')}}/" + row.icon;
                    //             if (row.icon != null) {
                    //                 if (valid_extensions.test(filename)) {
                    //                     var img_url = "{{asset('/app_icons/')}}/" + row.icon;
                    //                     image_video1 += "<img class='set_img' class='set_img' data-toggle='modal' data-target='" + ids + "' src='" + img_url + "' />";
                    //                 } else {
                    //                     var video_url = "{{asset('/app_icons/')}}/" + row.icon;
                    //                     if (valid_video_extensions.test(filename)) {
                    //                         image_video1 += "<img class='set_img' class='set_img' data-toggle='modal' data-target='" + ids + "' src='{{asset('user/assets/icons/video_icon.jpg')}}' />";
                    //                     }
                    //                 }
                    //             } else {
                    //                 image_video1 += "<img class='set_img' src='{{asset('user/assets/icons/dummy_img.jpg')}}' />";
                    //             }
                    //             return "<div class='application_img_text'>" + html + "<div class='images'>" + image_video1 + "</div><span class='application_text ml-2'>" + row.name + "</span></div>";
                    //         }
                    //     }
                    // },
                    {
                        "mData": "category_name",
                        "mRender": function(data, type, row) {
                            return row.category_name;
                            // if (row.app_id != null) {
                            //     return "<div><span class='application_text app_id_part'>" + row.app_id + "</span></div>";
                            // } else {
                            //     return "<div><span class='application_text app_id_part'>-</span></div>";
                            // }
                        }
                    },
                    {
                        "mData": "form_title",
                        "mRender": function(data, type, row) {
                            return row.form_title;
                        }
                    },
                    // {
                    //     "mData": "package_name",
                    //     "mRender": function(data, type, row) {
                    //         var multi_link = [];
                    //         if (row.package_name != null) {
                    //             var hasApple = row.package_name.indexOf(',') != -1;
                    //             if (hasApple === true) {
                    //                 var strarray = row.package_name.split(',');
                    //                 $(strarray).each(function(index, value) {
                    //                     var concat_string = "https://play.google.com/store/apps/details?id=" + value;
                    //                     var concat_string1 = "<a class='link_playstore' href='" + concat_string + "' target='_blank'>" + value + "</a>";
                    //                     multi_link.push(concat_string1);
                    //                 });
                    //                 multi_link = multi_link.join(", ");
                    //             } else {
                    //                 var concat_string = "https://play.google.com/store/apps/details?id=" + row.package_name;
                    //                 multi_link = "<a class='link_playstore' href='" + concat_string + "' target='_blank'>" + row.package_name + "</a>";
                    //             }
                    //             return "<div><span class='application_text app_id_part'>" + multi_link + "</span></div>";
                    //         } else {
                    //             return "<div><span class='application_text app_id_part'>-</span></div>";
                    //         }
                    //     }
                    // },
                    // {data: 'package_name', name: 'package_name', orderable: false, searchable: false, class: "text-center"},
                    // {
                    //     "mData": "field",
                    //     "mRender": function(data, type, row) {
                    //         var cat_request = "0";
                    //         if (row.cat_total_request != null) {
                    //             cat_request = row.cat_total_request
                    //         }
                    //         var total_request = "0";
                    //         if (row.total_request != null) {
                    //             total_request = row.total_request
                    //         }
                    //         // return "<tr><td>"+cat_request+"</td><td>"+total_request+"</td></tr>";
                    //         return "<div><span class='application_text app_id_part total_request_text application_text'>" + cat_request + " | " + total_request + "</span></div>";
                    //     }
                    // },
                    {
                        "mData": "status",
                        "mRender": function(data, type, row) {
                            if (row.status == "1") {
                                return '<div><span class="application_text app_id_part active_status" id="applicationstatuscheck_' + row.id + '" onclick="chageapplicationstatus(' + row.id + ')" value="1" >Active</span></div>';
                            } else {
                                return '<div><span class="application_text app_id_part deactive_status active_status" id="applicationstatuscheck_' + row.id + '" onclick="chageapplicationstatus(' + row.id + ')" value="2">Deactive</span></div>';
                            }
                        }
                    },
                    // {
                    //     "mData": "status",
                    //     "mRender": function (data, type, row) {
                    //         return "<div><span class='application_text app_id_part date_part'>"+row.start_date+"</span></div>";
                    //     }
                    // },
                    // {data: 'created_at', name: 'created_at', orderable: false, searchable: false, class: "text-center"},
                    {
                        "mData": "action",
                        "mRender": function(data, type, row) {

                            var url2 = url + "/sub-content/" + app_id + "/" + cat_id + "/" + row.id;
                            // console.log(url2)
                            // var url2 = '{{ url("category-add-new", "id") }}';
                            // url2 = url2.replace('id', row.id);
                            // var url3 = '{{ url("content-list") }}' + '/' + row.id;
                            // return "<a href='"+url2+"' title=\"Edit\" class='action_btn mr-2'>Category</a>" +
                            //         "<a href='"+url3+"' title=\"Edit\" class='action_btn'>Content</a>";
                            // if (row.is_category == 0) {
                            //     return "<a href='" + url3 + "' title=\"Edit\" class='action_btn'>Content</a>";
                            // } else {
                            //     "<a href='" + url3 + "' title=\"Edit\" class='action_btn'>Content</a>";
                            // }
                            return "<a href='" + url2 + "' title='sub-content' class='application_text mr-4 btn'>Sub Content</a>";

                        }
                    },
                    {
                        "mData": "-",
                        "mRender": function(data, type, row) {
                            // console.log(row)

                            var url1 = '{{ Route("application.edit", "id") }}';
                            url1 = url1.replace('id', row.id);
                            var img_url1 = "{{asset('user/assets/icons/edit.png')}}";
                            var img_url2 = "{{asset('user/assets/icons/delete.png')}}";
                            var img_url3 = "{{asset('user/assets/icons/copy.png')}}";

                            var edit_url = "{{url('/')}}"+"/sub-content-edit/"+"{{$cat_id}}"+"/{{$app_id}}/{{$parent_id}}/"+row.main_content_id;
                            // console.log(edit_url)

                            return "<a href='" + url1 + "' title=\"copy\" class='application_text mr-4'><img src='" + img_url3 + "' alt=''></a>" +
                                "<a href='" + edit_url + "' title=\"Edit\" class='application_text mr-4'><img src='" + img_url1 + "' alt=''></a>" +
                                "<a rel='" + row.id + "' title=\"Delete\" href='javascript:void(0)' data-id='" +
                                row.id + "' data-toggle='modal' data-target='#exampleModalCenter' class='deleteUserBtn'><img src='" + img_url2 + "' alt=''></a>";
                        }
                    }
                ],
                order: [
                    [1, 'asc']
                ],
            });

            // $('#content_list tbody').on('click', 'td.dt-control', function() {
            //     var tr = $(this).closest('tr');
            //     var row = table.row(tr);
            //     if (row.child.isShown()) {
            //         row.child.hide();
            //         tr.removeClass('shown');
            //     } else {
            //         row.child(format(row.data())).show();
            //         tr.addClass('shown');
            //     }
            // });

        }

    })
</script>
@endpush('scripts')