@section('boxtools')

@if (auth()->user()->hasPermissionTo('list-users') || auth()->user()->hasRole('administrator'))

<div class="btn-group pull-right" style="margin-right: 10px">
    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-default"><i class="fa fa-list"></i>&nbsp;List</a>
</div>

@endif

@endsection

@csrf

<!-- ID -->
<div class="form-group">
    <label class="col-sm-2 control-label">ID</label>
    <div class="col-sm-8">
        <div class="box box-solid box-default no-margin">
            <div class="box-body">
                {{ $user->id or __('messages.new') }}
            </div>
        </div>
    </div>
</div>
<!-- /ID -->

<!-- NAME -->
<div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
    <label for="name" class="col-sm-2 control-label">{{ __('messages.name') }}</label>
    <div class="col-sm-8">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
            <input type="text" class="form-control" placeholder="{{ __('messages.name') }}" name="name" value="{{ old('name', $user->name) }}" maxlength="150" required autofocus>
        </div>
    </div>
    @if ($errors->has('name'))
    <span class="help-block" role="alert">
        <strong>{{ $errors->first('name') }}</strong>
    </span>
    @endif
</div>
<!-- /NAME -->

<!-- EMAIL -->
<div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
    <label for="email" class="col-sm-2 control-label">{{ __('messages.email') }}</label>
    <div class="col-sm-8">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
            <input id="email" type="email" class="form-control" placeholder="{{ __('messages.email') }}" name="email" value="{{ old('email', $user->email) }}" maxlength="150" required>
        </div>
        @if ($errors->has('email'))
        <span class="help-block" role="alert">
            <strong>{{ $errors->first('email') }}</strong>
        </span>
        @endif
    </div>
</div>
<!-- /EMAIL -->

@unless (Route::is('*.create'))
<!-- OLD PASSWORD -->
<div class="form-group {{ $errors->has('old_password') ? ' has-error' : '' }}">
    <label for="old_password" class="col-sm-2 control-label">{{ __('messages.old_password') }}</label>
    <div class="col-sm-8">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-eye-slash"></i></span>
            <input type="password" class="form-control" placeholder="{{ __('messages.defaultoldpassword') }}"
                name="old_password" maxlength="150">
        </div>
        @if ($errors->has('old_password'))
        <span class="help-block" role="alert">
            <strong>{{ $errors->first('old_password') }}</strong>
        </span>
        @endif
    </div>
</div>
<!-- /OLD PASSWORD -->
@endunless

<!-- PASSWORD -->
<div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
    <label for="password" class="col-sm-2 control-label">{{ __('messages.password') }}</label>
    <div class="col-sm-8">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-eye-slash"></i></span>
            <input type="password" class="form-control" placeholder="{{ Route::is('*.edit') ? __('messages.defaultpassword') : __('messages.password') }}" name="password" maxlength="150" {{ (!Route::is('*.edit')) ? 'required' : '' }}>
        </div>
        @if ($errors->has('password'))
        <span class="help-block" role="alert">
            <strong>{{ $errors->first('password') }}</strong>
        </span>
        @endif
    </div>
</div>
<!-- /PASSWORD -->

<!-- PASSWORD CONFIRMATION -->
<div class="form-group">
    <label for="password_confirmation" class="col-sm-2 control-label">{{ __('messages.retypepassword') }}</label>
    <div class="col-sm-8">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-eye-slash"></i></span>
            <input type="password" class="form-control" placeholder="{{ Route::is('*.edit') ? __('messages.defaultretypepassword') : __('messages.retypepassword') }}" name="password_confirmation" {{ (!Route::is('*.edit')) ? 'required' : '' }}>
        </div>
    </div>
</div>
<!-- /PASSWORD CONFIRMATION -->

@if (auth()->user()->hasPermissionTo('edit-users') || auth()->user()->hasRole('administrator'))

<!-- ROLES -->
<div class="form-group {{ $errors->has('roles') ? ' has-error' : '' }}">
    <label class="col-sm-2 control-label">{{ __('messages.roles') }}</label>
    <div class="col-sm-8">
        @component('components.select2', ['datasource' => $roles, 'multiple' => true, 'values' => $user->roles])
        @slot('name')
        roles
        @endslot
        @endcomponent
    </div>
</div>
<!-- /ROLES -->

<!-- PERMISSIONS -->
<div class="form-group {{ $errors->has('permissions') ? ' has-error' : '' }}">
    <label class="col-sm-2 control-label">{{ __('messages.permissions') }}</label>
    <div class="col-sm-8">
        @component('components.select2', ['datasource' => $permissions, 'multiple' => true, 'values' => $user->permissions])
        @slot('name')
        permissions
        @endslot
        @endcomponent
    </div>
</div>
<!-- /PERMISSIONS -->

<!-- VERIFIED -->
<div class="form-group {{ $errors->has('verified') ? ' has-error' : '' }}">
    <label for="verified" class="col-sm-2 control-label">{{ __('messages.verifiedlabel') }}</label>
    <div class="col-sm-8">
        @component('components.icheck', ['condition' => $user->verified])
        @slot('name')
        verified
        @endslot
        @endcomponent
    </div>
</div>
<!-- /VERIFIED -->

@unless (Route::is('*.create'))

<!-- VERIFIED AT -->
<div class="form-group">
    <label class="col-sm-2 control-label">{{ __('messages.verifiedat') }}</label>
    <div class="col-sm-8">
        <div class="box box-solid box-default no-margin">
            <div class="box-body">
                {{ $user->verified_at or "N/A" }}
            </div>
        </div>
    </div>
</div>
<!-- /VERIFIED AT -->

<!-- CREATED AT -->
<div class="form-group">
    <label class="col-sm-2 control-label">{{ __('messages.createdat') }}</label>
    <div class="col-sm-8">
        <div class="box box-solid box-default no-margin">
            <div class="box-body">
                {{ $user->created_at or __('messages.new') }}
            </div>
        </div>
    </div>
</div>
<!-- /CREATED AT -->

<!-- UPDATED AT -->
<div class="form-group">
    <label class="col-sm-2 control-label">{{ __('messages.updatedat') }}</label>
    <div class="col-sm-8">
        <div class="box box-solid box-default no-margin">
            <div class="box-body">
                {{ $user->updated_at or __('messages.new') }}
            </div>
        </div>
    </div>
</div>
<!-- /UPDATED AT -->

<!-- LAST LOGIN AT -->
<div class="form-group">
    <label class="col-sm-2 control-label">{{ __('messages.lastloginat') }}</label>
    <div class="col-sm-8">
        <div class="box box-solid box-default no-margin">
            <div class="box-body">
                {{ $user->last_login_at or __('messages.new') }}
            </div>
        </div>
    </div>
</div>
<!-- /LAST LOGIN AT -->

@endunless

<!-- ACTIVE -->
<div class="form-group {{ $errors->has('active') ? ' has-error' : '' }}">
    <label for="active" class="col-sm-2 control-label">{{ __('messages.active') }}</label>
    <div class="col-sm-8">
        @component('components.icheck', ['condition' => $user->active])
        @slot('name')
        active
        @endslot
        @endcomponent
    </div>
</div>
<!-- ACTIVE -->

@endif

<div class="box-footer">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="btn-group pull-right">
            <button type="submit" class="btn btn-info pull-right" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Submit">Submit</button>
        </div>
        <div class="btn-group pull-left">
            <button type="reset" class="btn btn-warning">Reset</button>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="{{ asset('css/tags.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/tags.js') }}"></script>
@endpush
