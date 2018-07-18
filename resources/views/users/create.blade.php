@extends('layouts.master')

@section('title')
<i class="fa fa-user-plus"></i> {{ __('messages.createuser') }}
@endsection

@section('subtitle')
{{ __('messages.createusersub') }}
@endsection

@section('content')
<form action="{{ route('admin.users.store') }}" method="POST" aria-label="{{ __('messages.createuser') }}" class="form-horizontal">
    @include('users.partial')
</form>
@endsection