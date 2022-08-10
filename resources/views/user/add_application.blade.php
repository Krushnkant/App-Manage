@extends('user.layouts.layout')

@section('content')
<style>
    label.error {
        color: #ff0202;
    }
    .comman_loader{
        display: none;
    }
</style>
<div>
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item "><a href="{{url('application')}}">Application List</a></li>
                <li class="breadcrumb-item active">Add Application</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid pt-0 custom-form-design">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Add Application - Application Management</h4>
                        <p><b>Note: </b> All Fields Are Mandatory</p>
                        <div class="form-validation">
                            {{ Form::open(array('url' => 'application', 'method' => 'post', 'enctype' => 'multipart/form-data', 'id' => 'application_add')) }}
                            <!-- <form class="form-valide" action="" method="post"> -->
                                <div class="row">
                                    <div class="form-group col-md-6 mb-2 mb-xl-3">
                                        <label class="col-form-label" for="name">Application Name <span class="text-danger">*</span>
                                        </label>
                                        <div class="">
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Application Name">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 mb-2 mb-xl-3">
                                        <label class="col-form-label" for="icon">Application Icon <span class="text-danger">*</span>
                                        </label>
                                        <div class="">
                                            <input type="file" class="form-control" id="icon" name="icon" placeholder="Enter Application Icon">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 mb-2 mb-xl-3">
                                        <label class="col-form-label" for="app_id">Application ID <span class="text-danger">*</span>
                                        </label>
                                        <div class="">
                                            <input type="text" class="form-control" id="app_id" name="app_id" placeholder="Enter Application ID">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 mb-2 mb-xl-3">
                                        <label class="col-form-label" for="package_name">Package Name <span class="text-danger">*</span>
                                        </label>
                                        <div class="">
                                            <input type="text" class="form-control" id="package_name" name="package_name" placeholder="Enter Package Name">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2 mt-md-3">
                                    <div class="form-group col-md-6">
                                        <div class="">
                                            <button type="submit" class="btn btn-primary" id="add_app">Submit</button>
                                            <span class="comman_loader">
                                                <svg class="circular" viewBox="25 25 50 50">
                                                    <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10"></circle>
                                                </svg>
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
    var validation = $("#application_add").validate({
        rules: {
            name: {
                required: true,
            },
            icon: {
                required: true,
            },
            app_id: {
                required: true,
                // checkApp: true,
                unique: true,
            },
            package_name: {
                required: true,
            },
        },
        messages: {
            name: {
                required: "Please enter application name",
            },
            icon: {
                required: "Please choose application icon",
            },
            app_id: {
                required: "Please enter application ID",
                checkApp: "Please enter different application ID",
            },
            package_name: {
                required: "Please enter package name",
            },
        },
    })

    // let result = false;
    $.validator.addMethod("checkApp", function(value, element, isSuccess = false) {
        var app_id = value;
        var response = [];
        // var isSuccess = false;
        $.ajax({
            type: 'POST',
            url: "{{ url('check-applicationId') }}",
            data: { _token: '{{ csrf_token() }}', app_id: app_id},
            success: function(data) {
                // result = data.message
                // response = data;
                response.push(data)
                isSuccess = data.message === "false" ? false : true
            }
        });
        console.log(response)
        console.log(isSuccess)
        // return result;
        return false;
    }, "Please enter different application ID");

    // console.log(validation)
    $( "#add_app").click(function() {
        $('.comman_loader').show()
    })

</script>
@endpush('scripts')