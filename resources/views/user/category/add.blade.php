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
                    <div class="form-validation">
                        {{ Form::open(array('url' => 'category', 'method' => 'post', 'enctype' => 'multipart/form-data')) }}
                        <!-- <form class="form-valide" action="" method="post"> -->
                            <input type="hidden" name="app_id" value="{{$id}}" />
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="col-lg-4 col-form-label" for="name">Title: <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-12">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Application Name..">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <div class="custome_fields"><button type="button" data-id="{{$id}}" class="btn mb-1 btn-info field_btn">Add Fields</button></div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <select class="form-control" id="val-skill" name="val-skill">
                                        <option value="">Please select</option>
                                        @foreach($fields as $field)
                                            <option value="{{$field->type}}">{{$field->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <div class="col-lg-8 ml-auto">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </div>
                        <!-- </form> -->
                        {{ Form::close() }}
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

    $(".field_btn").click(function(){
        var app_id = $(this).attr('data-id');
    });
    $('#val-skill').change(function(){
        var html = "";
        // html += '<div class="row">'\n+
        //             '<div class="col-md-4">'\n+
        //                 '<input type="" name="field_key[]" />'\n+
        //             '</div>'\n+
        //             '<div class="col-md-4">'\n+
        //                 '<input type="" name="field_value[]" />'\n+
        //             '</div>'\n+
        //             '<div class="col-md-2">'\n+
        //                 '<button class="plus_btn">+</button>'\n+
        //             '</div>'\n+
        //             '<div class="col-md-2">'\n+
        //                 '<button class="minus_btn">-</button>'\n+
        //             '</div>'\n+
        //         '</div>';
        var valuee = $(this).val()
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

        console.log(type)

        html += '<div class="row">'/n+
                    '<div class="col-md-4">'/n+
                        '<input type="'+type+'" name="field_key[]" />'/n+
                    '</div>'/n+
                    '<div class="col-md-4">'/n+
                        '<input type="'+type+'" name="field_value[]" />'/n+
                    '</div>'/n+
                    '<div class="col-md-2">'/n+
                        '<button class="plus_btn">+</button>'/n+
                    '</div>'/n+
                    '<div class="col-md-2">'/n+
                        '<button class="minus_btn">-</button>'/n+
                    '</div>'/n+
                '</div>';
        console.log(html)
    })
</script>
@endpush('scripts')