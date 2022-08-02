@extends('user.layouts.layout')

@section('content')
<div class="container-fluid mt-3 add-form-part">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Content List</h4>
                </div>
                <div class="table-responsive">
                    <table id="content_list" class="table zero-configuration customNewtable application_table table-child-part" style="width:100%">
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
                    </table>
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
                { "width": "", "targets": 0 },
                { "width": "", "targets": 1 },
                { "width": "", "targets": 2 },
                { "width": "", "targets": 3 },
                { "width": "", "targets": 4 },
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
                        return "<div><span class='application_text app_id_part total_request_text'>"+row.application.name+"</span></div>";
                    }
                },
                {data: 'category_id', name: 'category_id', class: "text-center", orderable: false,
                    render: function (data, type, row) {
                        console.log(row.category?.title)
                        // return "<div><span class='application_text app_id_part total_request_text'>"+row.category?.title+"</span></div>";
                    }
                },
                {data: 'created_at', name: 'created_at', class: "text-center", orderable: false,
                    render: function (data, type, row) {
                        // var date = my_date_format(row.start_date);
                        // console.log(date)
                        return "<div><span class='application_text app_id_part date_part'>"+row.start_date+"</span></div>";
                    }
                },
                {
                    "mData": "action",
                    "mRender": function (data, type, row) {

                        var url1 = '{{ Route("category.edit", "id") }}';
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
        // $('#content_list tbody').on('click', 'td.dt-control', function () {
        //     var tr = $(this).closest('tr');
        //     var row = table.row(tr);
    
        //     if (row.child.isShown()) {
        //         // This row is already open - close it
        //         row.child.hide();
        //         tr.removeClass('shown');
        //     } else {
        //         // Open this row
        //         row.child(format(row.data())).show();
        //         tr.addClass('shown');
        //     }
        // });
    })
</script>
@endpush('scripts')