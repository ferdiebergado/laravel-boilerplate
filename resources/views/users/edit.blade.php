@extends('layouts.master')

@section('title')
<i class="fa fa-edit"></i> {{ __('messages.edituser') }}
@endsection

@section('subtitle')
{{ __('messages.editusersub') }}
@endsection

@section('content')
@php
$prefix = Route::is('admin.*') ? 'admin.' : '';
@endphp
<form action="{{ route($prefix.'users.update', ['id' => $user->id]) }}" method="POST" aria-label="{{ __('messages.edituser') }}" class="form-horizontal">
    {{ method_field('PUT') }}
    @include('users.partial')
</form>
@endsection