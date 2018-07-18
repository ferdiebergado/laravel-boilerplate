@extends('layouts.auth')
@section('content')
<body class="hold-transition register-page">
  <div class="register-box">
    <div class="register-logo">
      <a href="/"><b>{{ config('app.name') }}</b></a>
    </div>
    
    <div class="register-box-body">
      @include('messages')
      <p class="login-box-msg">{{ __('Reset Password')}}</p>
      
      <form action="{{ route('password.email') }}" method="POST" aria-label="{{ __('Reset Password') }}">
        @csrf
        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }} has-feedback">
          <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email Address') }}" name="email" value="{{ old('email') }}" required>
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          @if ($errors->has('email'))
          <span class="help-block" role="alert">
            <strong>{{ $errors->first('email') }}</strong>
          </span> 
          @endif          
        </div>
        
        
        <div class="row">
          <div class="col-xs-12">
            <button type="submit" class="btn btn-primary btn-block btn-flat">{{ __('Send Password Reset Link') }}</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      
    </div>
    <!-- /.form-box -->
    @include('footer')
  </div>
  <!-- /.register-box -->
  @endsection
  