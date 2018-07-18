@extends('layouts.master')

@section('title')
<i class="fa fa-edit"></i> {{ __('messages.editrole') }}
@endsection

@section('subtitle')
{{ __('messages.editrolesub') }}
@endsection

@section('content')
@php
$prefix = Route::is('admin.*') ? 'admin.' : '';
@endphp
<form action="{{ route($prefix.'roles.update', ['id' => $role->id]) }}" method="POST" aria-label="{{ __('messages.editrole') }}" class="form-horizontal">
    {{ method_field('PUT') }}
    @include('roles.partial')
</form>
@endsection