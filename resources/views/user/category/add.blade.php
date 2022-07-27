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
                                                <div class="col-lg-3 p-0">
                                                    <div class="custome_fields"><button type="button" data-id="{{$id}}" class="btn mb-1 btn-info field_btn">Add Fields</button></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="row">
                                        <div class="form-group col-12">
                                            <div class="custome_fields"><button type="button" data-id="{{$id}}" class="btn mb-1 btn-info field_btn">Add Fields</button></div>
                                        </div>
                                    </div> -->
                                    <div class="row" id="cat_form">
                                        <div class="form-group col-12">
                                            <select class="form-control" id="val-skill" name="val-skill">
                                                <option value="">Please select</option>
                                                @foreach($fields as $field)
                                                    <option data-id="{{$field->id}}" value="{{$field->type}}">{{$field->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div id="category_form" class="form-group col-12"></div>
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
                        <div class="col-md-8"></div>
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
    // var dropzone = new Dropzone('#file-upload', {
    //     previewTemplate: document.querySelector('#preview-template').innerHTML,
    //     parallelUploads: 3,
    //     thumbnailHeight: 150,
    //     thumbnailWidth: 150,
    //     maxFilesize: 5,
    //     filesizeBase: 1500,
    //     thumbnail: function (file, dataUrl) {
    //         if (file.previewElement) {
    //             file.previewElement.classList.remove("dz-file-preview");
    //             var images = file.previewElement.querySelectorAll("[data-dz-thumbnail]");
    //             for (var i = 0; i < images.length; i++) {
    //                 var thumbnailElement = images[i];
    //                 thumbnailElement.alt = file.name;
    //                 thumbnailElement.src = dataUrl;
    //             }
    //             setTimeout(function () {
    //                 file.previewElement.classList.add("dz-image-preview");
    //             }, 1);
    //         }
    //     }
    // });
        
    // var minSteps = 6,
    //     maxSteps = 60,
    //     timeBetweenSteps = 100,
    //     bytesPerStep = 100000;
    // dropzone.uploadFiles = function (files) {
    //     var self = this;
    //     for (var i = 0; i < files.length; i++) {
    //         var file = files[i];
    //         totalSteps = Math.round(Math.min(maxSteps, Math.max(minSteps, file.size / bytesPerStep)));
    //         for (var step = 0; step < totalSteps; step++) {
    //             var duration = timeBetweenSteps * (step + 1);
    //             setTimeout(function (file, totalSteps, step) {
    //                 return function () {
    //                     file.upload = {
    //                         progress: 100 * (step + 1) / totalSteps,
    //                         total: file.size,
    //                         bytesSent: (step + 1) * file.size / totalSteps
    //                     };
    //                     self.emit('uploadprogress', file, file.upload.progress, file.upload
    //                         .bytesSent);
    //                     if (file.upload.progress == 100) {
    //                         file.status = Dropzone.SUCCESS;
    //                         self.emit("success", file, 'success', null);
    //                         self.emit("complete", file);
    //                         self.processQueue();
    //                     }
    //                 };
    //             }(file, totalSteps, step), duration);
    //         }
    //     }
    // }

    $("#cat_form").hide();
    $(".field_btn").click(function(){
        var app_id = $(this).attr('data-id');
        $("#cat_form").show();
    });
    $('#val-skill').change(function(){
        var html = "";
        var valuee = $(this).val()
        var option = $('option:selected', this).attr('data-id');
        var field_name = option+"field_value[]";
        var field_key = option+"field_key[]";
        // console.log(field_name)
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
                    '<div class="col-md-2">'+
                        '<button type="button" class="plus_btn btn mb-1 btn-primary">+</button>'+
                    '</div>'+
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
        $.ajax({
                type: 'POST',
                url: "{{ route('category.store') }}",
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    console.log(data)
                }
        });
    })
</script>
@endpush('scripts')