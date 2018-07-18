@extends('layouts.master')

@section('title')
<i class="fa fa-tags"></i> {{ __('messages.viewrole') }}
@endsection

@section('subtitle')
{{ __('messages.viewrolesub') }}
@endsection

@section('content')
<form class="form-horizontal">
    <div class="form-group">
        <div class="col-xs-3">
            <label for="name" class="control-label">{{ __('messages.name') }}</label>
        </div>
        <div class="col-xs-9">
            <p id="name" class="form-control-static">{{ $role->name }}</p>
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-3">
            <label for="slug" class="control-label">{{ __('messages.slug') }}</label>
        </div>
        <div class="col-xs-9">
            <p id="slug" class="form-control-static">{{ $role->slug }}</p>
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-3">
            <label for="verified_at" class="control-label">{{ __('Verified at') }}</label>
        </div>
        <div class="col-xs-9">
            <p id="verified_at" class="form-control-static">{{ $user->verified_at }}</p>
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-3">
            <label for="active" class="control-label">{{ __('Active') }}</label>
        </div>
        <div class="col-xs-9">
            @if ($user->active)
            <p id="active" class="form-control-static"><span class="label label-success">{{ strtoupper(__('Active')) }}</p>
                @else
                <p id="active" class="form-control-static"><span class="label label-danger">{{ strtoupper(__('Inactive')) }}</p>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-3">
                    <label for="created_at" class="control-label">{{ __('Created at') }}</label>
                </div>
                <div class="col-xs-9">
                    <p id="created_at" class="form-control-static">{{ $user->created_at->toDayDateTimeString() }}</p>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-3">
                    <label for="created_by" class="control-label">{{ __('Created by') }}</label>
                </div>
                @isset($user->creator)
                <div class="col-xs-9">
                    <p id="created_by" class="form-control-static">{{ $user->creator->name }}</p>
                </div>
                @endisset
            </div>
            <div class="form-group">
                <div class="col-xs-3">
                    <label for="updated_at" class="control-label">{{ __('Updated at') }}</label>
                </div>
                <div class="col-xs-9">
                    <p id="updated_at" class="form-control-static">{{ $user->updated_at->toDayDateTimeString() }}</p>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-3">
                    <label for="updated_by" class="control-label">{{ __('Updated by') }}</label>
                </div>
                @isset($user->editor)
                <div class="col-xs-9">
                    <p id="updated_by" class="form-control-static">{{ $user->editor->name }}</p>
                </div>
                @endisset
            </div>
            @isset($user->deleted_at)
            <div class="form-group">
                <div class="col-xs-3">
                    <label for="deleed_at" class="control-label">{{ __('Deleted at') }}</label>
                </div>
                <div class="col-xs-9">
                    <p id="deleted_at" class="form-control-static">{{ $user->deleted_at->toDayDateTimeString() }}</p>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-3">
                    <label for="deleted_by" class="control-label">{{ __('Deleted by') }}</label>
                </div>
                <div class="col-xs-9">
                    <p id="deleted_by" class="form-control-static">{{ $user->destroyer->name }}</p>
                </div>
            </div>
            @endisset
            @isset($user->roles)
            <div class="form-group">
                <div class="col-xs-3">
                    <label for="roles" class="control-label">{{ __('Roles') }}</label>
                </div>
                <div class="col-xs-9">
                    <p id="roles" class="form-control-static">
                        @forelse ($user->roles as $role)
                        <span class="label label-info">{{ $role->name }}</span>&nbsp;
                        @empty
                        {{ __('messages.user') }}
                        @endforelse
                    </p>
                </div>
            </div>            
            @endisset
            @if (isset($user->permissions) && !empty($user->permissions))
            <div class="form-group">
                <div class="col-xs-3">
                    <label for="permissions" class="control-label">{{ __('messages.permissions') }}</label>
                </div>
                <div class="col-xs-9">
                    <p id="roles" class="form-control-static">
                        @forelse ($user->permissions as $permission)
                        <span class="label label-info">{{ $permission->slug }}</span>&nbsp; 
                        @empty 
                        {{ __('messages.user') }} 
                        @endforelse
                    </p>
                </div>
            </div>
            @endif            
        </form>
        @endsection