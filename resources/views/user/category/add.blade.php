@extends('user.layouts.layout')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/dropzone.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet" />
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
                                <form class="form-valide" action="" mathod="POST" id="category_add" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="app_id" value="{{$id}}" />
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label class="col-form-label" for="name">Title: <span class="text-danger">*</span>
                                            </label>
                                            <div class="row pl-3">
                                                <div class="col-lg-8 p-0 mr-2">
                                                    <input type="text" class="form-control" id="name" name="name" placeholder="Application Name..">
                                                </div>
                                                <!-- <div class="col-lg-3 p-0">
                                                    <div class="custome_fields"><button type="button" data-id="{{$id}}" class="btn mb-1 btn-info field_btn">Add Fields</button></div>
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
                                            <div class="custome_fields"><button type="button" data-id="{{$id}}" class="plus_btn btn mb-1 btn-info field_btn">Add</button></div>
                                        </div>
                                    </div>
                                    <div id="category_form" class="form-group col-12"></div>
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
                                <table id="category_list" class="table zero-configuration customNewtable application_table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>No</th>
                                            <th>Title</th>
                                            <!-- <th>status</th> -->
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <!-- <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Title</th>
                                            <th>status</th>
                                            <th>Date</th>
                                            <th>Action</th>
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary delete" id="RemoveUserSubmit">Delete</button>
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
    var app_id = "{{$id}}";
    var urll = "{{asset('/category_image/')}}";
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
    //     // console.log(field_name)
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
    //                 // '<div class="col-md-2">'+
    //                 //     '<button type="button" class="plus_btn btn mb-1 btn-primary">+</button>'+
    //                 // '</div>'+
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
    $('body').on('click', '.minus_btn', function(){
        var tthis = $(this).parent().parent();
        var ddd = tthis.remove()
    })

    $('body').on('click', '#submit_category', function () {
        var formData = new FormData($("#category_add")[0]);
        $.ajax({
                type: 'POST',
                url: "{{ route('category.store') }}",
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    if(data.status == 200){
                        toastr.success("success")
                        $("#category_add")[0].reset()
                    }else{
                        toastr.error("error")
                    }
                }
        });
    })
    function format(d) {
        var list;
        $.each(d.category, function(i, item) {
            var ddd = '';
            if (/(jpg|gif|png)$/.test(item.value)){ 
                var imgg = urll+"/"+item.value
                ddd += '<img class="img_side" src="'+imgg+'">';
            }else{
                ddd += '<spa>'+item.value+'</span>';
            }
            list += '<tr><td>'+item.key+'</td><td>'+ddd+'</td></tr>';
        });
        return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;" id="child_row">' +
                '<ul class="d-none">'+list+'</ul></table>';
    }

    var my_date_format = function (input) {
        console.log("----->",input)
        var d = new Date(Date.parse(input.replace(/-/g, "/")));
        var month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 
        'Nov', 'Dec'];
        var date = d.getDay().toString() + " " + month[d.getMonth().toString()] + ", " + 
        d.getFullYear().toString();
        return (date);
    }; 

    $(document).ready(function() {
        var table = $('#category_list').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "ajax":{
                "url": "{{ url('/category-list') }}",
                "dataType": "json",
                "type": "POST",
                "data":{ _token: '{{ csrf_token() }}', app_id: app_id},
            },
            "columnDefs": [
                { "width": "", "targets": 0 },
                { "width": "", "targets": 1 },
                { "width": "", "targets": 2 },
                { "width": "", "targets": 3 },
                // { "width": "", "targets": 4 },
            ],
            "columns": [
                {
                    className: 'dt-control',
                    orderable: false,
                    data: null,
                    defaultContent: '',
                },
                {data: 'id', name: 'id', class: "text-center", orderable: false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {data: 'title', name: 'title', class: "text-center", orderable: false,
                    render: function (data, type, row) {
                        return row.title;
                    }
                },
                // {data: 'status', name: 'status', orderable: false, searchable: false, class: "text-center"},
                // {data: 'created_at', name: 'created_at', orderable: false, searchable: false, class: "text-center"},
                {data: 'created_at', name: 'created_at', class: "text-center", orderable: false,
                    render: function (data, type, row) {
                        // var date = my_date_format(row.start_date);
                        // console.log(date)
                        return row.start_date;
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
        $('#category_list tbody').on('click', 'td.dt-control', function () {
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
            url: "{{ url('/category') }}" +'/' + remove_user_id +'/delete',
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