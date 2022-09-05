@extends('user.layouts.layout')

@section('content')
<style>
    label.error {
        color: #f00;
        margin-top: 5px;
    }
</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" rel="stylesheet">

<div>
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <!-- <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Dashboard</a></li> -->
                <li class="breadcrumb-item active">Settings</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid pt-0 custom-form-design">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <!-- <div class="card">
                    <div class="card-body ">
                       <div class="d-flex mb-3">
                       <h4 class="card-title">Time Duration for Test Token</h4>
                        <div class="edit_form ml-3">
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#exampleModalCenter" title="Edit" class="application_text mr-4">
                                <img src="{{asset('user/assets/icons/edit.png')}}" alt="">
                            </a>
                        </div>
                       </div>
                        <div class="show_detail">
                            @if(isset($get_settings))
                                <div class="details">
                                    <span class="d-flex mb-2 "><h4 class="details_part">Start Token Time : </h4><b class="details_part_time">{{($get_settings->token_start_time != null) ? date("g:i A", strtotime($get_settings->token_start_time)) : ""}}</b></span>
                                    <span class="d-flex "><h4 class="details_part">End Token Time : </h4><b class="details_part_time">{{($get_settings->token_end_time != null) ? date("g:i A", strtotime($get_settings->token_end_time)) : ""}}</b></span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div> -->
                <div class="card">
                    <div class="card-body">
                        <div class="col-lg-12">
                        <div class="table-responsive">
                            <table id="" class="table table-striped table-bordered customNewtable" style="width:100%">
                                <tbody>
                                <tr>
                                    <th style="width: 50%">Time Duration for Test Token</th>
                                    <td>
                                        @if(isset($get_settings))
                                            <span id="UserDiscountPerVal">{{($get_settings->token_start_time != null) ? date("g:i A", strtotime($get_settings->token_start_time)) : ""}} | {{($get_settings->token_end_time != null) ? date("g:i A", strtotime($get_settings->token_end_time)) : ""}}</span>
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        <button id="editUserDiscountPerBtn" class="btn btn-outline-dark btn-sm" data-toggle="modal" data-target="#exampleModalCenter" >
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </button>
                                        <div class="modal fade" id="exampleModalCenter">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <div class="form-validation">
                                                            <h4 class="card-title text-left">Update Time</h4>
                                                            <form class="form-valide" action="" mathod="POST" id="settings" enctype="multipart/form-data">
                                                                <input type="hidden" name="user_id" value="{{Auth::user()->id}}" />
                                                                @csrf
                                                                <div class="row">
                                                                    <div class="form-group col-md-6 mb-2 mb-xl-3 text-left">
                                                                        <label class="col-form-label" for="name">Start Token Time</label>
                                                                        <div class="">
                                                                            <input type="time" class="form-control token_start_time" id="datetimepicker" value="{{ ((isset($get_settings)) && $get_settings->token_start_time) ? $get_settings->token_start_time : ''}}" name="token_start_time" placeholder="11:00 AM">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-md-6 mb-2 mb-xl-3 text-left">
                                                                        <label class="col-form-label" for="name">End Token Time</label>
                                                                        <div class="">
                                                                            <input type="time" class="form-control token_end_time" id="token_end_time" value="{{ ((isset($get_settings)) && $get_settings->token_end_time) ? $get_settings->token_end_time : ''}}" name="token_end_time" placeholder="11:00 AM">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <button type="button" class="btn btn-primary" id="Add">Submit</button>
                                                                    </div>
                                                                    <span id="loader">
                                                                        <div class="loader">
                                                                            <svg class="circular" viewBox="25 25 50 50">
                                                                                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10"></circle>
                                                                            </svg>
                                                                        </div>
                                                                    </span>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th style="width: 50%">Change Password</th>
                                    <td><span id="ShippingCostVal">{{$get_user->decrypted_password}}</span></td>
                                    <td class="text-right">
                                        <button id="editShippingCostBtn" class="btn btn-outline-dark btn-sm" data-toggle="modal" data-target="#ChangePasswordModal">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </button>
                                        <div class="modal fade" id="ChangePasswordModal">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <div class="form-validation">
                                                            <h4 class="card-title text-left">Change Password</h4>
                                                            <form class="form-valide" action="" mathod="POST" id="change_pwd_form" enctype="multipart/form-data">
                                                                <input type="hidden" name="user_id" value="{{Auth::user()->id}}" />
                                                                @csrf
                                                                <div class="row">
                                                                    <div class="form-group col-md-12 mb-2 mb-xl-3 text-left">
                                                                        <label class="col-form-label" for="name">New Password</label>
                                                                        <div class="">
                                                                            <input type="password" class="form-control new_password" id="new_password" value="" name="new_password" placeholder="New Password">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-md-12 mb-2 mb-xl-3 text-left">
                                                                        <label class="col-form-label" for="name">Confirm Password</label>
                                                                        <div class="">
                                                                            <input type="password" class="form-control confirm_new_password" id="confirm_new_password" value="" name="confirm_new_password" placeholder="Confirm New Password">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <button type="submit" class="btn btn-primary" id="change_pwd">Submit</button>
                                                                    </div>
                                                                    <span id="loader">
                                                                        <div class="loader">
                                                                            <svg class="circular" viewBox="25 25 50 50">
                                                                                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10"></circle>
                                                                            </svg>
                                                                        </div>
                                                                    </span>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="modal-footer">
                                                        <button type="button" class="btn btn-gray" data-dismiss="modal">Close</button>
                                                        <button type="button" class="btn btn-primary delete" id="RemoveUserSubmit">Delete</button>
                                                    </div> -->
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
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
@endsection
@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>  
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script type="text/javascript">
    
    $('body').on('click', '#Add', function () {
        $('#loader').show();
        $('#Add').prop('disabled', true);
        var formData = new FormData($("#settings")[0]);
        $.ajax({
                type: 'POST',
                url: "{{ route('settings.store') }}",
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                    if(res['status']==200){
                        $('#loader').hide();
                        toastr.success("Token time Added",'Success',{timeOut: 5000});
                        window.location.href = "{{ url('settings')}}";
                        // $("#form_structures_add")[0].reset()
                    }else{
                        $('#loader').hide();
                        toastr.success("Token time not Added",'Error',{timeOut: 5000}); 
                    }
                },
                error: function (data) {
                    $('#Add').prop('disabled', false);
                    $('#loader').hide();
                    $(btn).prop('disabled',false);
                    toastr.error("Please try again",'Error',{timeOut: 5000});
                }
        });
    })

    $('body').on('click', '#change_pwd', function (e) {
        e.preventDefault();
        $('#loader').show();
        $('#Add').prop('disabled', true);
        var formData = new FormData($("#change_pwd_form")[0]);
        console.log(formData)
        $.ajax({
                type: 'POST',
                url: "{{ url('change-password') }}",
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                    // console.log(res)
                    if(res['status']==200){
                        $('#loader').hide();
                        toastr.success("Password Change Successfully",'Success',{timeOut: 5000});
                        window.location.href = "{{ url('settings')}}";
                    }else{
                        $('#loader').hide();
                        toastr.success("Password Not Change Successfully",'Error',{timeOut: 5000}); 
                    }
                },
                error: function (data) {
                    $('#Add').prop('disabled', false);
                    $('#loader').hide();
                    $(btn).prop('disabled',false);
                    toastr.error("Please try again",'Error',{timeOut: 5000});
                }
        });
    })

    var validation = $("#change_pwd_form").validate({
        rules: {
            new_password: {
                required: true,
            },
            confirm_new_password: {
                required: true,
                equalTo : "#new_password"
            },
        },
        messages: {
            new_password: {
                required: "Please Enter New Password",
            },
            confirm_new_password: {
                required: "Please Enter Confirm New Password",
                equalTo : "Please Enter Confirm Password Same as New Password"
            },
        }
    })
</script>
@endpush('scripts')