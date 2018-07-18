@extends('layouts.master')

@section('title')
<i class="fa fa-user"></i> View User
@endsection

@section('subtitle')
(View a user.)
@endsection

@section('content')
<form class="form-horizontal">
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">{{ __('Name') }}</label>
        <div class="col-sm-8">
            <p id="name" class="form-control-static">{{ $user->name }}</p>
        </div>
    </div>
    <div class="form-group">
        <label for="email" class="col-sm-2 control-label">{{ __('Email Address') }}</label>
        <div class="col-xs-8">
            <p id="email" class="form-control-static">{{ $user->email }}</p>
        </div>
    </div>
    <div class="form-group">
        <label for="verified_at" class="col-sm-2 control-label">{{ __('Verified at') }}</label>
        <div class="col-xs-8">
            <p id="verified_at" class="form-control-static">{{ $user->verified_at }}</p>
        </div>
    </div>
    <div class="form-group">
        <label for="active" class="col-sm-2 control-label">{{ __('Active') }}</label>
        <div class="col-xs-8">
            @if ($user->active)
            <p id="active" class="form-control-static"><span class="label label-success">{{ strtoupper(__('Active')) }}</p>
                @else
                <p id="active" class="form-control-static"><span class="label label-danger">{{ strtoupper(__('Inactive')) }}</p>
                    @endif
                </div>
            </div>
            <div class="col-sm-5">
                <div class="box box-solid box-default no-margin">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="created_at" class="col-sm-3 control-label">{{ __('Created at') }}</label>
                            <div class="col-sm-9">
                                <p id="created_at" class="form-control-static">{{ $user->created_at->toDayDateTimeString() }}</p>
                            </div>
                        </div>
                        @isset($user->creator)
                        <div class="form-group">
                            <label for="created_by" class="col-sm-3 control-label">{{ __('Created by') }}</label>
                            <div class="col-sm-9">
                                <p id="created_by" class="form-control-static">{{ $user->creator->name }}</p>
                            </div>
                        </div>
                        @endisset
                    </div>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="box box-solid box-default no-margin">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="updated_at" class="col-sm-3 control-label">{{ __('Updated at') }}</label>
                            <div class="col-sm-9">
                                <p id="updated_at" class="form-control-static">{{ $user->updated_at->toDayDateTimeString() }}</p>
                            </div>
                        </div>
                        @isset($user->editor)
                        <div class="form-group">
                            <label for="updated_by" class="col-sm-3 control-label">{{ __('Updated by') }}</label>
                            <div class="col-sm-9">
                                <p id="updated_by" class="form-control-static">{{ $user->editor->name }}</p>
                            </div>
                        </div>
                        @endisset
                    </div>
                </div>
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