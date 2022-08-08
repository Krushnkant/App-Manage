@extends('user.layouts.layout')

@section('content')
<!-- <link href="{{ url('public/plugins/tables/css/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css"> -->
<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Dashboard</a></li>
            <!-- <li class="breadcrumb-item active"><a href="{{url('application')}}">Application List</a></li> -->
        </ol>
    </div>
</div>
<div class="container-fluid pt-0">
    <div class="row">
        <div class="col-12">
            <div class="card application_part">
                <div class="card-body">
                    <h4 class="card-title mb-4">Application List - Application Management</h4>
                    <div class="text-left mb-4 add_application_btn_part">
                        <a href="{{url('add-application')}}" class="btn gradient-4 btn-lg border-0 btn-rounded add_application_btn">
                            <span class="mr-2 d-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M12 22C17.5 22 22 17.5 22 12C22 6.5 17.5 2 12 2C6.5 2 2 6.5 2 12C2 17.5 6.5 22 12 22Z" stroke="#151415" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M8 12H16" stroke="#151415" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M12 16V8" stroke="#151415" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                            Add Application
                        </a>
                    </div>
                    <ul class="nav application_tab mt-4" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link application_page_tabs active" data-tab="all_application_tab" id="home-tab" data-toggle="tab" href="#all" role="tab" aria-controls="all" aria-selected="falsse">All</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link application_page_tabs" data-tab="active_application_tab" id="profile-tab" data-toggle="tab" href="#active" role="tab" aria-controls="active" aria-selected="true">Active</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link application_page_tabs" data-tab="deactive_application_tab" id="contact-tab" data-toggle="tab" href="#Inactive" role="tab" aria-controls="Inactive" aria-selected="false">Inactive</a>
                    </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                    
                    <div class="tab-pane fade show active" id="active" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="tab-pane fade show active table-responsive table_detail_part" id="all_application_tab">
                            <div class="table-responsive application_table_part">
                                <table id="application_list" class="table zero-configuration customNewtable application_table shadow-none" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>No</th>
                                            <th>Application</th>
                                            <th>App Id</th>
                                            <th>Package Name</th>
                                            <th>Total Request</th>
                                            <th>status</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <!-- <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Application</th>
                                            <th>App Id</th>
                                            <th>Package Name</th>
                                            <th>Total Request</th>
                                            <th>Icon</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                            <th></th>
                                        </tr>
                                    </tfoot> -->
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
@endsection
@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script type="text/javascript">
    function format(d) {
        console.log(d)
        var cat_list = "";
        var token = d.token;
        var UUID = d.app_id;
        var category_id = d.cat_ids;
        var strcuture_id = d.strcuture_id;
        var cat_path = "{{url('api/category-list')}}";
        var content_api_path = "{{url('api/content-list')}}";
        var sub_content_api_path = "{{url('api/sub-content-list')}}";
      
        if(d.is_category == 1){
            cat_list +="<tr><td><span class='evKiBP'>POST</span><span class='mr-2'>|</span><span><p class='dPNnCb'>Get Category List</p></span></td></tr>"+
                        "<tr class='mt-0'><td style='display:block;'><span class='kArPKh text-left'>"+cat_path+"</span></td></tr>"+
                        "<table class='w-100 child-inner-table mb-4 mx-3'>"+
                            "<thead>"+
                                "<tr>"+
                                    "<th><strong>PARAMS</strong></th>"+
                                    "<th><strong>REQUIRED</strong></th>"+
                                    "<th><strong>DATA TYPE</strong></th>"+
                                    "<th class='text-left'><strong>DESCRIPTION</strong></th>"+
                                    "<th class='text-left'><strong>EXAMPLE</strong></th>"+
                                "</tr>"+
                            "</thead>"+
                            "<tbody>"+
                                "<tr>"+
                                    "<td><code>token</code></td>"+
                                    "<td>YES</td>"+
                                    "<td><em>string</em></td>"+
                                    "<td class='text-left'>Token must be same as example</td>"+
                                    "<td class='text-left'>"+token+"</td>"+
                                "</tr>"+
                                "<tr>"+
                                    "<td><code>app_id</code></td>"+
                                    "<td>YES</td>"+
                                    "<td><em>string</em></td>"+
                                    "<td class='text-left'>AppId must be same as example</td>"+
                                    "<td class='text-left'>"+UUID+"</td>"+
                                "</tr>"+
                            "</tbody>"+
                        "</table></tr>"+
                        
                        "<tr class='w-100'><td><div class='px-3'><div class='text-left'><span class='evKiBP'>POST</span><span class='mr-2'>|</span><span><p class='dPNnCb'>Get Content List</p></div></span></td></tr>"+
                        "<tr><td><span class='kArPKh text-left'>"+content_api_path+"</span></td></tr>"+
                        "<tr><p><strong><span>Note:</span></strong></p></tr>"+
                        "<tr><ul><li><span>if you want to get all category then pass (0) instade of category id</span></li></ul></div></tr>"+
                        "<table class='w-100 child-inner-table mb-4 mx-3'>"+
                            "<thead>"+
                                "<tr>"+
                                    "<th><strong>PARAMS</strong></th>"+
                                    "<th><strong>REQUIRED</strong></th>"+
                                    "<th><strong>DATA TYPE</strong></th>"+
                                    "<th class='text-left'><strong>DESCRIPTION</strong></th>"+
                                    "<th class='text-left'><strong>EXAMPLE</strong></th>"+
                                "</tr>"+
                            "</thead>"+
                            "<tbody>"+
                                "<tr>"+
                                    "<td><code>token</code></td>"+
                                    "<td>YES</td>"+
                                    "<td><em>string</em></td>"+
                                    "<td class='text-left'>Token must be same as example</td>"+
                                    "<td class='text-left'>"+token+"</td>"+
                                "</tr>"+
                                "<tr>"+
                                    "<td><code>app_id</code></td>"+
                                    "<td>YES</td>"+
                                    "<td><em>string</em></td>"+
                                    "<td class='text-left'>AppId must be same as example</td>"+
                                    "<td class='text-left'>"+UUID+"</td>"+
                                "</tr>"+
                                "<tr>"+
                                    "<td><code>category_id</code></td>"+
                                    "<td>YES</td>"+
                                    "<td><em>string</em></td>"+
                                    "<td class='text-left'>category_id must be same as example</td>"+
                                    "<td class='text-left'>"+category_id+"</td>"+
                                "</tr>"+
                            "</tbody>"+
                        "</table></tr>"+
                        
                        "<tr class='w-100'><td><div class='text-left px-3'><span class='evKiBP'>POST</span><span class='mr-2'>|</span><span><p class='dPNnCb'>Get Sub Form Content Data List</p></div></span></td></tr>"+
                        "<tr><td><span class='kArPKh text-left mx-3'>"+sub_content_api_path+"</span></td></tr>"+
                        "<table class='w-100 child-inner-table mb-4 mx-3'>"+
                            "<thead>"+
                                "<tr>"+
                                    "<th><strong>PARAMS</strong></th>"+
                                    "<th><strong>REQUIRED</strong></th>"+
                                    "<th><strong>DATA TYPE</strong></th>"+
                                    "<th class='text-left'><strong>DESCRIPTION</strong></th>"+
                                    "<th class='text-left'><strong>EXAMPLE</strong></th>"+
                                "</tr>"+
                            "</thead>"+
                            "<tbody>"+
                                "<tr>"+
                                    "<td><code>token</code></td>"+
                                    "<td>YES</td>"+
                                    "<td><em>string</em></td>"+
                                    "<td class='text-left'>Token must be same as example</td>"+
                                    "<td class='text-left'>"+token+"</td>"+
                                "</tr>"+
                                "<tr>"+
                                    "<td><code>app_id</code></td>"+
                                    "<td>YES</td>"+
                                    "<td><em>string</em></td>"+
                                    "<td class='text-left'>AppId must be same as example</td>"+
                                    "<td class='text-left'>"+UUID+"</td>"+
                                "</tr>"+
                                // "<tr>"+
                                //     "<td><code>category_id</code></td>"+
                                //     "<td>YES</td>"+
                                //     "<td><em>string</em></td>"+
                                //     "<td class='text-left'>category_id must be same as example</td>"+
                                //     "<td class='text-left'>"+category_id+"</td>"+
                                // "</tr>"+
                                "<tr>"+
                                    "<td><code>sub_form_id</code></td>"+
                                    "<td>YES</td>"+
                                    "<td><em>string</em></td>"+
                                    "<td class='text-left'>category_id must be same as example</td>"+
                                    "<td class='text-left'>"+strcuture_id+"</td>"+
                                "</tr>"+
                            "</tbody>"+
                        "</table></tr>";
        }else{
            cat_list +="<tr><td><div class='text-left'><span class='evKiBP'>POST</span><span class='mr-2'>|</span><span><p class='dPNnCb'>Get Content List</p></div></span></td></tr>"+
                        "<tr class='mt-0'><td style='display:block;'><span class='kArPKh text-left'>"+content_api_path+"</span></td></tr>"+
                        "<table class='w-100 child-inner-table mb-4 mx-3'>"+
                            "<thead>"+
                                "<tr>"+
                                    "<th><strong>PARAMS</strong></th>"+
                                    "<th><strong>REQUIRED</strong></th>"+
                                    "<th><strong>DATA TYPE</strong></th>"+
                                    "<th class='text-left'><strong>DESCRIPTION</strong></th>"+
                                    "<th class='text-left'><strong>EXAMPLE</strong></th>"+
                                "</tr>"+
                            "</thead>"+
                            "<tbody>"+
                                "<tr>"+
                                    "<td><code>token</code></td>"+
                                    "<td>YES</td>"+
                                    "<td><em>string</em></td>"+
                                    "<td class='text-left'>Token must be same as example</td>"+
                                    "<td class='text-left'>"+token+"</td>"+
                                "</tr>"+
                                "<tr>"+
                                    "<td><code>app_id</code></td>"+
                                    "<td>YES</td>"+
                                    "<td><em>string</em></td>"+
                                    "<td class='text-left'>AppId must be same as example</td>"+
                                    "<td class='text-left'>"+UUID+"</td>"+
                                "</tr>"+
                            "</tbody>"+
                        "</table></tr>"+
                        
                        "<tr class='w-100'><td><div class='text-left px-3'><span class='evKiBP'>POST</span><span class='mr-2'>|</span><span><p class='dPNnCb'>Get Sub Form Content Data List</p></div></span></td></tr>"+
                        "<tr><td><span class='kArPKh text-left mx-3'>"+sub_content_api_path+"</span></td></tr>"+
                        "<table class='w-100 child-inner-table mb-4 mx-3'>"+
                            "<thead>"+
                                "<tr>"+
                                    "<th><strong>PARAMS</strong></th>"+
                                    "<th><strong>REQUIRED</strong></th>"+
                                    "<th><strong>DATA TYPE</strong></th>"+
                                    "<th class='text-left'><strong>DESCRIPTION</strong></th>"+
                                    "<th class='text-left'><strong>EXAMPLE</strong></th>"+
                                "</tr>"+
                            "</thead>"+
                            "<tbody>"+
                                "<tr>"+
                                    "<td><code>token</code></td>"+
                                    "<td>YES</td>"+
                                    "<td><em>string</em></td>"+
                                    "<td class='text-left'>Token must be same as example</td>"+
                                    "<td class='text-left'>"+token+"</td>"+
                                "</tr>"+
                                "<tr>"+
                                    "<td><code>app_id</code></td>"+
                                    "<td>YES</td>"+
                                    "<td><em>string</em></td>"+
                                    "<td class='text-left'>AppId must be same as example</td>"+
                                    "<td class='text-left'>"+UUID+"</td>"+
                                "</tr>"+
                                "<tr>"+
                                    "<td><code>sub_form_id</code></td>"+
                                    "<td>YES</td>"+
                                    "<td><em>string</em></td>"+
                                    "<td class='text-left'>category_id must be same as example</td>"+
                                    "<td class='text-left'>"+strcuture_id+"</td>"+
                                "</tr>"+
                            "</tbody>"+
                        "</table></tr>";
        }
        
        return '<table cellpadding="5" cellspacing="0" border="0" class="w-100" style="padding-left:50px;" id="child_row">' +
                '<ul class="d-none">'+cat_list+'</ul></table>';
    }
    $(document).ready(function() {

        application_page_tabs('',true);
        
        function get_users_page_tabType(){
            var tab_type;
            $('.application_page_tabs').each(function() {
                var thi = $(this);
                if($(thi).find('a').hasClass('show')){
                    tab_type = $(thi).attr('data-tab');
                }
            });
            return tab_type;
        }

        $(".application_page_tabs").click(function() {
            var tab_type = $(this).attr('data-tab');
          
            application_page_tabs(tab_type,true);
        });

        function application_page_tabs(tab_type='',is_clearState=false) {
       
        if(is_clearState){
            $('#application_list').DataTable().state.clear();
        }
        var table = $('#application_list').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            'stateSave': function(){
                if(is_clearState){
                    return false;
                }
                else{
                    return true;
                }
            },
            "ajax":{
                "url": "{{ url('/application-list') }}",
                "dataType": "json",
                "type": "POST",
                "data":{ _token: '{{ csrf_token() }}',tab_type: tab_type},
            },
            'columnDefs': [
                { "width": "5%", "targets": 0 },
                { "width": "5%", "targets": 1 },
                { "width": "13%", "targets": 2 },
                { "width": "10%", "targets": 3 },
                { "width": "10%", "targets": 4 },
                { "width": "10%", "targets": 5 },
                { "width": "7%", "targets": 6 },
                { "width": "10%", "targets": 7 },
                { "width": "20%", "targets": 8 },
                { "width": "10%", "targets": 9 },
            ],
            "columns": [
                {
                    className: 'dt-control',
                    orderable: false,
                    data: null,
                    defaultContent: "<div class='plus-minus-class'>&nbsp;</div>",
                },
                {data: 'id', name: 'id', class: "text-center", orderable: false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    "mData": "icon",
                    className: 'text-left',
                    "mRender": function (data, type, row) {
                        var img_url = "{{asset('/app_icons/')}}/"+row.icon;
                        return "<div class='application_img_text'><img class='set_img' src="+img_url+" ><span class='application_text ml-2'>"+row.name+"</span></div>";
                    }
                },
                
                {
                    "mData": "app_id",
                    "mRender": function (data, type, row) {
                        return "<div><span class='application_text app_id_part'>"+row.app_id+"</span></div>";
                    }
                },
                {data: 'package_name', name: 'package_name', orderable: false, searchable: false, class: "text-center"},
                {
                    "mData": "field",
                    "mRender": function (data, type, row) {
                        return "<div><span class='application_text app_id_part total_request_text application_text'>"+row.total_request+"</span></div>";
                    }
                },
                {
                    "mData": "status",
                    "mRender": function (data, type, row) {
                        if(row.status == "1"){
                            return '<div><span class="application_text app_id_part active_status" id="applicationstatuscheck_'+row.id+'" onclick="chageapplicationstatus('+row.id+')" value="1" >Active</span></div>';
                        }else{
                            return '<div><span class="application_text app_id_part deactive_status active_status" id="applicationstatuscheck_'+row.id+'" onclick="chageapplicationstatus('+row.id+')" value="2">Deactive</span></div>';
                        }
                    }
                },
                {
                    "mData": "status",
                    "mRender": function (data, type, row) {
                        return "<div><span class='application_text app_id_part date_part'>"+row.start_date+"</span></div>";
                    }
                },
                // {data: 'created_at', name: 'created_at', orderable: false, searchable: false, class: "text-center"},
                {
                    "mData": "action",
                    "mRender": function (data, type, row) {
    
                        var url2 = '{{ url("category-add", "id") }}';
                        url2 = url2.replace('id', row.id);
                        var url3 = '{{ url("content-list") }}'+ '/'+ row.id;
                        // return "<a href='"+url2+"' title=\"Edit\" class='action_btn mr-2'>Category</a>" +
                        //         "<a href='"+url3+"' title=\"Edit\" class='action_btn'>Content</a>";
                        if(row.is_category == 0){
                            return "<a href='"+url3+"' title=\"Edit\" class='action_btn'>Content</a>";
                        }else{
                            return "<a href='"+url2+"' title=\"Edit\" class='action_btn mr-2'>Category</a>" +
                                    "<a href='"+url3+"' title=\"Edit\" class='action_btn'>Content</a>";
                        }
    
                    }
                },
                {
                    "mData": "-",
                    "mRender": function (data, type, row) {
    
                        var url1 = '{{ Route("application.edit", "id") }}';
                        url1 = url1.replace('id', row.id);
                        var img_url1 = "{{asset('user/assets/icons/edit.png')}}";
                        var img_url2 = "{{asset('user/assets/icons/delete.png')}}";
                        var img_url3 = "{{asset('user/assets/icons/copy.png')}}";
    
                        return  "<a href='" + url1 + "' title=\"copy\" class='application_text mr-4'><img src='" + img_url3 + "' alt=''></a>" +
                        "<a href='" + url1 + "' title=\"Edit\" class='application_text mr-4'><img src='" + img_url1 + "' alt=''></a>" +
                            "<a rel='" + row.id + "' title=\"Delete\" href='javascript:void(0)' data-id='"
                            +row.id+"' data-toggle='modal' data-target='#exampleModalCenter' class='deleteUserBtn'><img src='" + img_url2 + "' alt=''></a>";
                    }
                }
            ],
            order: [[1, 'asc']],
        });
    
        $('#application_list tbody').on('click', 'td.dt-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);
            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
            } else {
                row.child(format(row.data())).show();
                tr.addClass('shown');
            }
        });

        }
    })

    $('body').on('click', '.deleteUserBtn', function (e) {
        var delete_user_id = $(this).attr('data-id');
        $("#exampleModalCenter").find('#RemoveUserSubmit').attr('data-id',delete_user_id);
    });

    $('body').on('click', '#RemoveUserSubmit', function (e) {
        $('#RemoveUserSubmit').prop('disabled',true);
        // e.preventDefault();
        var remove_user_id = $(this).attr('data-id');

        $.ajax({
            type: 'GET',
            url: "{{ url('/application') }}" +'/' + remove_user_id +'/delete',
            success: function (res) {
                if(res.status == 200){
                    $("#exampleModalCenter").modal('hide');
                    $('#RemoveUserSubmit').prop('disabled',false);
                    $('#application_list').DataTable().draw();
                    toastr.success("Application Deleted",'Success',{timeOut: 5000});
                }else{
                    $("#exampleModalCenter").modal('hide');
                    $('#RemoveUserSubmit').prop('disabled',false);
                }
            },
            error: function (data) {
                toastr.error("Please try again",'Error',{timeOut: 5000});
            }
        });
    });

    function chageapplicationstatus(app_id) {
            $.ajax({
                type: 'GET',
                url: "{{ url('/chageapplicationstatus') }}" +'/' + app_id,
                success: function (res) {
                    
                    if(res.status == 200 && res.action=='deactive'){
                        toastr.success("Application Deactivated",'Success',{timeOut: 5000});
                        $('#application_list').DataTable().draw();
                    }
                    if(res.status == 200 && res.action=='active'){
                        toastr.success("Application activated",'Success',{timeOut: 5000});
                        $('#application_list').DataTable().draw();
                    }
                },
                error: function (data) {
                    toastr.error("Please try again",'Error',{timeOut: 5000});
                }
            });
        }
</script>
@endpush('scripts')