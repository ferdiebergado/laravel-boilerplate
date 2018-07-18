@extends('layouts.auth')
@section('content')
<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="/"><b>{{ config('app.name') }}</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
      @include('messages')
      <p class="login-box-msg">Sign in to start your session</p>
      
      <form action="{{ route('login') }}" method="POST" aria-label="{{ __('Login') }}">
        @csrf
        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }} has-feedback">
          <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="{{ __('E-Mail') }}" required autofocus>
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          @if ($errors->has('email'))
          <span class="help-block" role="alert">
            <strong>{{ $errors->first('email') }}</strong>
          </span> 
          @endif        
        </div>
        <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }} has-feedback">
          <input type="password" class="form-control" name="password" placeholder="{{ __('Password') }}" required>
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          @if ($errors->has('password'))
          <span class="help-block" role="alert">
            <strong>{{ $errors->first('password') }}</strong>
          </span> 
          @endif            
        </div>
        <div class="row">
          <div class="col-xs-8">
            <div class="checkbox icheck">
              <label>
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-xs-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">{{ __('Login') }}</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      
      <a href="{{ route('password.request') }}">I forgot my password</a><br>
      <a href="{{ route('register') }}" class="text-center">Register a new membership</a>
      
    </div>
    <!-- /.login-box-body -->
    @include('footer')
  </div>
  <!-- /.login-box -->
  @endsection        
  