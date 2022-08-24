@extends('user.layouts.layout')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" rel="stylesheet">

<div>
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item "><a href="{{url('application')}}">Application List</a></li>
                <li class="breadcrumb-item active">Add Settings</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid pt-0 custom-form-design">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Add Settings - Application Management</h4>
                        <div class="form-validation">
                            <form class="form-valide" action="" mathod="POST" id="settings" enctype="multipart/form-data">
                                <input type="hidden" name="user_id" value="{{Auth::user()->id}}" />
                            @csrf
                                <div class="row">
                                    <div class="form-group col-md-6 mb-2 mb-xl-3">
                                        <label class="col-form-label" for="name">Start Token Time</label>
                                        <div class="">
                                            <input type="time" class="form-control token_start_time" id="datetimepicker" value="{{ ((isset($get_settings)) && $get_settings->token_start_time) ? $get_settings->token_start_time : ''}}" name="token_start_time" placeholder="11:00 AM">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 mb-2 mb-xl-3">
                                        <label class="col-form-label" for="name">End Token Time</label>
                                        <div class="">
                                            <input type="time" class="form-control token_end_time" id="token_end_time" value="{{ ((isset($get_settings)) && $get_settings->token_end_time) ? $get_settings->token_end_time : ''}}" name="token_end_time" placeholder="11:00 AM">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <button type="button" class="btn btn-primary" id="Add">Submit</button>
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
    </div>
</div>
@endsection
@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>  
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>

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
                        window.location.href = "{{ url('application')}}";
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
</script>
@endpush('scripts')