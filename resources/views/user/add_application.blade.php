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
<div class="container-fluid mt-3 custom-form-design">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                
                <div class="card-body">
                    <h4 class="card-title">Add Application</h4>
                    <div class="form-validation">
                        {{ Form::open(array('url' => 'application', 'method' => 'post', 'enctype' => 'multipart/form-data')) }}
                        <!-- <form class="form-valide" action="" method="post"> -->
                            <div class="row">
                                <div class="form-group col-md-6 mb-2 mb-xl-3">
                                    <label class="col-form-label" for="name">Application Name: <span class="text-danger">*</span>
                                    </label>
                                    <div class="">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Application Name.." required>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 mb-2 mb-xl-3">
                                    <label class="col-form-label" for="icon">Application Icon: <span class="text-danger">*</span>
                                    </label>
                                    <div class="">
                                        <input type="file" class="form-control" id="icon" name="icon" placeholder="Application Icon.." required>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 mb-2 mb-xl-3">
                                    <label class="col-form-label" for="app_id">Application ID: <span class="text-danger">*</span>
                                    </label>
                                    <div class="">
                                        <input type="text" class="form-control" id="app_id" name="app_id" placeholder="Application ID..">
                                    </div>
                                </div>
                                <div class="form-group col-md-6 mb-2 mb-xl-3">
                                    <label class="col-form-label" for="package_name">Package Name: <span class="text-danger">*</span>
                                    </label>
                                    <div class="">
                                        <input type="text" class="form-control" id="package_name" name="package_name" placeholder="Package Name.." required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2 mt-md-3">
                                <div class="form-group col-md-6">
                                    <div class="">
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
<script type="text/javascript">
    var dropzone = new Dropzone('#file-upload', {
            previewTemplate: document.querySelector('#preview-template').innerHTML,
            parallelUploads: 3,
            thumbnailHeight: 150,
            thumbnailWidth: 150,
            maxFilesize: 5,
            filesizeBase: 1500,
            thumbnail: function (file, dataUrl) {
                if (file.previewElement) {
                    file.previewElement.classList.remove("dz-file-preview");
                    var images = file.previewElement.querySelectorAll("[data-dz-thumbnail]");
                    for (var i = 0; i < images.length; i++) {
                        var thumbnailElement = images[i];
                        thumbnailElement.alt = file.name;
                        thumbnailElement.src = dataUrl;
                    }
                    setTimeout(function () {
                        file.previewElement.classList.add("dz-image-preview");
                    }, 1);
                }
            }
        });
        
        var minSteps = 6,
            maxSteps = 60,
            timeBetweenSteps = 100,
            bytesPerStep = 100000;
        dropzone.uploadFiles = function (files) {
            var self = this;
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                totalSteps = Math.round(Math.min(maxSteps, Math.max(minSteps, file.size / bytesPerStep)));
                for (var step = 0; step < totalSteps; step++) {
                    var duration = timeBetweenSteps * (step + 1);
                    setTimeout(function (file, totalSteps, step) {
                        return function () {
                            file.upload = {
                                progress: 100 * (step + 1) / totalSteps,
                                total: file.size,
                                bytesSent: (step + 1) * file.size / totalSteps
                            };
                            self.emit('uploadprogress', file, file.upload.progress, file.upload
                                .bytesSent);
                            if (file.upload.progress == 100) {
                                file.status = Dropzone.SUCCESS;
                                self.emit("success", file, 'success', null);
                                self.emit("complete", file);
                                self.processQueue();
                            }
                        };
                    }(file, totalSteps, step), duration);
                }
            }
        }
</script>
@endpush('scripts')