@extends('user.layouts.layout')

@section('content')
<link href="{{ url('public/plugins/tables/css/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<div class="container-fluid mt-3">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="text-left mb-4">
                        <a href="{{url('add-application')}}" class="btn gradient-4 btn-lg border-0 btn-rounded px-5">Add Application</a>
                    </div>
                    <h4 class="card-title">Application List</h4>
                    <!-- <div class="table-responsive">
                        <table class="table table-striped table-bordered zero-configuration">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>App Id</th>
                                    <th>Package Name</th>
                                    <th width="100px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>1</td>
                                <td>application 1</td>
                                <td>gfffd66665675f6g5543</td>
                                <td>first package</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>application 2</td>
                                <td>gfffd6666567DGDsGDD</td>
                                <td>second package</td>
                                <td>-</td>
                            </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                <th>No</th>
                                    <th>Name</th>
                                    <th>App Id</th>
                                    <th>Package Name</th>
                                    <th width="100px">Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div> -->

                    <div class="tab-pane fade show active table-responsive">
                        <table id="application_list" class="table zero-configuration customNewtable" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Icon</th>
                                    <th>App Id</th>
                                    <th>Package Name</th>
                                    <th width="100px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Icon</th>
                                    <th>App Id</th>
                                    <th>Package Name</th>
                                    <th width="100px">Action</th>
                                </tr>
                            </tfoot>
                        </table>
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
                { "width": "50px", "targets": 0 },
                { "width": "145px", "targets": 1 },
                { "width": "165px", "targets": 2 },
                { "width": "230px", "targets": 3 },
                { "width": "75px", "targets": 4 },
                { "width": "120px", "targets": 5 },
            ],
            "columns": [
                {data: 'id', name: 'id', class: "text-center", orderable: false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {data: 'name', name: 'name', class: "text-center multirow"},
                // {data: 'icon', name: 'icon', class: "text-left multirow", orderable: false},
                {
                    "mData": "icon",
                    "mRender": function (data, type, row) {
                        // console.log(row.icon)
                        var img_url = "{{asset('/app_icons/')}}/"+row.icon;
                        // console.log(img_url)
                        return "<img class='set_img' src="+img_url+" >";
                    }
                },
                {data: 'app_id', name: 'app_id', class: "text-left multirow", orderable: false},
                {data: 'package_name', name: 'package_name', orderable: false, searchable: false, class: "text-center"},
                // {data: 'action', name: 'action', orderable: false, searchable: false, class: "text-center"},
                {
                    "mData": "action",
                    "mRender": function (data, type, row) {

                        var url1 = '{{ Route("application.edit", "id") }}';
                        url1 = url1.replace('id', row.id);

                        var url2 = '{{ url("category") }}';

                        return "<a href='" + url1 + "' title=\"Edit\" class='btn mb-1 btn-primary mr-2'>Edit</a>" +
                            "<a rel='" + row.id + "' title=\"Delete\" href='javascript:void(0)' data-id='"+row.id+"' data-toggle='modal' data-target='#exampleModalCenter' class='deleteUserBtn btn mb-1 btn-warning'>" +
                            "Delete</a>"+
                            "<a href='"+url2+"' title=\"Edit\" class='btn mb-1 btn-success text-white mr-2'>Add Category</a>" +
                            "<a href='#' title=\"Edit\" class='btn mb-1 btn-primary mr-2'>Add Content</a>";
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
        // e.preventDefault();
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