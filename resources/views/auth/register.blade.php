@extends('layouts.auth')
@section('content')
<body class="hold-transition register-page">
  <div class="register-box">
    <div class="register-logo">
      <a href="../../index2.html"><b>{{ config('app.name') }}</b></a>
    </div>
    
    <div class="register-box-body">
      @include('messages')
      <p class="login-box-msg">Register a new membership</p>
      
      <form action="{{ route('register') }}" method="POST" aria-label="{{ __('Register') }}">
        @csrf
        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }} has-feedback">
          <input type="text" class="form-control" placeholder="{{ __('Name') }}" name="name" value="{{ old('name') }}" required autofocus>
          <span class="glyphicon glyphicon-user form-control-feedback"></span>
          @if ($errors->has('name'))
          <span class="help-block" role="alert">
            <strong>{{ $errors->first('name') }}</strong>
          </span> 
          @endif        
        </div>
        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }} has-feedback">
          <input type="email" class="form-control" placeholder="{{ __('Email Address') }}" name="email" value="{{ old('email') }}" required>
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          @if ($errors->has('email'))
          <span class="help-block" role="alert">
            <strong>{{ $errors->first('email') }}</strong>
          </span> 
          @endif          
        </div>
        <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }} has-feedback">
          <input type="password" class="form-control" placeholder="{{ __('Password') }}" name="password" required>
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
          <div class="col-xs-8">
            <div class="checkbox icheck">
              <label>
                <input type="checkbox" name="agree" value="{{ old('agree') }}" required> I agree to the <a href="#">terms</a>
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-xs-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">{{ __('Register') }}</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <div class="social-auth-links text-center">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign up using
          Facebook</a>
          <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign up using
            Google+</a>
          </div>
          
          <a href="{{ route('login') }}" class="text-center">I already have a membership</a>
        </div>
        @include('footer')      
        <!-- /.form-box -->
      </div>
      <!-- /.register-box -->
      @endsection
      