@extends('user.layouts.layout')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/dropzone.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
<style>
        .dropzone {
            background: #e3e6ff;
            border-radius: 13px;
            max-width: 550px;
            margin-left: auto;
            margin-right: auto;
            border: 2px dotted #1833FF;
            margin-top: 50px;
        }
    </style>
<div class="container-fluid mt-3">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-validation">
                                <!-- {{ Form::open(array('url' => 'category', 'method' => 'post', 'enctype' => 'multipart/form-data')) }} -->
                                <form class="form-valide" action="" mathod="PUT" id="category_add" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="category_id" value="{{$data->id}}" />
                                    <input type="hidden" name="app_id" value="{{$data->app_id}}" />
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label class="col-form-label" for="name">Title: <span class="text-danger">*</span>
                                            </label>
                                            <div class="row pl-3">
                                                <div class="col-lg-8 p-0 mr-2">
                                                    <input type="text" class="form-control" id="name" value="{{$data->title}}" name="name" placeholder="Application Name..">
                                                </div>
                                                <!-- <div class="col-lg-3 p-0">
                                                    <div class="custome_fields"><button type="button" data-id="" class="btn mb-1 btn-info field_btn">Add Fields</button></div>
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-8">
                                            <select class="form-control" id="val-skill" name="val-skill">
                                                <option value="">Please select</option>
                                                @foreach($fields as $field)
                                                    <option data-id="{{$field->id}}" value="{{$field->type}}">{{$field->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-3 p-0">
                                            <div class="custome_fields"><button type="button" data-id="" class="plus_btn btn mb-1 btn-info field_btn">Add</button></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div id="category_form" class="form-group col-12">
                                            @foreach($data->category as $d)
                                                <?php 
                                                $field_key = $d->id."_".$d->fields->id."_key[]"; 
                                                // $field_name = $d->id."_".$d->fields->id."_value[]"; 
                                                $field_name = ""; 
                                                ?>
                                                <div class="row mb-2 position-relative">
                                                    <div class="col-md-4">
                                                        <input type="text" placeholder="" value="{{$d->key}}" class="form-control input-flat" name="{{$field_key}}" />
                                                    </div>
                                                    @if($d->fields->type == "textbox")
                                                    <?php $field_name = $d->id."_".$d->fields->id."_value[]"; ?>
                                                    <div class="col-md-4">
                                                        <input type="text" value="{{$d->value}}" class="form-control input-flat" name="{{$field_name}}" />
                                                    </div>
                                                    @elseif($d->fields->type == "file")
                                                    <?php $field_name = $d->id."_".$d->fields->id."_file[]"; ?>
                                                    <div class="col-md-4">
                                                        <input type="file" value="{{$d->value}}" class="form-control input-flat" name="{{$field_name}}" />
                                                    </div>
                                                    @elseif($d->fields->type == "multi-file")
                                                    <?php $field_name = $d->id."_".$d->fields->id."_file[]"; ?>
                                                    <div class="col-md-4">
                                                        <input type="file" value="{{$d->value}}" class="form-control input-flat" name="{{$field_name}}" />
                                                    </div>
                                                    @endif
                                                    <!-- <div class="col-md-2">
                                                        <button type="button" class="plus_btn btn mb-1 btn-primary">+</button>
                                                    </div> -->
                                                    <div class="col-md-2">
                                                        <button type="button" class="minus_btn btn mb-1 btn-dark">-</button>
                                                    </div>

                                                    @if($d->fields->type == "file")
                                                    <div class="img_class">
                                                        <img class="img_side" src="{{asset('category_image/'.$d->value)}}" >
                                                    </div>
                                                    @elseif($d->fields->type == "multi-file")
                                                    <div class="img_class">
                                                        <img class="img_side" src="{{asset('category_image/'.$d->value)}}" >
                                                    </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <div class="col-lg-8 ml-auto">
                                                <button type="button" id="submit_category" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!-- {{ Form::close() }} -->
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="table-responsive">
                                <!-- <table id="category_list" class="table zero-configuration customNewtable application_table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>App Id</th>
                                            <th>Title</th>
                                            <th>Key</th>
                                            <th>Value</th>
                                            <th>status</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table> -->
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/min/dropzone.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
<script type="text/javascript">
    $("#cat_form").hide();
    var app_id = 0;
    const cat_id = "{{$data->id}}";
    $(".field_btn").click(function(){
        var app_id = $(this).attr('data-id');
        $("#cat_form").show();
    });
    // $('#val-skill').change(function(){
    //     var html = "";
    //     var valuee = $(this).val()
    //     var option = $('option:selected', this).attr('data-id');
    //     var field_name = option+"field_value[]";
    //     var field_key = option+"field_key[]";
    //     var type = "text";
    //     if(valuee == "textbox"){
    //         type = "text";
    //     }
    //     if(valuee == "file"){
    //         type = "file";
    //     }
    //     if(valuee == "multi-file"){
    //         type = "file";
    //     }

    //     html += '<div class="row mb-2">'+
    //                 '<div class="col-md-4">'+
    //                     '<input type="text" placeholder="" class="form-control input-flat" name="'+field_key+'" />'+
    //                 '</div>'+
    //                 '<div class="col-md-4">'+
    //                     '<input type="'+type+'" class="form-control input-flat" name="'+field_name+'" />'+
    //                 '</div>'+
    //                 '<div class="col-md-2">'+
    //                     '<button type="button" class="plus_btn btn mb-1 btn-primary">+</button>'+
    //                 '</div>'+
    //                 '<div class="col-md-2">'+
    //                     '<button type="button" class="minus_btn btn mb-1 btn-dark">-</button>'+
    //                 '</div>'+
    //             '</div>';
    //     $("#category_form").append(html);
    // })
    $('body').on('click', '.plus_btn', function(){
        // var tthis = $(this).parent().parent();
        // var ddd = tthis.clone()
        // $("#category_form").append(ddd);
        var html = "";
        var selected = $('#val-skill option:selected');
        var option = selected.attr('data-id')
        var valuee = selected.attr('value')
        // console.log(selected.text())
        var field_name = option+"field_value[]";
        var field_key = option+"field_key[]";

        var type = "text";
        if(valuee == "textbox"){
            type = "text";
        }
        if(valuee == "file"){
            type = "file";
        }
        if(valuee == "multi-file"){
            type = "file";
        }

        html += '<div class="row mb-2">'+
                    '<div class="col-md-4">'+
                        '<input type="text" placeholder="" class="form-control input-flat" name="'+field_key+'" />'+
                    '</div>'+
                    '<div class="col-md-4">'+
                        '<input type="'+type+'" class="form-control input-flat" name="'+field_name+'" />'+
                    '</div>'+
                    // '<div class="col-md-2">'+
                    //     '<button type="button" class="plus_btn btn mb-1 btn-primary">+</button>'+
                    // '</div>'+
                    '<div class="col-md-2">'+
                        '<button type="button" class="minus_btn btn mb-1 btn-dark">-</button>'+
                    '</div>'+
                '</div>';
        $("#category_form").append(html);
    })

    $('body').on('click', '.plus_btn', function(){
        var tthis = $(this).parent().parent();
        var ddd = tthis.clone()
        $("#category_form").append(ddd);
    })
    $('body').on('click', '.minus_btn', function(){
        var tthis = $(this).parent().parent();
        var ddd = tthis.remove()
    })

    $('body').on('click', '#submit_category', function () {
        var formData = new FormData($("#category_add")[0]);
        // var url1 = '{{ Route("category.update", "id") }}';
        
        $.ajax({
                type: 'POST',
                url: "{{ url('/category-update')}}/"+cat_id,
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    if(data.status == 200){
                        toastr.success("success")
                        // $("#category_add")[0].reset()
                    }else{
                        toastr.error("error")
                    }
                }
        });
    })

    $(document).ready(function() {
        // $('#category_list').DataTable({
        //     "destroy": true,
        //     "processing": true,
        //     "serverSide": true,
        //     "ajax":{
        //         "url": "{{ url('/category-list') }}",
        //         "dataType": "json",
        //         "type": "POST",
        //         "data":{ _token: '{{ csrf_token() }}'},
        //     },
        //     'columnDefs': [
        //         { "width": "", "targets": 0 },
        //         { "width": "", "targets": 1 },
        //         { "width": "", "targets": 2 },
        //         { "width": "", "targets": 3 },
        //         { "width": "", "targets": 4 },
        //         { "width": "", "targets": 5 },
        //         { "width": "", "targets": 6 },
        //         { "width": "", "targets": 7 },
        //     ],
        //     "columns": [
        //         {data: 'id', name: 'id', class: "text-center", orderable: false,
        //             render: function (data, type, row, meta) {
        //                 return meta.row + meta.settings._iDisplayStart + 1;
        //             }
        //         },
        //         {data: 'app_id', name: 'app_id', class: "text-center", orderable: false,
        //             render: function (data, type, row) {
        //                 // console.log(row.application.name)
        //                 return row.application.name;
        //             }
        //         },
        //         // {data: 'app_id', name: 'app_id', orderable: false, searchable: false, class: "text-center"},
        //         // {data: 'title', name: 'title', orderable: false, searchable: false, class: "text-center"},
        //         {data: 'title', name: 'title', class: "text-center", orderable: false,
        //             render: function (data, type, row) {
        //                 // console.log(row.application.name)
        //                 return row.category.title;
        //             }
        //         },
        //         {data: 'key', name: 'key', orderable: false, searchable: false, class: "text-center"},
        //         {data: 'value', name: 'value', orderable: false, searchable: false, class: "text-center"},
        //         {data: 'status', name: 'status', orderable: false, searchable: false, class: "text-center"},
        //         {data: 'created_at', name: 'created_at', orderable: false, searchable: false, class: "text-center"},
        //         // {data: 'action', name: 'action', orderable: false, searchable: false, class: "text-center"},
        //         {
        //             "mData": "action",
        //             "mRender": function (data, type, row) {

        //                 var url1 = '{{ Route("category.edit", "id") }}';
        //                 url1 = url1.replace('id', row.id);
        //                 var img_url1 = "{{asset('user/assets/icons/edit.png')}}";
        //                 var img_url2 = "{{asset('user/assets/icons/delete.png')}}";

        //                 return "<a href='" + url1 + "' title=\"Edit\" class='application_text mr-4'><img src='" + img_url1 + "' alt=''></a>" +
        //                     "<a rel='" + row.id + "' title=\"Delete\" href='javascript:void(0)' data-id='"
        //                     +row.id+"' data-toggle='modal' data-target='#exampleModalCenter' class='deleteUserBtn'><img src='" + img_url2 + "' alt=''></a>";
        //             }
        //         }
                
        //     ]
        // });
    })
</script>
@endpush('scripts')