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
                        <h2 class="text-white">{{ (isset($ApplicationData) && $ApplicationData->total_applications != null) ? $ApplicationData->total_applications : '' }}</h2>
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
                        <h2 class="text-white">{{ (isset($ApplicationData) && $ApplicationData->total_active_applications != null )  ? $ApplicationData->total_active_applications : '' }}</h2>
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
                        <h2 class="text-white">{{ (isset($ApplicationData) && $ApplicationData->total_deactive_applications != null) ? $ApplicationData->total_deactive_applications : '' }}</h2>
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
                // {
                //     "mData": "icon",
                //     className: 'text-left',
                //     "mRender": function (data, type, row) {
                //         if(row.is_url == 1){
                //             return "<div class='application_img_text'><img class='set_img' src="+row.icon_url+" ><span class='application_text ml-2'>"+row.name+"</span></div>";
                //         }else{
                //             var img_url = "{{asset('/app_icons/')}}/"+row.icon;
                //             return "<div class='application_img_text'><img class='set_img' src="+img_url+" ><span class='application_text ml-2'>"+row.name+"</span></div>";
                //         }
                //     }
                // },
                {
                    "mData": "icon",
                    className: 'text-left',
                    "mRender": function (data, type, row) {
                        var html = '';
                        var id = "myModal"+row.id;
                        var ids = "#myModal"+row.id;
                        var image_video1 = '';
                        var img_url = row.icon_url;
                        var filename1 = row.icon_url;

                        if(row.is_url == 1){
                            if(row.icon_url.match("jpg") || row.icon_url.match("png") || row.icon_url.match("jpeg")){
                                image_video1 += "<img class='set_img' class='set_img' data-toggle='modal' data-target='"+ids+"' src='"+filename1+"' />";
                            }else{
                                if(row.icon_url.match("mp4")){
                                    image_video1 += "<iframe src='"+filename1+"' title='video'></iframe>";
                                }else if(row.icon_url.match("youtube")){
                                    const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/;
                                    const match = row.icon_url.match(regExp);
                                    image_video1 += '<iframe src="https://www.youtube.com/embed/' 
                                                        + match[2] + '" frameborder="0" allowfullscreen></iframe>';

                                }
                            }
                        html = '<div id="'+id+'" class="modal fade" role="dialog">'+
                                        '<div class="modal-dialog">'+
                                            '<div class="modal-content">'+
                                                '<div class="modal-body">'+image_video1+'</div>'+
                                                '<div class="modal-footer">'+
                                                    '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'+
                                                '</div>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>';
                        }else{
                        var filename = row.icon;
                        var valid_extensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;  
                        var valid_video_extensions = /(\.mp4|\.webm|\.m4v)$/i;  
                        var image_video = ''; 
                        var img_url = "{{asset('/app_icons/')}}/"+row.icon;
                        var video_url = "{{asset('/app_icons/')}}/"+row.icon;
                        if(valid_extensions.test(filename)){ 
                            image_video += '<img class="img-responsive" src="'+img_url+'" />';
                        }else{
                            if(valid_video_extensions.test(filename)){
                                image_video += '<iframe src="'+video_url+'" title="video"></iframe>';
                            }
                        }
                        var img_url = "{{asset('/app_icons/')}}/"+row.icon;
                        html = '<div id="'+id+'" class="modal fade" role="dialog">'+
                                    '<div class="modal-dialog">'+
                                        '<div class="modal-content">'+
                                            '<div class="modal-body">'+image_video+'</div>'+
                                            '<div class="modal-footer">'+
                                                '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'; 
                        }
                        if(row.is_url == 1){
                            var image_video1 = '';
                            var img_url = row.icon_url;
                            var filename1 = row.icon_url;
                            if(row.icon_url != null){
                                if(row.icon_url.match("jpg") || row.icon_url.match("png") || row.icon_url.match("jpeg")){
                                    image_video1 += "<img class='set_img' class='set_img' data-toggle='modal' data-target='"+ids+"' src='"+filename1+"' />";
                                }else{
                                    if(row.icon_url.match("mp4") || row.icon_url.match("youtube")){
                                        image_video1 += "<img class='set_img' class='set_img' data-toggle='modal' data-target='"+ids+"' src='{{asset('user/assets/icons/video_icon.jpg')}}' />";
                                    }
                                }
                            }else{
                                image_video1 += "<img class='set_img' src='{{asset('user/assets/icons/dummy_img.jpg')}}' />";
                            }
                            return "<div class='application_img_text'>"+html+"<div class='images'>"+image_video1+"</div><span class='application_text ml-2'>"+row.name+"</span></div>";
                        }else{
                            var image_video1 = '';
                            var img_url = "{{asset('/app_icons/')}}/"+row.icon;
                            if(row.icon != null){
                                if(valid_extensions.test(filename)){
                                    var img_url = "{{asset('/app_icons/')}}/"+row.icon; 
                                    image_video1 += "<img class='set_img' class='set_img' data-toggle='modal' data-target='"+ids+"' src='"+img_url+"' />";
                                }else{
                                    var video_url = "{{asset('/app_icons/')}}/"+row.icon;
                                    if(valid_video_extensions.test(filename)){
                                        image_video1 += "<img class='set_img' class='set_img' data-toggle='modal' data-target='"+ids+"' src='{{asset('user/assets/icons/video_icon.jpg')}}' />";
                                    }
                                }
                            }else{
                                image_video1 += "<img class='set_img' src='{{asset('user/assets/icons/dummy_img.jpg')}}' />";
                            }
                            return "<div class='application_img_text'>"+html+"<div class='images'>"+image_video1+"</div><span class='application_text ml-2'>"+row.name+"</span></div>";
                        }
                    }
                },
                {
                    "mData": "app_id",
                    "mRender": function (data, type, row) {
                        if(row.app_id != null){
                            return "<div><span class='application_text app_id_part'>"+row.app_id+"</span></div>";
                        }else{
                            return "<div><span class='application_text app_id_part'>-</span></div>";
                        }
                    }
                },
                // {data: 'package_name', name: 'package_name', orderable: false, searchable: false, class: "text-center"},
                {
                    "mData": "package_name",
                    "mRender": function (data, type, row) {
                        var multi_link = [];
                        if(row.package_name != null){
                            var hasApple = row.package_name.indexOf(',') != -1;
                            if(hasApple === true){
                                var strarray = row.package_name.split(',');
                                $(strarray).each(function( index, value ) {
                                    var concat_string = "https://play.google.com/store/apps/details?id="+value;
                                    var concat_string1 = "<a class='link_playstore' href='"+concat_string+"' target='_blank'>"+value+"</a>";
                                    multi_link.push(concat_string1);
                                });
                                multi_link = multi_link.join(", ");
                            }else{
                                var concat_string = "https://play.google.com/store/apps/details?id="+row.package_name;
                                multi_link = "<a class='link_playstore' href='"+concat_string+"' target='_blank'>"+row.package_name+"</a>"; 
                            }
                            return "<div><span class='application_text app_id_part'>"+multi_link+"</span></div>";
                        }else{
                            return "<div><span class='application_text app_id_part'>-</span></div>";
                        }
                    }
                },
                // {
                //     "mData": "field",
                //     "mRender": function (data, type, row) {
                //         return "<div><span class='application_text app_id_part total_request_text application_text'>"+row.total_request+"</span></div>";
                //     }
                // },
                {
                    "mData": "field",
                    "mRender": function (data, type, row) {
                        var cat_request = "0";
                        if(row.cat_total_request != null){
                            cat_request = row.cat_total_request
                        }
                        var total_request = "0";
                        if(row.total_request != null){
                            total_request = row.total_request
                        }
                        // return "<tr><td>"+cat_request+"</td><td>"+total_request+"</td></tr>";
                        return "<div><span class='application_text app_id_part total_request_text application_text'>"+cat_request+" | "+total_request+"</span></div>";
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