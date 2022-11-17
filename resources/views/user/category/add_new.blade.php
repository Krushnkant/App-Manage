@extends('user.layouts.layout')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/dropzone.min.css" rel="stylesheet">
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

    span.error-display {
        color: #f00;
        display: block;
    }
    .spinner-border {
        display: none;
    }

</style>
<div>
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{url('application-new')}}">Application List</a></li>
                <li class="breadcrumb-item active">Add Category</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid pt-0 add-form-part">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-xl-4">
                        <div class="card shadow-none">
                            <div class="card-body">
                                <h4 class="card-title">Add Category Form - {{$app_data->name}}</h4>
                                <div class="form-validation">
                                    <!-- {{ Form::open(array('url' => 'category', 'method' => 'post', 'enctype' => 'multipart/form-data')) }} -->
                                    <form class="form-valide custom-form-design" action="" mathod="POST" id="category_add" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="app_id" value="{{$id}}" />
                                        <p class="error-display" style="display: none;"></p>
                                        <div class="row m-0 no-gutters">
                                            <div class="form-group col-12 title_part">
                                                <label class="col-form-label" for="name">Title <span class="text-danger">*</span>
                                                </label>
                                                <div class="row m-0 no-gutters">
                                                    <div class="col-lg-12 p-0">
                                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Category Title" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row no-gutters">
                                            <div class="col-md-12">
                                                <label class="col-form-label px-0" for="name">custom field <span class="text-danger">*</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="row m-0 no-gutters">
                                            <!--  -->
                                            <div class="form-group col-9 col-sm-10 mb-3 pl-0 ">
                                                <div class="position-relative">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="arrow_selectbox" xmlns:xlink="http://www.w3.org/1999/xlink" width="46" height="46" viewBox="0 0 46 46" fill="none">
                                                        <rect width="46" height="46" fill="url(#pattern0)" />
                                                        <defs>
                                                            <pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
                                                                <use xlink:href="#image0_303_257" transform="scale(0.00195312)" />
                                                            </pattern>
                                                            <image id="image0_303_257" width="512" height="512" xlink:href="data:image/png;base64,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" />
                                                        </defs>
                                                    </svg>
                                                    <select class="form-control select-box" id="val-skill" name="val-skill">
                                                        <option value="">Please select</option>
                                                        @foreach($fields as $field)
                                                        <option data-id="{{$field->id}}" value="{{$field->type}}">{{$field->title}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-3 col-sm-2 text-center text-md-start p-0 mb-2 mb-md-0">
                                                <div class="custome_fields"><button type="button" data-id="{{$id}}" class="plus_btn btn mb-1 btn-info field_btn">Add</button></div>
                                            </div>
                                        </div>
                                        <div class="row m-0">
                                            <div id="category_form" class="form-group col-12 mb-0"></div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-12 mb-0 text-center mt-2">
                                                <div class="">
                                                    <button type="button" id="submit_category" class="btn btn-primary">Submit
                                                        <div class="spinner-border" role="status">
                                                            <span class="sr-only">Loading...</span>
                                                        </div>
                                                    </button>
                                                    <button type="reset" class="btn btn-dark">Cancel</button>
                                                    <!-- <span id="loader">
                                                        <div class="loader">
                                                            <svg class="circular" viewBox="25 25 50 50">
                                                                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10"></circle>
                                                            </svg>
                                                        </div>
                                                    </span> -->
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- {{ Form::close() }} -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8 table_detail_part px-0 px-xl-3">
                        <div class="card">
                            <div class="card-body px-3">
                                <h4 class="card-title px-3">Category List - {{$app_data->name}}</h4>
                                <div class="table-responsive">
                                    <table id="category_list" class="table zero-configuration customNewtable application_table table-child-part shadow-none" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>No</th>
                                                <th>Title</th>
                                                <th>status</th>
                                                <!-- <th>Date</th> -->
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
                        <button type="button" class="btn btn-secondary text-white" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary delete" id="RemoveUserSubmit">Delete</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="copyModalCenter">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Copy Category Form Structure ?</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row no-gutters">
                            <div class="col-md-12">
                                <label class="col-form-label px-0" for="name">custom field <span class="text-danger">*</span>
                                </label>
                            </div>
                        </div>
                        <div class="row m-0 no-gutters">
                            <div class="form-group col-9 col-sm-12 mb-3 pl-0 ">
                                <div class="position-relative">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="arrow_selectbox" xmlns:xlink="http://www.w3.org/1999/xlink" width="46" height="46" viewBox="0 0 46 46" fill="none">
                                        <rect width="46" height="46" fill="url(#pattern0)" />
                                        <defs>
                                            <pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
                                                <use xlink:href="#image0_303_257" transform="scale(0.00195312)" />
                                            </pattern>
                                            <image id="image0_303_257" width="512" height="512" xlink:href="data:image/png;base64,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" />
                                        </defs>
                                    </svg>
                                    <select class="form-control select-box" id="select_category" name="select_category">
                                        <option value="">Please select</option>
                                        @foreach($categories as $category)
                                            <?php $categoryfield = \App\Models\FormStructureNew::where('app_id', $app_data->id)->where('category_id', $category->id)->get(); ?>
                                            @if(count($categoryfield) > 0)
                                            <option data-id="{{$category->id}}" value="{{$category->id}}">{{$category->title}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary text-white" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="CopySubmit">Copy</button>
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
<script type="text/javascript">
    $("#cat_form").hide();
    var app_id = "{{$id}}";
    var urll = "{{asset('/category_image/')}}";
    $(".field_btn").click(function() {
        var app_id = $(this).attr('data-id');
        $("#cat_form").show();
    });
    var pluss = 0;
    $('body').on('click', '.plus_btn', function() {
        var html = "";
        var set_multiple = "";
        var set_multi = "";
        var selected = $('#val-skill option:selected');
        var option = selected.attr('data-id')
        // console.log("--->", option)
        var valuee = selected.attr('value')
        var field_name = option + "field_value[]";
        var field_key = option + "field_key[]";
        var field_name_id = option + "field_value" + pluss;
        var field_key_id = option + "field_key" + pluss;

        var type = "";
        if (valuee == "textbox") {
            type = "text";
        } else if (valuee == "file") {
            type = "file";
        } else if (valuee == "multi-file") {
            type = "file";
            set_multiple = "multiple";
            set_multi = "multiple";
            field_name = option + "field_value[]"
            $("select option[value*='multi-file']").prop('disabled',true);
        } else {
            type = ""
        }
        if (type != "") {
            html += '<div class="row mb-3 align-items-center">' +
                '<div class="col-12 col-sm-5 pr-0 px-0 pr-sm-3 mb-3 mb-sm-0">' +
                '<input type="text" placeholder="Enter Title" class="form-control input-flat" data="specific" id="' + field_name_id + '" name="' + field_key + '" />' +
                '</div>' +
                '<div class="col-10 col-sm-5 px-0 pl-sm-3">' +
                '<input type="' + type + '" class="form-control input-flat disabled_a" placeholder="Enter Value" data="'+set_multi+'" id="' + field_key_id + '" name="' + field_name + '" ' + set_multiple + '/>' +
                '</div>' +
                // '<div class="col-md-2">'+
                //     '<button type="button" class="plus_btn btn mb-1 btn-primary">+</button>'+
                // '</div>'+
                '<div class="col-2 col-sm-2 text-center text-sm-start px-0 px-sm-3">' +
                '<button type="button" class="minus_btn mb-1"><img src="{{asset("user/assets/icons/delete-red.png")}}"></button>' +
                '</div>' +
                '</div>';
        }
        $("#category_form").append(html);
        pluss++;
    })
    $('body').on('click', '.minus_btn', function() {
        var tthis = $(this).parent().parent();
        var ddd = tthis.remove()
    })

    $('body').on('click', '#submit_category', function() {
        // $("#submit_category").disabled();
        // $('#submit_category').prop('disabled', true);
        // $('.comman_loader').show()
        // var total_length = 0;
        // $("form#category_add :input").each(function(){
        //     if($(this).val().length == 0){
        //         if($(this).next().length != 0){
        //             total_length ++;
        //             $(this).next().text("This Field Is Required")
        //         }
        //     }else{
        //         if($(this).next().length != 0){
        //             total_length ++;
        //         }else{
        //             total_length ++;
        //         }

        //         $(this).next().text("")
        //         total_length --;
        //     }
        // })
        var i = 0;
        var url = "{{url('/')}}";
        // $( "#category_add input" ).each(function() {
        //     if($(this).attr('data') === 'multiple'){
        //         var old_name = $(this).attr('name')
        //         var suffix = old_name.match(/\d+/);
        //         var name_ = i+"_"+suffix[0]+"_field_value[]";
        //         $(this).attr('name', name_)
        //         i++ ;
        //     }
        // });
        var formData = new FormData($("#category_add")[0]);
        var validation = ValidateForm()
        if (validation != false) {
            $('.spinner-border').show();
            $('#submit_category').addClass('disabled');
            $.ajax({
                type: 'POST',
                url: url+"/category-insert-new",
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.status == 200) {
                        $('.spinner-border').hide();
                        toastr.success("Category Added", 'Success', {
                            timeOut: 5000
                        });
                        $('#category_list').DataTable().draw();
                        $('#submit_category').prop('disabled', false);
                        var total_specific = $(".disabled_a");
                        $(total_specific).each(function() {
                            if ($(this).val().length > 0) {
                                $(this).val('');
                            }
                        })
                        $("input#name").val('');
                    } else {
                        $('#submit_category').prop('disabled', false);
                        $('.spinner-border').hide();
                        toastr.error("Please try again", 'Error', {
                            timeOut: 5000
                        })
                    }
                }
            });
        }
        // if(total_length == 0){
        // }
    })

    function ValidateForm() {
        var isFormValid = true;
        var specific_arr = [];
        var specific_ids = [];
        var total_specific = $("#category_add input");
        $(total_specific).each(function() {
            if ($(this).attr('data') == "specific") {
                if ($(this).val()) {
                    specific_arr.push($(this).val())
                }
            }
        })
        $(total_specific).each(function() {
            if ($(this).attr('data') == "specific") {
                if ($(this).val()) {
                    specific_ids.push($(this).attr('id'))
                }
            }
        })
        $("#category_add input").each(function() {
            var regexp = /^\S*$/;
            if ($(this).attr("id") != undefined) {
                var FieldId = "span_" + $(this).attr("id");
                if ($.trim($(this).val()).length == 0 || $.trim($(this).val()) == 0) {
                    $(this).addClass("highlight");
                    if ($("#" + FieldId).length == 0) {
                        $("<span class='error-display' id='" + FieldId + "'>This Field Is Required</span>").insertAfter(this);
                    }
                    if ($("#" + FieldId).css('display') == 'none') {
                        $("#" + FieldId).fadeIn(500);
                    }
                    isFormValid = false;
                } else {
                    if ($.trim($(this).val()).length != 0 || $.trim($(this).val()) != 0) {
                        const seen = new Set();
                        const duplicates = specific_arr.filter(n => seen.size === seen.add(n).size);
                        var iddd = "";
                        var idd1 = "";
                        $(specific_ids).each(function(item, val) {
                            // console.log("---->"+val)
                            var vall = $("#" + val).val();
                            var iddds = "#" + val;
                            if (regexp.test(vall) == false) {
                                idd1 = "#span_" + val;
                                $(this).addClass("highlight");
                                $(iddds).nextAll('span').remove();
                                $("<span class='error-display other' id='" + idd1 + "'>Please remove space</span>").insertAfter(iddds);
                                isFormValid = false;
                            } else {
                                $(iddds).nextAll('span').remove();
                                if (duplicates.length > 0) {
                                    $(duplicates).each(function(item, val) {
                                        var ddd = specific_arr.indexOf(val);
                                        iddd = "#" + specific_ids[ddd];
                                        idd1 = specific_ids[ddd];

                                        $(iddd).nextAll('span').remove();
                                        $(iddd).addClass("highlight");
                                        $("<span class='error-display other' id='" + idd1 + "'>Please enter different value</span>").insertAfter(iddd);
                                        isFormValid = false;
                                    })
                                }
                                // else{
                                //     $(specific_ids).each( function(item, val){
                                //         iddd = "#"+val;
                                //         $(iddd).removeClass("highlight");  
                                //         $(iddd).nextAll('span').remove();
                                //         isFormValid = true; 
                                //     }) 
                                // }
                            }
                        })
                    }
                    $(this).removeClass("highlight");
                    if ($("#" + FieldId).length > 0) {
                        $("#" + FieldId).fadeOut(1000);
                    }
                }
            }
        })
        // return false;
        return isFormValid;
    }

    function format(d) {
        // console.log("opopop")
        // console.log(d)
        var list;
        var ii = 0;
        $.each(d.content, function(i, item) {
            var ddd = '';
            // console.log(item)
            // if (/(jpg|gif|png)$/.test(item.value)){ 
            var id = "myModal" + item.id;
            var ids = "#myModal" + item.id;
            if (item.field_type == "file") {
                var filename = item.field_value
                var valid_video_extensions = /(\.mp4|\.webm|\.m4v)$/i;
                var valid_extensions = /(\.jpg|\.jpeg|\.png|\.gif|\.webp)$/i;
                var image_video = '';
                var image_set_video = '';
                var imgg = urll + "/" + item.field_value
                if (valid_extensions.test(filename)) {
                    image_video += '<img class="img-responsive" src="' + imgg + '" />';
                    image_set_video += '<img class="img_side" data-toggle="modal" data-target="' + ids + '" src="' + imgg + '">';
                } else {
                    if (valid_video_extensions.test(filename)) {
                        image_video += '<iframe src="' + imgg + '" title="video" allowfullscreen></iframe>';
                        image_set_video += '<img class="img_side" data-toggle="modal" data-target="' + ids + '" src="{{asset("user/assets/icons/video_icon.jpg")}}">';
                    }
                }
                var html = '<div id="' + id + '" class="modal fade" role="dialog">' +
                    '<div class="modal-dialog">' +
                    '<div class="modal-content">' +
                    '<div class="modal-body">' + image_video + '</div>' +
                    '<div class="modal-footer">' +
                    '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>';
                // ddd += html + image_set_video;
                ddd += '<tr><td>' + item.field_key + '</td><td><spa>' + html + image_set_video + '</span></td></tr>';
            }else if(item.field_type == "multi-file"){
                var aaa = '';
                if(ii == 0){
                    if(d.multi.length > 0){
                        $.each( d.multi, function( key, value ) {
                            var aaa = '';
                            var filename = value
                            var valid_video_extensions = /(\.mp4|\.webm|\.m4v)$/i;
                            var valid_extensions = /(\.jpg|\.jpeg|\.png|\.gif|\.webp)$/i;
                            var image_video = '';
                            var image_set_video = '';
                            var imgg = urll + "/" + value
                            if (valid_extensions.test(filename)) {
                                image_video += '<img class="img-responsive" src="' + imgg + '" />';
                                image_set_video += '<img class="img_side" data-toggle="modal" data-target="' + ids + '" src="' + imgg + '">';
                            } else {
                                if (valid_video_extensions.test(filename)) {
                                    image_video += '<iframe src="' + imgg + '" title="video" allowfullscreen></iframe>';
                                    image_set_video += '<img class="img_side" data-toggle="modal" data-target="' + ids + '" src="{{asset("user/assets/icons/video_icon.jpg")}}">';
                                }
                            }
                            var html = '<div id="' + id + '" class="modal fade" role="dialog">' +
                                '<div class="modal-dialog">' +
                                '<div class="modal-content">' +
                                '<div class="modal-body">' + image_video + '</div>' +
                                '<div class="modal-footer">' +
                                '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</div>';
                            ddd += html + image_set_video;
                        })
                    }
                    aaa += '<tr><td>' + item.field_key + '</td><td><spa>'+ddd+'</span></td></tr>';
                }
                ddd = aaa;
                ii++;
            } else {
                // ddd += '<spa>' + item.field_value + '</span>';
                ddd += '<tr><td>' + item.field_key + '</td><td><spa>' + item.field_value + '</span></td></tr>';
            }
            list += ddd;
        });
        return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;" id="child_row">' +
            '<ul class="d-none">' + list + '</ul></table>';
    }

    var my_date_format = function(input) {
        // console.log("----->",input)
        var d = new Date(Date.parse(input.replace(/-/g, "/")));
        var month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct',
            'Nov', 'Dec'
        ];
        var date = d.getDay().toString() + " " + month[d.getMonth().toString()] + ", " +
            d.getFullYear().toString();
        return (date);
    };

    var id__ = "{{$id}}";
    $(document).ready(function() {
        var table = $('#category_list').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ url('/category-list') }}",
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: '{{ csrf_token() }}',
                    app_id: app_id
                },
            },
            "columnDefs": [{
                    "width": "7%",
                    "targets": 0
                },
                {
                    "width": "15%",
                    "targets": 1
                },
                {
                    "width": "25%",
                    "targets": 2
                },
                {
                    "width": "15%",
                    "targets": 3
                },
                {
                    "width": "20%",
                    "targets": 4
                },
            ],
            "columns": [{
                    className: 'dt-control',
                    orderable: false,
                    data: null,
                    defaultContent: "<div class='plus-minus-class'>&nbsp;</div>",
                },
                {
                    data: 'id',
                    name: 'id',
                    class: "text-left",
                    orderable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                        // return "<div><span class='plus-minus-class'>"+ meta.row + meta.settings._iDisplayStart + 1+"</span></div>";
                    }
                },
                {
                    data: 'title',
                    name: 'title',
                    class: "text-left",
                    orderable: false,
                    render: function(data, type, row) {
                        // return row.title;
                        return "<div><span class='application_text app_id_part total_request_text'>" + row.title + "</span></div>";
                    }
                },
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
                // {data: 'status', name: 'status', orderable: false, searchable: false, class: "text-center"},
                // {data: 'created_at', name: 'created_at', orderable: false, searchable: false, class: "text-center"},
                // {data: 'created_at', name: 'created_at', class: "text-center", orderable: false,
                //     render: function (data, type, row) {
                //         // var date = my_date_format(row.start_date);
                //         // console.log(date)
                //         return "<div><span class='application_text app_id_part date_part'>"+row.start_date+"</span></div>";
                //     }
                // },
                {
                    "mData": "action",
                    "mRender": function(data, type, row) {
                        
                        var url = "{{url('/')}}";
                       
                        var url0 = url+"/category-copy-new/"+row.id;
                        var url1 = url+"/category-edit-new/"+row.id;
                        // var url2 = url+"/sub-content/"+id__+"/"+row.id+"/0";
                        // var url2 = url+"/application-new-design/"+id__+"/"+row.id+"/0/0";
                        var url2 = url+"/application-new-design/"+row.id+"/"+id__+"/0";
                        // console.log(url2)
                        var img_url0 = "{{asset('user/assets/icons/copy.png')}}";
                        var img_url1 = "{{asset('user/assets/icons/edit.png')}}";
                        var img_url2 = "{{asset('user/assets/icons/delete.png')}}";
                        if(row.structures_content.length == 0){
                          var copy  = "<a href='javascript:void(0)' data-id='" + row.id + "' data-toggle='modal' data-target='#copyModalCenter' title=\"Copy\" class='copyBtn application_text mr-3'><img src='" + img_url0 + "' alt=''></a>";
                        }else{
                            var copy  = "<a href='javascript:void(0)' title=\"Copy\" class='application_text mr-3'><img src='" + img_url0 + "' alt=''></a>";
                        }
                        return "<a href='" +url2+ "' title='sub-content' class='application_text mr-3 btn'>Sub Content</a>"+
                             copy +
                            "<a href='" + url1 + "' title=\"Edit\" class='application_text mr-3'><img src='" + img_url1 + "' alt=''></a>" +
                            "<a rel='" + row.id + "' title=\"Delete\" href='javascript:void(0)' data-id='" +
                            row.id + "' data-toggle='modal' data-target='#exampleModalCenter' class='deleteUserBtn'><img src='" + img_url2 + "' alt=''></a>";
                    }
                }

            ],
            "order": [
                [1, 'asc']
            ],
        });
        $('#category_list tbody').on('click', 'td.dt-control', function() {
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

    $('body').on('click', '.deleteUserBtn', function(e) {
        var delete_user_id = $(this).attr('data-id');
        $("#exampleModalCenter").find('#RemoveUserSubmit').attr('data-id', delete_user_id);
    });
    $('body').on('click', '#RemoveUserSubmit', function(e) {
        $('#RemoveUserSubmit').prop('disabled', true);
        console.log($(this).attr('data-id'))
        var remove_user_id = $(this).attr('data-id');

        $.ajax({
            type: 'GET',
            url: "{{ url('/category') }}" + '/' + remove_user_id + '/delete',
            success: function(res) {
                if (res.status == 200) {
                    $("#exampleModalCenter").modal('hide');
                    $('#RemoveUserSubmit').prop('disabled', false);
                    $('#category_list').DataTable().draw();
                } else {
                    $("#exampleModalCenter").modal('hide');
                    $('#RemoveUserSubmit').prop('disabled', false);
                }
            },
            error: function(data) {
                toastr.error("Please try again", 'Error', {
                    timeOut: 5000
                });
            }
        });
    });

    $('body').on('click', '.copyBtn', function(e) {
        var copy_category_id = $(this).attr('data-id');
        
        $("#copyModalCenter").find('#CopySubmit').attr('data-id', copy_category_id);
    });
    $('body').on('click', '#CopySubmit', function(e) {
        $('#CopySubmit').prop('disabled', true);
        console.log($(this).attr('data-id'))
        var remove_user_id = $(this).attr('data-id');
        var select_category_id = $("#select_category").val();
       
        $.ajax({
            type: 'GET',
            url: "{{ url('/category') }}" + '/' + remove_user_id + '/' + select_category_id + '/copy',
            success: function(res) {
                if (res.status == 200) {
                    $("#copyModalCenter").modal('hide');
                    $('#CopySubmit').prop('disabled', false);
                    $('#category_list').DataTable().draw();
                } else {
                    $("#copyModalCenter").modal('hide');
                    $('#CopySubmit').prop('disabled', false);
                }
            },
            error: function(data) {
                toastr.error("Please try again", 'Error', {
                    timeOut: 5000
                });
            }
        });
    });

    function chageapplicationstatus(cat_id) {
        $.ajax({
            type: 'GET',
            url: "{{ url('/chageacategorystatus') }}" + '/' + cat_id,
            success: function(res) {
                if (res.status == 200 && res.action == 'deactive') {
                    toastr.success("Category Deactivated", 'Success', {
                        timeOut: 5000
                    });
                    $('#category_list').DataTable().draw();
                }
                if (res.status == 200 && res.action == 'active') {
                    toastr.success("Category activated", 'Success', {
                        timeOut: 5000
                    });
                    $('#category_list').DataTable().draw();
                }
            },
            error: function(data) {
                toastr.error("Please try again", 'Error', {
                    timeOut: 5000
                });
            }
        });
    }
</script>
@endpush('scripts')