@extends('user.layouts.layout')

@section('content')
<style>
    label.error {
        color: #ff0202;
    }
    #loader{
        display: none;
    }
    input.form-check-input.is_url {
        height: auto;
    }
    .radio_btn {
        display: flex;
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
                            <!-- <form class="form-valide" id="application_add" action="" method="post"> -->
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-6 mb-2 mb-xl-3">
                                        <label class="col-form-label" for="name">Application Name <span class="text-danger">*</span>
                                        </label>
                                        <div class="">
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Application Name">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 mb-2 mb-xl-3">
                                        <label class="col-form-label" for="app_id">Application ID <span class="text-danger">*</span>
                                        </label>
                                        <div class="">
                                            <input type="text" class="form-control app_ajax" id="app_id" name="app_id" placeholder="Enter Application ID">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 mb-2 mb-xl-3" id="myForm">
                                        <label class="col-form-label pt-0" for="icon">Application Icon <span class="text-danger">*</span>
                                        </label>
                                        <div class="radio_btn mb-1">
                                            <!-- <label class="col-form-label" for="icon">Are You Add Application Icon Url ?</label> -->
                                            <!-- <br> -->
                                            <div class="form-check mr-2">
                                                <input type="radio" class="form-check-input is_url" name="is_url" value="1">
                                                <label for="yes">URL</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" class="form-check-input is_url" name="is_url" value="0" checked>
                                                <label for="no">Image</label>
                                            </div>
                                        </div>
                                        <div class="file_div">
                                            <input type="file" class="form-control" id="icon" name="icon" placeholder="Enter Application Icon">
                                        </div>
                                        <div class="text_div">
                                            <input type="text" class="form-control" id="icon_url" name="icon_url" placeholder="Enter Application Icon Url">
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
                                            <!-- <button type="button" class="btn btn-primary" id="add_app">Submit</button> -->
                                            <button type="submit" class="btn btn-primary" id="add_app">Submit</button>
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
    var app_id = "0";
    var validation = $("#application_add").validate({
        rules: {
            name: {
                required: true,
            },
            icon: {
                required: true,
                validateFile: true
            },
            icon_url: {
                required: true,
                checkLink: true,
            },
            app_id: {
                required: true,
                remote: '{{ url("check-applicationId") }}/'+app_id
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
                // accept: "Only allow PNG, JPEG or JPEG image"
            },
            icon_url: {
                required: "Please enter application icon url",
                checkLink: "Please enter valid URL"
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
            // console.log(form)
            $('#loader').show()
            form.submit();
        }
    })
    $.validator.addMethod("checkLink", function(value, element) {
        var result = false;
        var pattern = (/^(http(s)?:\/\/)?(www\.)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/);
        result = pattern.test(value);
        return result;
    }, "Please enter valid URL");

    $.validator.addMethod("validateFile", function(value, element) {
        var result = false;
        var fileExtension = ['jpg', 'jpeg', 'png'];
        result = ($.inArray(value.split('.').pop().toLowerCase(), fileExtension) != -1)
        return result;
    }, "Please choose only JPG, JPEG & PNG image");
    
    $(".text_div").hide();
    $(".is_url").change(function(){
        var selValue = $("input[type='radio']:checked").val();
        if(selValue == 1){
            $(".text_div").show();
            $(".file_div").hide();
        }else{
            $(".file_div").show();
            $(".text_div").hide();
        }
    });
   

    // $('body').on('click', '#add_app', function () {
    //     var formData = new FormData($("#application_add")[0]);
    //     var validation = ValidateForm()
    //     if(validation != false){
    //         $('#loader').show();
    //         $('#add_app').prop('disabled', true);
    //         $.ajax({
    //             type: 'POST',
    //             url: "{{ route('application.store') }}",
    //             data: formData,
    //             processData: false,
    //             contentType: false,
    //             success: function(data) {
    //                 if(data.status == 200){
    //                     $('#loader').hide();
    //                     toastr.success("Application Added",'Success',{timeOut: 5000});
    //                     // $('#category_list').DataTable().draw();
    //                     $("#add_app")[0].reset();
    //                 }else{
    //                     $('#add_app').prop('disabled', false);
    //                     $('#loader').hide();
    //                     toastr.error("Please try again",'Error',{timeOut: 5000})
    //                 }
    //             }
    //         });
    //     }
    // })

    // function ValidateForm() {
    //     var isFormValid = true;  
    //     var result = false;
    //     $("#application_add input").each(function () { 
    //         var dddisplay = true;
    //         if($(this).hasClass("app_ajax")){
    //             var app_id = $(this).val()
    //             // console.log(app_id)
    //             // $.ajax({
    //             //     type: 'POST',
    //             //     url: "{{ url('check-applicationId') }}",
    //             //     data: { _token: '{{ csrf_token() }}', app_id: app_id},
    //             //     success: function(data) {
    //             //         console.log(data)
    //             //         if(data.message == "true"){
    //             //             result = true;
    //             //         }else{
    //             //             result = false;
    //             //         }
    //             //         // result = data.message
    //             //         // // response = data;
    //             //         // response.push(data)
    //             //         // isSuccess = data.message === "false" ? false : true
    //             //         // dddisplay = result;
    //             //     }
    //             //     console.log("******* "+result)
    //             // });
    //         }
    //         // console.log("-----> "+result)
    //         var regexp = /^\S*$/; 
    //         if($(this).attr("id") != undefined){
    //             var FieldId = "span_" + $(this).attr("id");
    //             if ($.trim($(this).val()).length == 0 || $.trim($(this).val())==0) {
    //                 $(this).addClass("highlight");
    //                 if ($("#" + FieldId).length == 0) {  
    //                         $("<span class='error-display' id='" + FieldId + "'>This Field Is Required</span>").insertAfter(this);  
    //                 }
    //                 if ($("#" + FieldId).css('display') == 'none'){  
    //                     $("#" + FieldId).fadeIn(500);  
    //                 } 
    //                 isFormValid = false;  
    //             }else{  
    //                 $(this).removeClass("highlight"); 
    //                 if ($("#" + FieldId).length > 0) {
    //                     $("#" + FieldId).fadeOut(1000);  
    //                 }  
    //             }
    //         }
    //     })
    //     console.log(isFormValid)
    //     // return false;
    //     return isFormValid;  
    // }

</script>
@endpush('scripts')