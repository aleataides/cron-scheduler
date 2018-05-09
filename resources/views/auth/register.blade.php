@extends('layouts.auth')

@section('content')
<div class="animate form registration_form" style="opacity: 1;">
    <section class="login_content">
        {!! Form::open(['url' => route('register')]) !!}
        <h1>Create an account</h1>
        @include('partials._alerts')
        <div class="{{ $errors->has('name') ? 'bad' : '' }}">
            <input type="text" class="form-control" placeholder="Name" name="name" value="{{ old('name') }}"/>
        </div>
        <div  class="{{ $errors->has('email') ? 'bad' : '' }}">
            <input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}"/>
        </div>
        <div class="{{ $errors->has('password') ? 'bad' : '' }}">
            <input type="password" class="form-control" placeholder="Password" name="password"/>
        </div>
        <div>
            <input type="password" class="form-control" placeholder="Password confirm" name="password_confirmation"/>
        </div>
        <div>
            <button class="btn btn-default btn-sm" type="submit">Sign up</button>
        </div>

        <div class="clearfix"></div>

        <div class="separator">
            <p class="change_link">Already have an account ?
                <a href="{{ route('login') }}" class="to_register"> Enter here </a>
            </p>
        </div>
        {!! Form::close() !!}
    </section>
</div>
@endsection