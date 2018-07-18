@extends('layouts.master')

@section('title')
<i class="fa fa-tag"></i> {{ __('messages.createrole') }}
@endsection

@section('subtitle')
{{ __('messages.createrolesub') }}
@endsection

@section('content')
<form action="{{ route('admin.roles.store') }}" method="POST" aria-label="{{ __('messages.createrole') }}" class="form-horizontal">
    @include('roles.partial')
</form>
@endsection