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
    #loader{
        display: none;
    }
    label.error {
        color: #ff0202;
    }
</style>
<div>
<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="{{url('application')}}">Application List</a></li>
            <li class="breadcrumb-item active">Edit Application</li>
        </ol>
    </div>
</div>
<div class="container-fluid pt-0 custom-form-design edit_application">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                <h4 class="card-title mb-4">Edit Application - Application Management</h4>
                    <div class="form-validation">
                        {{ Form::open(array('route' => array('application.update', $data->id), 'method' => 'PUT', 'enctype' => 'multipart/form-data', 'id' => 'application_add')) }}
                        <!-- <form class="form-valide" action="" method="post"> -->
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="col-form-label" for="name">Application Name <span class="text-danger">*</span>
                                    </label>
                                    <div class="">
                                        <input type="text" class="form-control" value="{{$data->name}}" id="name" name="name" placeholder="Enter Application Name">
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="col-form-label" for="icon">Application Icon <span class="text-danger">*</span>
                                    </label>
                                    <div class="">
                                        @if($data->is_url == 1)
                                        <input type="text" class="form-control" value="{{$data->icon_url}}" id="icon_url" name="icon_url" placeholder="Enter Application Icon">
                                        <div class="pre_img mt-3">
                                            <img class="set_img input-set-img-part" src="{{$data->icon_url}}" />
                                        </div>
                                        @else
                                        <input type="file" class="form-control" value="{{$data->icon}}" id="icon" name="icon" placeholder="Enter Application Icon">
                                        <div class="pre_img mt-3">
                                            <img class="set_img input-set-img-part" src="{{asset('app_icons/'.$data->icon)}}" />
                                        </div>
                                        @endif
                                    </div>
                                    <!-- <div class="form-group">
                                        <label class="col-form-label" for="Thumbnail">Application Icon  <span class="text-danger">*</span>
                                        </label>
                                        <input type="file" name="files[]" id="catIconFiles" multiple="multiple">
                                        <input type="hidden" name="catImg" id="catImg" value="">
                                        <div id="categorythumb-error" class="invalid-feedback animated fadeInDown" style="display: none;"></div>
                                    </div> -->
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="col-form-label" for="app_id">Application ID <span class="text-danger">*</span>
                                    </label>
                                    <div class="">
                                        <input type="text" class="form-control" id="app_id" value="{{$data->app_id}}" name="app_id" placeholder="Enter Application ID">
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="col-form-label" for="package_name">Package Name <span class="text-danger">*</span>
                                    </label>
                                    <div class="">
                                        <input type="text" class="form-control" id="package_name" value="{{$data->package_name}}" name="package_name" placeholder="Enter Package Name">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                
                                <div class="form-group col-md-6 mt-4">
                                    <div class="col-lg-8">
                                        <button type="submit" class="btn btn-primary" id="edit_app">Submit</button>
                                        <span id="loader">
                                            <div class="loader">
                                                <svg class="circular" viewBox="25 25 50 50">
                                                    <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10"></circle>
                                                </svg>
                                            </div>
                                        </span>
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
</div>
@endsection
@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script type="text/javascript">
    var app_id = "{{$data->id}}";
    console.log('{{ url("check-applicationId/") }}/'+app_id)
    var validation = $("#application_add").validate({
        rules: {
            name: {
                required: true,
            },
            // icon: {
            //     required: true,
            // },
            icon_url: {
                required: true,
            },
            app_id: {
                required: true,
                remote: '{{ url("check-applicationId/") }}/'+app_id
            },
            package_name: {
                required: true,
            },
        },
        messages: {
            name: {
                required: "Please enter application name",
            },
            // icon: {
            //     required: "Please choose application icon",
            // },
            icon_url: {
                required: "Please enter application icon url",
            },
            app_id: {
                required: "Please enter application ID",
                remote: "Please enter different application ID",
            },
            package_name: {
                required: "Please enter package name",
            },
        },
        submitHandler: function (form) {
            $('#loader').show()
            form.submit();
        }
    })
    // console.log(validation)
    // $( "#add_app").click(function() {
    //     $('#loader').show()
    // })
</script>
@endpush('scripts')