@extends('user.auth.layout')

@section('content')
<div class="row justify-content-center h-100">
    <div class="col-xl-6">
        <div class="form-input-content">
            <div class="card login-form mb-0">
                <div class="card-body pt-5">
                    <a class="text-center" href="index.html"> <h4>App Management</h4></a>
                    <form action="/login" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" placeholder="Password">
                        </div>
                        <button class="btn login-form__btn submit w-100">Sign In</button>
                    </form>
                    <p class="mt-5 login-form__footer">Dont have account? <a href="{{ url('register') }}" class="text-primary">Sign Up</a> now</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
