@extends('user.auth.layout')

@section('content')
<div class="row justify-content-center h-100">
    <div class="col-xl-6">
        <div class="form-input-content">
            <div class="card login-form mb-0">
                <div class="card-body pt-5">
                    <a class="text-center" href="{{ url('/') }}"> <h4>App Management</h4></a>
                    <form action="" method="POST" id="LoginForm" class="mt-5 mb-3 login-input">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" placeholder="Email">
                            <div id="email-error" class="invalid-feedback animated fadeInDown" style="display: none;"></div>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" placeholder="Password">
                            <div id="password-error" class="invalid-feedback animated fadeInDown" style="display: none;"></div>
                        </div>
                        <button type="button" class="btn login-form__btn submit w-100" id="LoginSubmit">
                            <span>Sign In</span>
                            <!-- <span class="comman_loader">
                                <svg class="circular" viewBox="25 25 50 50">
                                    <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10"></circle>
                                </svg>
                            </span> -->
                        </button>
                    </form>
                    <!-- <p class="mt-5 login-form__footer">Dont have account? <a href="{{ url('register') }}" class="text-primary">Sign Up</a> now</p> -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script type="text/javascript">
$( "#LoginSubmit").click(function() {
    $(this).prop('disabled',true);
    var formData = new FormData($("#LoginForm")[0]);
    $.ajax({
        type: 'POST',
        url: "{{ url('/login') }}",
        data: formData,
        processData: false,
        contentType: false,
        success: function (res) {
          
            if(res.status == 'failed'){
                $('#LoginSubmit').prop('disabled',false);
                if (res.errors.email) {
                    $('#email-error').show().text(res.errors.email);
                } else {
                    $('#email-error').hide();
                }

                if (res.errors.password) {
                    $('#password-error').show().text(res.errors.password);
                } else {
                    $('#password-error').hide();
                }
            }
            if(res['status'] == 200){
                toastr.success(res['message'], 'Success',{timeOut: 5000});
                location.href ="{{ url('dashboard') }}";
            }

            if(res.status == 400){
                toastr.error(res['message'], 'Error',{timeOut: 5000});
                $("#LoginSubmit").prop('disabled',false);
            }
            
        },
        error: function (data) {
            $("#LoginSubmit").prop('disabled',false);
            toastr.error("Please try again",'Error',{timeOut: 5000});
        }
    });
});
</script>
@endpush('scripts')
