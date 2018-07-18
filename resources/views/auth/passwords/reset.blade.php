@extends('layouts.auth')
@section('content')
<body class="hold-transition register-page">
  <div class="register-box">
    <div class="register-logo">
      <a href="../../index2.html"><b>{{ config('app.name') }}</b></a>
    </div>
    
    <div class="register-box-body">
      @include('messages')
      <p class="login-box-msg">{{ __('Reset Password')}}</p>
      
      <form action="{{ route('password.request') }}" method="POST" aria-label="{{ __('Reset Password') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }} has-feedback">
          <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email Address') }}" name="email" value="{{ old('email') }}" required>
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          @if ($errors->has('email'))
          <span class="help-block" role="alert">
            <strong>{{ $errors->first('email') }}</strong>
          </span> 
          @endif          
        </div>
        <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }} has-feedback">
          <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('Password') }}" name="password" required>
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          @if ($errors->has('password'))
          <span class="help-block" role="alert">
            <strong>{{ $errors->first('password') }}</strong>
          </span> 
          @endif
        </div>
        <div class="form-group has-feedback">
          <input type="password" class="form-control" placeholder="Retype password" name="password_confirmation" required>
          <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
        </div>
        <div class="row">
          <div class="col-xs-12">
            <button type="submit" class="btn btn-primary btn-block btn-flat">{{ __('Reset Password') }}</button>
          </div>
          <!-- /.col -->
        </div>
      </form>      
    </div>
    @include('footer')
    <!-- /.form-box -->
  </div>
  <!-- /.register-box -->
  @endsection
  