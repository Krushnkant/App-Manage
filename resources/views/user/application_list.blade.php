@extends('user.layouts.layout')

@section('content')
<link href="{{ url('public/plugins/tables/css/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<div class="container-fluid mt-3">
    <div class="row">
        <div class="col-12">
            <div class="card application_part">
                <div class="card-body">
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
                    <h4 class="card-title mb-0">Application List</h4>
                    <ul class="nav application_tab mt-4" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link" id="home-tab" data-toggle="tab" href="#all" role="tab" aria-controls="all" aria-selected="falsse">All</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#active" role="tab" aria-controls="active" aria-selected="true">Active</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#Inactive" role="tab" aria-controls="Inactive" aria-selected="false">Inactive</a>
                    </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade" id="all" role="tabpanel" aria-labelledby="home-tab">...</div>
                    <div class="tab-pane fade show active" id="active" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="tab-pane fade show active table-responsive table_detail_part">
                            <div class="table-responsive">
                                <table id="application_list" class="table zero-configuration customNewtable application_table" style="width:100%">
                                    <thead>
                                        <tr>
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
                    <div class="tab-pane fade" id="Inactive" role="tabpanel" aria-labelledby="contact-tab">...</div>
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary delete" id="RemoveUserSubmit">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<!-- dataTable -->


<script type="text/javascript">
    // $(function () {
    //     var table = $('.data-table').DataTable({
    //         processing: true,
    //         serverSide: true,
    //         ajax: "{{url('application')}}",
    //         columns: [
    //             {data: 'id', name: 'id'},
    //             {data: 'name', name: 'name'},
    //             {data: 'email', name: 'email'},
    //             {data: 'action', name: 'action', orderable: false, searchable: false},
    //         ]
    //     });
    // });
    // var url = "{{asset('/')}}"
    // var is_date_search = false;
    // $(document).ready(function() {
    //     // $('#application_list').DataTable({
    //     var table = $('#application_list').dataTable( {
    //         // "lengthMenu": [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]],
    //         "processing": true,
    //         "serverSide": true,
    //         order: [[1, 'desc']],
    //         "ajax": {
    //             "url": url + 'application-list',
    //             "method": 'POST',
    //             datatype: 'json',
    //             data: {                           
    //                 is_date_search: is_date_search
    //             },
    //             headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             },
    //         },
    //         columns: [
    //             {data: 'id', name: 'id'},
    //             {data: 'name', name: 'name'},
    //             {data: 'icon', name: 'icon'},
    //             {data: 'app_id', name: 'app_id'},
    //             {data: 'package_name', name: 'package_name'},
    //             {data: 'action', name: 'action'},
    //         ],
    //     });
    //     // table.destroy();
    //     // new $.fn.dataTable.FixedHeader( table );
    // })
    $(document).ready(function() {
        $('#application_list').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "ajax":{
                "url": "{{ url('/application-list') }}",
                "dataType": "json",
                "type": "POST",
                "data":{ _token: '{{ csrf_token() }}'},
            },
            'columnDefs': [
                { "width": "", "targets": 0 },
                { "width": "", "targets": 1 },
                { "width": "", "targets": 2 },
                { "width": "", "targets": 3 },
                { "width": "", "targets": 4 },
                { "width": "", "targets": 5 },
                { "width": "", "targets": 6 },
                { "width": "", "targets": 7 },
            ],
            "columns": [
                {data: 'id', name: 'id', class: "text-center", orderable: false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    "mData": "icon",
                    "mRender": function (data, type, row) {
                        var img_url = "{{asset('/app_icons/')}}/"+row.icon;
                        return "<div class='application_img_text'><img class='set_img' src="+img_url+" ><span class='application_text ml-2'>"+row.name+"</span></div>";
                    }
                },
                {
                    "mData": "field",
                    "mRender": function (data, type, row) {
                        return "<div><span class='application_text app_id_part total_request_text application_text'>155675</span></div>";
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
                    "mData": "status",
                    "mRender": function (data, type, row) {
                        if(row.status == "1"){
                            return "<div><span class='application_text app_id_part active_status'>Active</span></div>";
                        }else{
                            return "<div><span class='application_text app_id_part deactive_status active_status'>Deactive</span></div>";
                        }
                    }
                },
                {
                    "mData": "status",
                    "mRender": function (data, type, row) {
                        return "<div><span class='application_text app_id_part date_part'>10 Apr 2022</span></div>";
                    }
                },
                // {data: 'created_at', name: 'created_at', orderable: false, searchable: false, class: "text-center"},
                {
                    "mData": "action",
                    "mRender": function (data, type, row) {

                        var url2 = '{{ url("category-add", "id") }}';
                        url2 = url2.replace('id', row.id);

                        var url3 = '{{ url("addcontent") }}'+ '/'+ row.id;

                        return "<a href='"+url2+"' title=\"Edit\" class='action_btn mr-2'>Add Category</a>" +
                         "<a href='"+url3+"' title=\"Edit\" class='action_btn'>Add Content</a>";
                    }
                },
                {
                    "mData": "-",
                    "mRender": function (data, type, row) {

                        var url1 = '{{ Route("application.edit", "id") }}';
                        url1 = url1.replace('id', row.id);
                        var img_url1 = "{{asset('user/assets/icons/edit.png')}}";
                        var img_url2 = "{{asset('user/assets/icons/delete.png')}}";

                        return "<a href='" + url1 + "' title=\"Edit\" class='application_text mr-4'><img src='" + img_url1 + "' alt=''></a>" +
                            "<a rel='" + row.id + "' title=\"Delete\" href='javascript:void(0)' data-id='"
                            +row.id+"' data-toggle='modal' data-target='#exampleModalCenter' class='deleteUserBtn'><img src='" + img_url2 + "' alt=''></a>";
                    }
                }
            ]
        });
    })

    $('body').on('click', '.deleteUserBtn', function (e) {
        var delete_user_id = $(this).attr('data-id');
        $("#exampleModalCenter").find('#RemoveUserSubmit').attr('data-id',delete_user_id);
    });

    $('body').on('click', '#RemoveUserSubmit', function (e) {
        $('#RemoveUserSubmit').prop('disabled',true);
        console.log($(this).attr('data-id'))
        var remove_user_id = $(this).attr('data-id');

        $.ajax({
            type: 'GET',
            url: "{{ url('/application') }}" +'/' + remove_user_id +'/delete',
            success: function (res) {
                if(res == 200){
                    $("#exampleModalCenter").modal('hide');
                    $('#RemoveUserSubmit').prop('disabled',false);
                }else{
                    $("#exampleModalCenter").modal('hide');
                    $('#RemoveUserSubmit').prop('disabled',false);
                }
            },
            error: function (data) {
                console.log("error")
                console.log(data)
            }
        });
    });
</script>
@endpush('scripts')