@extends('layouts.master')

@section('title')
<i class="fa fa-edit"></i> {{ __('messages.editpermission') }}
@endsection

@section('subtitle')
{{ __('messages.editpermissionsub') }}
@endsection

@section('content')
@php
$prefix = Route::is('admin.*') ? 'admin.' : '';
@endphp
<form action="{{ route($prefix.'permissions.update', ['id' => $permission->id]) }}" method="POST" aria-label="{{ __('messages.editpermission') }}" class="form-horizontal">
    {{ method_field('PUT') }}
    @include('permissions.partial')
</form>
@endsection
