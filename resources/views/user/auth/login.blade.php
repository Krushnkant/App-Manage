@extends('user.auth.layout')

@section('content')
<div class="row justify-content-center h-100">
    <div class="col-xl-6">
        <div class="form-input-content">
            <div class="card login-form mb-0">
                <div class="card-body pt-5">
                    <a class="text-center" href="index.html"> <h4>App Management</h4></a>
                    <form action="" method="POST" id="LoginForm">
                    {{ csrf_field() }}
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" placeholder="Password">
                        </div>
                        <button type="button" class="btn login-form__btn submit w-100" id="LoginSubmit">Sign In</button>
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
$( "#LoginSubmit" ).click(function() {
    $(this).prop('disabled',true);
    var formData = new FormData($("#LoginForm")[0]);
    $.ajax({
        type: 'POST',
        url: "{{ url('/login') }}",
        data: formData,
        processData: false,
        contentType: false,
        success: function (res) {
            if(res['status'] == 200){
                toastr.success(res['message'], 'Success',{timeOut: 5000});
                location.href ="{{ url('dashboard') }}";
            }else{
                toastr.error(res['message'], 'Error',{timeOut: 5000});
            }
        },
        error: function (data) {
            console.log("error")
            console.log(data)
        }
    });
});
</script>
@endpush('scripts')
