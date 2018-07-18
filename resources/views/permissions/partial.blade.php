@section('boxtools')

@if (auth()->user()->hasPermissionTo('list-permissions') || auth()->user()->hasRole('administrator'))
<div class="btn-group pull-right" style="margin-right: 10px">
    <a href="{{ route('admin.permissions.index') }}" class="btn btn-sm btn-default"><i class="fa fa-list"></i>&nbsp;List</a>
</div>
@endif

@endsection

@csrf

<div class="form-group">
    <label class="col-sm-2 control-label">ID</label>
    <div class="col-sm-8">
        <div class="box box-solid box-default no-margin">
            <div class="box-body">
                {{ $permission->id or __('messages.new') }}
            </div>
        </div>
    </div>
</div>

<div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
    <label for="name" class="col-sm-2 control-label">{{ __('messages.name') }}</label>
    <div class="col-sm-8">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
            <input type="text" class="form-control" placeholder="{{ __('messages.name') }}" name="name" value="{{ old('name', $permission->name) }}" maxlength="150" required autofocus>
        </div>
    </div>
    @if ($errors->has('name'))
    <span class="help-block" role="alert">
        <strong>{{ $errors->first('name') }}</strong>
    </span>
    @endif
</div>

<div class="form-group {{ $errors->has('slug') ? ' has-error' : '' }}">
    <label for="slug" class="col-sm-2 control-label">{{ __('messages.slug') }}</label>
    <div class="col-sm-8">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
            <input id="email" type="text" class="form-control" placeholder="{{ __('messages.slug') }}" name="slug" value="{{ old('slug', $permission->slug) }}" maxlength="150" required>
        </div>
        @if ($errors->has('slug'))
        <span class="help-block" role="alert">
            <strong>{{ $errors->first('slug') }}</strong>
        </span>
        @endif
    </div>
</div>

@unless (Route::is('*.create'))

<div class="form-group">
    <label class="col-sm-2 control-label">{{ __('messages.createdat') }}</label>
    <div class="col-sm-8">
        <div class="box box-solid box-default no-margin">
            <div class="box-body">
                {{ $permission->created_at or __('messages.new') }}
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">{{ __('messages.updatedat') }}</label>
    <div class="col-sm-8">
        <div class="box box-solid box-default no-margin">
            <div class="box-body">
                {{ $permission->updated_at or __('messages.new') }}
            </div>
        </div>
    </div>
</div>

@endunless

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
