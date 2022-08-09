@extends('user.layouts.layout')

@section('content')
<div>
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item "><a href="{{url('application')}}">Application List</a></li>
                <li class="breadcrumb-item active">Content List</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid pt-0 add-form-part">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body pb-0">
                        <h4 class="card-title mb-3">Content List - Application Management</h4>
                        <button class="btn mb-1 btn-primary"><a href="{{url('content-form/'.$id)}}" class="text-white">Add Content</a></button>
                        <button class="btn mb-1 btn-primary"><a href="{{url('add-structure/'.$id)}}" class="text-white">Form Structure</a></button>
                        <div class="tab-pane fade show active table-responsive table_detail_part" id="all_application_tab">
                        <div class="table-responsive content_list_table">
                                <table id="content_list" class="table zero-configuration customNewtable application_table  shadow-none px-0" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>No</th>
                                            <th>Application Id</th>
                                            <th>Category</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot></tfoot>
                                </table>
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
@endsection
@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script type="text/javascript">
    var app_id = "{{$id}}";
    // console.log(app_id)
    $(document).ready(function() {
        var table = $('#content_list').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "ajax":{
                "url": "{{ url('/content-get-list') }}/"+app_id,
                "dataType": "json",
                "type": "POST",
                "data":{ _token: '{{ csrf_token() }}', app_id: app_id},
            },
            "columnDefs": [
                { "width": "10%", "targets": 0 },
                { "width": "10%", "targets": 1 },
                { "width": "20%", "targets": 2 },
                { "width": "20%", "targets": 3 },
                { "width": "20%", "targets": 4 },
                { "width": "20%", "targets": 5 },
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
                {data: 'app_id', name: 'app_id', class: "text-center", orderable: false,
                    render: function (data, type, row) {
                        // console.log(row.application.name)
                        return "<div><span class='application_text app_id_part total_request_text'>"+row.application.name+"</span></div>";
                    }
                },
                {data: 'category_id', name: 'category_id', class: "text-center", orderable: false,
                    render: function (data, type, row) {
                        // console.log(row.category?.title)
                        var cat = (row.category?.title != undefined) ? row.category?.title : "-";
                        return "<span class='application_text app_id_part total_request_text'>"+cat+"</span>";
                    }
                },
                {data: 'created_at', name: 'created_at', class: "text-center", orderable: false,
                    render: function (data, type, row) {
                        // console.log(row)
                        // var date = my_date_format(row.start_date);
                        // console.log(date)
                        return "<div><span class='application_text app_id_part date_part'>"+row.start_date+"</span></div>";
                    }
                },
                {
                    "mData": "action",
                    "mRender": function (data, type, row) {

                        // console.log(row)
                        // console.log('{{ url("content-edit") }}/'+row.app_id+"/"+row.UUID)
                        var url1 = '{{ url("content-edit") }}/'+row.app_id+"/"+row.UUID;
                        url1 = url1.replace('id', row.id);
                        var img_url1 = "{{asset('user/assets/icons/edit.png')}}";
                        var img_url2 = "{{asset('user/assets/icons/delete.png')}}";

                        return "<a href='" + url1 + "' title=\"Edit\" class='application_text mr-4'><img src='" + img_url1 + "' alt=''></a>" +
                            "<a rel='" + row.id + "' title=\"Delete\" href='javascript:void(0)' data-id='"
                            +row.id+"' data-toggle='modal' data-target='#exampleModalCenter' class='deleteUserBtn'><img src='" + img_url2 + "' alt=''></a>";
                    }
                }
                
            ],
            "order": [[1, 'asc']],
        });
        $('#content_list tbody').on('click', 'td.dt-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);
    
            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row
                row.child(format(row.data())).show();
                tr.addClass('shown');
            }
        });
    })

    var urll = "{{asset('/app_data_images/')}}";
    function format(d) {
        var list;
        var bunch = [];
        var uniqueArray = [];
        var newArray = [];
        $.each(d.app_data, function(i, item) {
            var ddd = '';
            if (/(jpg|gif|png)$/.test(item.value)){ 
                var imgg = urll+"/"+item.value
                ddd += '<img class="img_side" src="'+imgg+'">';
            }else{
                ddd += '<spa>'+item.value+'</span>';
            }
            list += '<tr><td class="text-left">'+item.field_name+'</td><td class="text-left">'+ddd+'</td></tr>';
        });
        $.each(d.sub_app_data, function(i, item) {
            // var ddd = '';
            // console.log(item.UUID)
            bunch.push(item.UUID)
            // if (/(jpg|gif|png)$/.test(item.value)){ 
            //     var imgg = urll+"/"+item.value
            //     ddd += '<img class="img_side" src="'+imgg+'">';
            // }else{
            //     ddd += '<span>'+item.value+'</span>';
            // }
            // list += '<tr><td>'+item.field_name+'</td><td>'+ddd+'</td></tr>';
        });
        for(i=0; i < bunch.length; i++){
            if(uniqueArray.indexOf(bunch[i]) === -1) {
                uniqueArray.push(bunch[i]);
            }
        }
        var html = "<table class='w-100 child-inner-table mb-4 mx-3'><thead><tr>";
                $.each(d.sub_app_data, function(i, item) {
                        if(item.UUID == uniqueArray[0]){
                            html += '<th><strong>'+item.field_name+'</strong></th>';
                        }
                })
            html +="</tr></thead>";
            for(i=0; i < uniqueArray.length; i++){
                var sss = uniqueArray[i];
                html += "<tbody><tr>";
                    $.each(d.sub_app_data, function(i, item) {
                        if(item.UUID == sss){
                            var ddd = '';
                            if (/(jpg|gif|png)$/.test(item.value)){ 
                                var imgg = urll+"/"+item.value
                                ddd += '<img class="img_side" src="'+imgg+'">';
                            }else{
                                ddd += '<span>'+item.value+'</span>';
                            }
                            html += "<td>"+ddd+"</td>";
                        }
                    })
                }
                html += "</tr></tbody>";
        html += "</table>";
        return '<table cellpadding="5" class="mx-0 child_row_table" cellspacing="0" border="0" style="padding-left:50px;" id="child_row">'+
        '<ul class="d-none">'+list+''+html+'</ul></table>';
    }

    $('body').on('click', '.deleteUserBtn', function (e) {
        var delete_user_id = $(this).attr('data-id');
        $("#exampleModalCenter").find('#RemoveUserSubmit').attr('data-id',delete_user_id);
    });

    $('body').on('click', '#RemoveUserSubmit', function (e) {
        $('#RemoveUserSubmit').prop('disabled',true);
        var remove_user_id = $(this).attr('data-id');

        $.ajax({
            type: 'GET',
            url: "{{ url('/content') }}" +'/' + remove_user_id +'/delete',
            success: function (res) {
                if(res.status == 200){
                    $("#exampleModalCenter").modal('hide');
                    $('#RemoveUserSubmit').prop('disabled',false);
                    $('#application_list').DataTable().draw();
                    toastr.success(res.action,'Success',{timeOut: 5000});
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
</script>
@endpush('scripts')