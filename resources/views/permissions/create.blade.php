@extends('layouts.master')

@section('title')
<i class="fa fa-shield"></i> {{ __('messages.createpermission') }}
@endsection

@section('subtitle')
{{ __('messages.createpermissionsub') }}
@endsection

@section('content')
<form action="{{ route('admin.permissions.store') }}" method="POST" aria-label="{{ __('messages.createpermission') }}" class="form-horizontal">
    @include('permissions.partial')
</form>
@endsection