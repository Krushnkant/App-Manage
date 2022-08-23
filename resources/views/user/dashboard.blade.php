@extends('user.layouts.layout')

@section('content')
<style>
    .application_img_text {
        display: flex;
    }
</style>
<div class="container-fluid mt-3">
    <div class="row">
        <div class="col-lg-4 col-sm-6">
            <div class="card gradient-1">
                <div class="card-body">
                    <h3 class="card-title text-white">Total Application</h3>
                    <div class="d-inline-block">
                        <h2 class="text-white">{{ $ApplicationData->total_applications }}</h2>
                        <!-- <p class="text-white mb-0">Jan - March 2019</p> -->
                    </div>
                    <span class="float-right display-5 opacity-5"><i class="fa fa-mobile" aria-hidden="true"></i></span>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6">
            <div class="card gradient-2">
                <div class="card-body">
                    <h3 class="card-title text-white">Publish Application</h3>
                    <div class="d-inline-block">
                        <h2 class="text-white">{{ $ApplicationData->total_active_applications }}</h2>
                        <!-- <p class="text-white mb-0">Jan - March 2019</p> -->
                    </div>
                    <span class="float-right display-5 opacity-5"><i class="fa fa-mobile" aria-hidden="true"></i></span>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6">
            <div class="card gradient-3">
                <div class="card-body">
                    <h3 class="card-title text-white">Unpublish Application</h3>
                    <div class="d-inline-block">
                        <h2 class="text-white">{{ $ApplicationData->total_deactive_applications }}</h2>
                        <!-- <p class="text-white mb-0">Jan - March 2019</p> -->
                    </div>
                    <span class="float-right display-5 opacity-5"><i class="fa fa-mobile" aria-hidden="true"></i></span>
                </div>
            </div>
        </div>
        
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="active-member">
                        <div class="table-responsive">
                        <div class="tab-pane fade show active" id="active" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="tab-pane fade show active table-responsive table_detail_part">
                                    <h4 class="mb-1">Request Application</h4>
                                    <div class="table-responsive">
                                        <table id="application_list" class="table zero-configuration customNewtable shadow-none application_table" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Application</th>
                                                    <th>App Id</th>
                                                    <th>Package Name</th>
                                                    <th>Total Request</th>
                                                    <th>Status</th>
                                                    <!-- <th>Date</th> -->
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
    
    $(document).ready(function() {
        $('#application_list').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "ajax":{
                "url": "{{ url('/application-list-dashboard') }}",
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
                // { "width": "", "targets": 5 },
            ],
            "columns": [
                {data: 'id', name: 'id', class: "text-center", orderable: false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    "mData": "icon",
                    className: 'text-left',
                    "mRender": function (data, type, row) {
                        if(row.is_url == 1){
                            return "<div class='application_img_text'><img class='set_img' src="+row.icon_url+" ><span class='application_text ml-2'>"+row.name+"</span></div>";
                        }else{
                            var img_url = "{{asset('/app_icons/')}}/"+row.icon;
                            return "<div class='application_img_text'><img class='set_img' src="+img_url+" ><span class='application_text ml-2'>"+row.name+"</span></div>";
                        }
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
                            return "<div><span class='application_text app_id_part active_status'>Active</span></div>";
                        }else{
                            return "<div><span class='application_text app_id_part deactive_status active_status'>Deactive</span></div>";
                        }
                    }
                },
                // {
                //     "mData": "status",
                //     "mRender": function (data, type, row) {
                //         return "<div><span class='application_text app_id_part date_part'>"+row.start_date+"</span></div>";
                //     }
                // }
            ]
        });
    })

  
</script>
@endpush('scripts')