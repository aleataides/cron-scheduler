@extends('layouts.auth')

@section('content')
<div class="animate form login_form">
    <section class="login_content">
        {!! Form::open(['url' => route('login')]) !!}
        <h1>Sign In</h1>
        @include('partials._alerts')
        <div class="{{ $errors->has('email') ? 'bad' : '' }}">
            <input type="text" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}"/>
        </div>
        <div class="{{ $errors->has('password') ? 'bad' : '' }}">
            <input type="password" class="form-control" placeholder="Password" name="password"/>
        </div>
        <div>
            <button class="btn btn-default submit btn-sm">Sign in</button>
            <a class="reset_pass" href="#">Forgot passorwd?</a>
        </div>

        <div class="clearfix"></div>

        <div class="separator">
            <p class="change_link">New user?
                <a href="{{ route('register') }}" class="to_register"> Create an account </a>
            </p>
        </div>
        {!! Form::close() !!}
    </section>
</div>
@endsection